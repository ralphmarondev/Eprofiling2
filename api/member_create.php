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
	// STEP 1: Get Family ID and Validate
	// ============================================
	$familyId = isset($_POST["family_id"]) ? intval($_POST["family_id"]) : 0;
	$familyCode = trim($_POST["family_code"] ?? "");

	if ($familyId === 0) {
		throw new Exception("Family ID is required.");
	}

	// Check if family exists
	$stmt = $mysqli->prepare("SELECT id, name, family_code FROM families WHERE id = ? AND status = 'active'");
	$stmt->bind_param("i", $familyId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0) {
		throw new Exception("Family not found or inactive.");
	}

	$family = $result->fetch_assoc();
	$familyName = $family['name'];
	$familyCode = $family['family_code'];
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
	$occupation = trim($_POST["occupation"] ?? "");
	$educationalAttainment = trim($_POST["educational_attainment"] ?? "");
	$relationshipToHead = trim($_POST["relationship_to_head"] ?? "child");
	$isHead = ($relationshipToHead === 'head') ? 1 : 0;

	// Beneficiary fields
	$isIndigenous = isset($_POST["is_indigenous"]) ? intval($_POST["is_indigenous"]) : 0;
	$indigenousGroup = trim($_POST["indigenous_group"] ?? "");
	$isBeneficiary = isset($_POST["is_beneficiary"]) ? intval($_POST["is_beneficiary"]) : 0;
	$isVoter = isset($_POST["is_voter"]) ? intval($_POST["is_voter"]) : 0;
	$programIds = trim($_POST["program_ids"] ?? "");

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

	// Validate indigenous group if is_indigenous is 1
	if ($isIndigenous == 1 && empty($indigenousGroup)) {
		throw new Exception("Indigenous group is required when member belongs to an indigenous group.");
	}

	// Validate beneficiary programs if is_beneficiary is 1
	if ($isBeneficiary == 1 && empty($programIds)) {
		throw new Exception("At least one program must be selected when member is a beneficiary.");
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
            occupation,
            educational_attainment,
            is_head,
            relationship_to_head,
            is_indigenous,
            indigenous_group,
            is_voter
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

	$stmt->bind_param(
		"issssssssssssisssi",
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
		$occupation,
		$educationalAttainment,
		$isHead,
		$relationshipToHead,
		$isIndigenous,
		$indigenousGroup,
		$isVoter
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create member: " . $stmt->error);
	}

	$memberId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 6: Insert Beneficiary Programs
	// ============================================
	if ($isBeneficiary == 1 && !empty($programIds)) {
		$programArray = array_map('intval', explode(',', $programIds));

		// Insert member_programs relationships
		$stmt = $mysqli->prepare("
            INSERT INTO member_beneficiaries (member_id, program_id) 
            VALUES (?, ?)
        ");

		foreach ($programArray as $programId) {
			if ($programId > 0) {
				// Verify program exists
				$checkStmt = $mysqli->prepare("SELECT id FROM beneficiary_programs WHERE id = ?");
				$checkStmt->bind_param("i", $programId);
				$checkStmt->execute();
				$checkResult = $checkStmt->get_result();
				if ($checkResult->num_rows > 0) {
					$stmt->bind_param("ii", $memberId, $programId);
					if (!$stmt->execute()) {
						throw new Exception("Failed to add beneficiary program: " . $stmt->error);
					}
				}
				$checkStmt->close();
			}
		}
		$stmt->close();
	}

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
			"is_head" => $isHead,
			"is_indigenous" => $isIndigenous,
			"is_beneficiary" => $isBeneficiary,
			"is_voter" => $isVoter
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