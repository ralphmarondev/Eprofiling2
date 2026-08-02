<?php
require_once "../config/database.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	http_response_code(405);
	echo json_encode([
		"success" => false,
		"message" => "Method Not Allowed."
	]);
	exit;
}

// Get family ID
$familyId = isset($_POST["family_id"]) ? (int) $_POST["family_id"] : 0;

if ($familyId <= 0) {
	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => "Family ID is required."
	]);
	exit;
}

// Start transaction
$mysqli->begin_transaction();

try {
	// ============================================
	// STEP 1: Check if family exists and get details
	// ============================================
	$stmt = $mysqli->prepare("SELECT id, name, family_code FROM families WHERE id = ?");
	$stmt->bind_param("i", $familyId);
	$stmt->execute();
	$result = $stmt->get_result();
	$family = $result->fetch_assoc();
	$stmt->close();

	if (!$family) {
		throw new Exception("Family not found.");
	}

	// ============================================
	// STEP 2: Get all member IDs in this family
	// ============================================
	$memberIds = [];
	$stmt = $mysqli->prepare("SELECT id FROM members WHERE family_id = ?");
	$stmt->bind_param("i", $familyId);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($row = $result->fetch_assoc()) {
		$memberIds[] = $row['id'];
	}
	$stmt->close();

	// ============================================
	// STEP 3: Delete accounts for members
	// ============================================
	if (!empty($memberIds)) {
		$placeholders = implode(',', array_fill(0, count($memberIds), '?'));
		$types = str_repeat('i', count($memberIds));

		$stmt = $mysqli->prepare("DELETE FROM accounts WHERE member_id IN ($placeholders)");
		$stmt->bind_param($types, ...$memberIds);
		if (!$stmt->execute()) {
			throw new Exception("Failed to delete accounts: " . $stmt->error);
		}
		$stmt->close();
	}

	// ============================================
	// STEP 4: Delete beneficiary programs for members
	// ============================================
	if (!empty($memberIds)) {
		$placeholders = implode(',', array_fill(0, count($memberIds), '?'));
		$types = str_repeat('i', count($memberIds));

		$stmt = $mysqli->prepare("DELETE FROM member_beneficiaries WHERE member_id IN ($placeholders)");
		$stmt->bind_param($types, ...$memberIds);
		if (!$stmt->execute()) {
			throw new Exception("Failed to delete beneficiary programs: " . $stmt->error);
		}
		$stmt->close();
	}

	// ============================================
	// STEP 5: Delete members
	// ============================================
	$stmt = $mysqli->prepare("DELETE FROM members WHERE family_id = ?");
	$stmt->bind_param("i", $familyId);
	if (!$stmt->execute()) {
		throw new Exception("Failed to delete members: " . $stmt->error);
	}
	$stmt->close();

	// ============================================
	// STEP 6: Delete family
	// ============================================
	$stmt = $mysqli->prepare("DELETE FROM families WHERE id = ?");
	$stmt->bind_param("i", $familyId);
	if (!$stmt->execute()) {
		throw new Exception("Failed to delete family: " . $stmt->error);
	}
	$stmt->close();

	// ============================================
	// STEP 7: Commit transaction
	// ============================================
	$mysqli->commit();

	// ============================================
	// Return Success Response
	// ============================================
	http_response_code(200);
	echo json_encode([
		"success" => true,
		"message" => "Family '" . $family['name'] . "' has been deleted successfully.",
		"data" => [
			"family_id" => $familyId,
			"family_code" => $family['family_code'],
			"family_name" => $family['name'],
			"members_deleted" => count($memberIds)
		]
	]);

} catch (Exception $e) {
	// Rollback transaction on error
	$mysqli->rollback();

	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => $e->getMessage()
	]);
}

$mysqli->close();
?>