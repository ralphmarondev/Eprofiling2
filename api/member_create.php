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

// Start transaction
$mysqli->begin_transaction();

try {
	// ============================================
	// STEP 1: Get Family Code and Validate
	// ============================================
	$familyCode = trim($_POST["family_code"] ?? "");

	if (empty($familyCode)) {
		throw new Exception("Family code is required.");
	}

	// Check if family exists
	$stmt = $mysqli->prepare("SELECT id, name FROM families WHERE family_code = ? AND status = 'active'");
	$stmt->bind_param("s", $familyCode);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0) {
		throw new Exception("Family code not found or inactive.");
	}

	$family = $result->fetch_assoc();
	$familyId = $family['id'];
	$familyName = $family['name'];
	$stmt->close();

	// ============================================
	// STEP 2: Get Member Data
	// ============================================
	$firstName = trim($_POST["first_name"] ?? "");
	$middleName = trim($_POST["middle_name"] ?? "");
	$lastName = trim($_POST["last_name"] ?? "");
	$suffix = trim($_POST["suffix"] ?? "");
	$sex = trim($_POST["sex"] ?? "");
	$dateOfBirth = trim($_POST["date_of_birth"] ?? "");
	$placeOfBirth = trim($_POST["place_of_birth"] ?? "");
	$civilStatus = trim($_POST["civil_status"] ?? "");
	$nationality = trim($_POST["nationality"] ?? "");
	$religion = trim($_POST["religion"] ?? "");
	$relationshipToHead = trim($_POST["relationship_to_head"] ?? "child");
	$isHead = ($relationshipToHead === 'head') ? 1 : 0;

	// Validate required member fields
	if (empty($firstName)) {
		throw new Exception("First name is required.");
	}
	if (empty($lastName)) {
		throw new Exception("Last name is required.");
	}
	if (empty($sex)) {
		throw new Exception("Sex is required.");
	}
	if (empty($dateOfBirth)) {
		throw new Exception("Date of birth is required.");
	}
	if (empty($placeOfBirth)) {
		throw new Exception("Place of birth is required.");
	}
	if (empty($civilStatus)) {
		throw new Exception("Civil status is required.");
	}
	if (empty($nationality)) {
		throw new Exception("Nationality is required.");
	}
	if (empty($relationshipToHead)) {
		throw new Exception("Relationship to head is required.");
	}

	// ============================================
	// STEP 3: Check for Duplicate Member
	// ============================================
	$stmt = $mysqli->prepare("
        SELECT id FROM members 
        WHERE family_id = ? 
        AND first_name = ? 
        AND last_name = ? 
        AND date_of_birth = ?
    ");
	$stmt->bind_param("isss", $familyId, $firstName, $lastName, $dateOfBirth);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		throw new Exception("A member with the same name and birth date already exists in this family.");
	}
	$stmt->close();

	// ============================================
	// STEP 4: Check if adding head when one already exists
	// ============================================
	if ($isHead) {
		$stmt = $mysqli->prepare("SELECT id FROM members WHERE family_id = ? AND is_head = 1");
		$stmt->bind_param("i", $familyId);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			throw new Exception("This family already has a head. Please select a different relationship.");
		}
		$stmt->close();
	}

	// ============================================
	// STEP 5: Insert Member
	// ============================================
	$stmt = $mysqli->prepare("
        INSERT INTO members (
            family_id,
            first_name,
            middle_name,
            last_name,
            suffix,
            sex,
            date_of_birth,
            place_of_birth,
            civil_status,
            nationality,
            religion,
            is_head,
            relationship_to_head
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

	$stmt->bind_param(
		"issssssssssis",
		$familyId,
		$firstName,
		$middleName,
		$lastName,
		$suffix,
		$sex,
		$dateOfBirth,
		$placeOfBirth,
		$civilStatus,
		$nationality,
		$religion,
		$isHead,
		$relationshipToHead
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create member: " . $stmt->error);
	}

	$memberId = $mysqli->insert_id;
	$stmt->close();

	// Commit transaction
	$mysqli->commit();

	// ============================================
	// Return Success Response
	// ============================================
	http_response_code(201);
	echo json_encode([
		"success" => true,
		"message" => "Member added successfully!",
		"data" => [
			"member_id" => $memberId,
			"family_id" => $familyId,
			"family_code" => $familyCode,
			"family_name" => $familyName,
			"member_name" => trim($firstName . " " . ($middleName ? $middleName . " " : "") . $lastName),
			"relationship" => $relationshipToHead,
			"is_head" => $isHead
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