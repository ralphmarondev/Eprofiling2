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
	// STEP 1: Get Family Data
	// ============================================
	$familyName = trim($_POST["family_name"] ?? "");
	$familyCode = trim($_POST["family_code"] ?? "");
	$householdNumber = trim($_POST["household_number"] ?? "");
	$householdType = trim($_POST["household_type"] ?? "");
	$housingOwnership = trim($_POST["housing_ownership"] ?? "");
	$contactNumber = trim($_POST["contact_number"] ?? "");
	$address = trim($_POST["address"] ?? "");

	// Get individual address fields if full address not provided
	if (empty($address)) {
		$houseNo = trim($_POST["house_no"] ?? "");
		$barangay = trim($_POST["barangay"] ?? "");
		$municipality = trim($_POST["municipality"] ?? "");
		$province = trim($_POST["province"] ?? "");
		$address = trim($houseNo . ", " . $barangay . ", " . $municipality . ", " . $province);
	}

	// Status with default 'pending' registration
	$status = trim($_POST["status"] ?? "active");
	$registrationStatus = trim($_POST["registration_status"] ?? "pending");

	// Validate status if provided
	if (!empty($_POST["status"])) {
		$validStatuses = ['active', 'inactive'];
		if (!in_array($status, $validStatuses)) {
			throw new Exception("Invalid status value. Allowed values: " . implode(', ', $validStatuses));
		}
	}

	// Validate required family fields
	if (empty($familyName)) {
		throw new Exception("Family name is required.");
	}
	if (empty($familyCode)) {
		throw new Exception("Family code is required.");
	}
	if (empty($address)) {
		throw new Exception("Address is required.");
	}
	if (empty($householdType)) {
		throw new Exception("Household type is required.");
	}
	if (empty($housingOwnership)) {
		throw new Exception("Housing ownership is required.");
	}

	// ============================================
	// STEP 2: Get Member Data (Head of Family)
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
	$isVoter = isset($_POST["is_voter"]) ? (int) $_POST["is_voter"] : 0;
	$isIndigenous = isset($_POST["is_indigenous"]) ? (int) $_POST["is_indigenous"] : 0;
	$indigenousGroup = trim($_POST["indigenous_group"] ?? "");

	// Is head is always true for this registration
	$isHead = 1;
	$relationshipToHead = 'head';

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

	// Validate indigenous group if indigenous is yes
	if ($isIndigenous == 1 && empty($indigenousGroup)) {
		throw new Exception("Indigenous group is required when the member is part of an indigenous group.");
	}

	// ============================================
	// STEP 3: Get Beneficiary Data
	// ============================================
	$isBeneficiary = isset($_POST["is_beneficiary"]) ? (int) $_POST["is_beneficiary"] : 0;
	$programIds = trim($_POST["program_ids"] ?? "");

	// Validate beneficiary programs if beneficiary is yes
	if ($isBeneficiary == 1 && empty($programIds)) {
		throw new Exception("At least one beneficiary program must be selected.");
	}

	// ============================================
	// STEP 4: Get Account Data
	// ============================================
	$username = trim($_POST["username"] ?? "");
	$email = trim($_POST["email"] ?? "");
	$password = $_POST["password"] ?? "";

	// Validate required account fields
	if (empty($username)) {
		throw new Exception("Username is required.");
	}
	if (empty($password)) {
		throw new Exception("Password is required.");
	}
	if (strlen($password) < 6) {
		throw new Exception("Password must be at least 6 characters.");
	}

	// Validate username format (alphanumeric and underscore only)
	if (!preg_match('/^[a-zA-Z0-9_]{3,}$/', $username)) {
		throw new Exception("Username must be at least 3 characters and contain only letters, numbers, and underscore.");
	}

	// ============================================
	// STEP 5: Check for Duplicates
	// ============================================

	// Check if family code exists
	$stmt = $mysqli->prepare("SELECT id FROM families WHERE family_code = ?");
	$stmt->bind_param("s", $familyCode);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		throw new Exception("Family code '" . $familyCode . "' already exists.");
	}
	$stmt->close();

	// Check if username exists
	$stmt = $mysqli->prepare("SELECT id FROM accounts WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		throw new Exception("Username '" . $username . "' already exists.");
	}
	$stmt->close();

	// Check email if provided
	if (!empty($email)) {
		$stmt = $mysqli->prepare("SELECT id FROM accounts WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			throw new Exception("Email '" . $email . "' already exists.");
		}
		$stmt->close();
	}

	// ============================================
	// STEP 6: Insert Family
	// ============================================
	$stmt = $mysqli->prepare("
        INSERT INTO families (
            family_code,
            name,
            household_number,
            household_type,
            housing_ownership,
            contact_number,
            address,
            status,
            registration_status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

	$stmt->bind_param(
		"sssssssss",
		$familyCode,
		$familyName,
		$householdNumber,
		$householdType,
		$housingOwnership,
		$contactNumber,
		$address,
		$status,
		$registrationStatus
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create family: " . $stmt->error);
	}

	$familyId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 7: Insert Member (Head of Family)
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
            is_voter,
            is_indigenous,
            indigenous_group
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

	$stmt->bind_param(
		"issssssssssssissss",
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
		$isVoter,
		$isIndigenous,
		$indigenousGroup
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create member: " . $stmt->error);
	}

	$memberId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 8: Insert Beneficiary Programs
	// ============================================
	if ($isBeneficiary == 1 && !empty($programIds)) {
		$programIdArray = array_map('trim', explode(',', $programIds));

		$stmt = $mysqli->prepare("
            INSERT INTO member_beneficiaries (
                member_id,
                program_id
            ) VALUES (?, ?)
        ");

		foreach ($programIdArray as $programId) {
			if (!empty($programId) && is_numeric($programId)) {
				$stmt->bind_param("ii", $memberId, $programId);
				if (!$stmt->execute()) {
					throw new Exception("Failed to add beneficiary program: " . $stmt->error);
				}
			}
		}
		$stmt->close();
	}

	// ============================================
	// STEP 9: Insert Account
	// ============================================
	$roleId = 3; // Default family_admin role
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	$isDeleted = 0;

	$stmt = $mysqli->prepare("
        INSERT INTO accounts (
            username,
            email,
            password_hash,
            member_id,
            role_id,
            is_deleted
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");

	$stmt->bind_param(
		"ssssii",
		$username,
		$email,
		$hashedPassword,
		$memberId,
		$roleId,
		$isDeleted
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create account: " . $stmt->error);
	}

	$accountId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 10: Commit Transaction
	// ============================================
	$mysqli->commit();

	// ============================================
	// Return Success Response
	// ============================================
	http_response_code(201);
	echo json_encode([
		"success" => true,
		"message" => "Family registered successfully!",
		"data" => [
			"family_id" => $familyId,
			"family_code" => $familyCode,
			"family_name" => $familyName,
			"status" => $status,
			"registration_status" => $registrationStatus,
			"member_id" => $memberId,
			"member_name" => trim($firstName . " " . ($middleName ? $middleName . " " : "") . $lastName),
			"is_beneficiary" => $isBeneficiary,
			"programs_selected" => $isBeneficiary == 1 ? count(explode(',', $programIds)) : 0,
			"account_id" => $accountId,
			"username" => $username
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