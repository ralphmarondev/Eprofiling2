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
	$familyId = isset($_POST["family_id"]) ? (int) $_POST["family_id"] : 0;
	$familyName = trim($_POST["family_name"] ?? "");
	$familyCode = trim($_POST["family_code"] ?? "");
	$householdNumber = trim($_POST["household_number"] ?? "");
	$householdType = trim($_POST["household_type"] ?? "");
	$housingOwnership = trim($_POST["housing_ownership"] ?? "");
	$contactNumber = trim($_POST["contact_number"] ?? "");
	$address = trim($_POST["address"] ?? "");
	$status = trim($_POST["status"] ?? "active");
	$registrationStatus = trim($_POST["registration_status"] ?? "pending");

	// Get individual address fields if full address not provided
	if (empty($address)) {
		$houseNo = trim($_POST["house_no"] ?? "");
		$barangay = trim($_POST["barangay"] ?? "");
		$municipality = trim($_POST["municipality"] ?? "");
		$province = trim($_POST["province"] ?? "");
		$address = trim($houseNo . ", " . $barangay . ", " . $municipality . ", " . $province);
	}

	// Validate required fields
	if ($familyId <= 0) {
		throw new Exception("Family ID is required.");
	}
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

	// Validate status
	$validStatuses = ['active', 'inactive'];
	if (!in_array($status, $validStatuses)) {
		throw new Exception("Invalid status value. Allowed values: " . implode(', ', $validStatuses));
	}

	// Validate registration status
	$validRegistrationStatuses = ['pending', 'approved', 'rejected'];
	if (!in_array($registrationStatus, $validRegistrationStatuses)) {
		throw new Exception("Invalid registration status value. Allowed values: " . implode(', ', $validRegistrationStatuses));
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
	$relationshipToHead = trim($_POST["relationship_to_head"] ?? "head");

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

	// Validate username format (alphanumeric and underscore only)
	if (!preg_match('/^[a-zA-Z0-9_]{3,}$/', $username)) {
		throw new Exception("Username must be at least 3 characters and contain only letters, numbers, and underscore.");
	}

	// Validate password if provided
	if (!empty($password) && strlen($password) < 6) {
		throw new Exception("Password must be at least 6 characters.");
	}

	// ============================================
	// STEP 5: Check for Duplicates
	// ============================================

	// Check if family code exists (excluding current family)
	$stmt = $mysqli->prepare("SELECT id FROM families WHERE family_code = ? AND id != ?");
	$stmt->bind_param("si", $familyCode, $familyId);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		throw new Exception("Family code '" . $familyCode . "' already exists.");
	}
	$stmt->close();

	// Check if username exists (excluding current user's account)
	$stmt = $mysqli->prepare("
        SELECT a.id 
        FROM accounts a 
        INNER JOIN members m ON a.member_id = m.id 
        WHERE a.username = ? AND m.family_id != ?
    ");
	$stmt->bind_param("si", $username, $familyId);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		throw new Exception("Username '" . $username . "' already exists.");
	}
	$stmt->close();

	// Check email if provided (excluding current user's account)
	if (!empty($email)) {
		$stmt = $mysqli->prepare("
            SELECT a.id 
            FROM accounts a 
            INNER JOIN members m ON a.member_id = m.id 
            WHERE a.email = ? AND m.family_id != ?
        ");
		$stmt->bind_param("si", $email, $familyId);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			throw new Exception("Email '" . $email . "' already exists.");
		}
		$stmt->close();
	}

	// ============================================
	// STEP 6: Update Family
	// ============================================
	$stmt = $mysqli->prepare("
        UPDATE families 
        SET 
            name = ?,
            household_number = ?,
            household_type = ?,
            housing_ownership = ?,
            contact_number = ?,
            address = ?,
            status = ?,
            registration_status = ?
        WHERE id = ?
    ");

	$stmt->bind_param(
		"ssssssssi",
		$familyName,
		$householdNumber,
		$householdType,
		$housingOwnership,
		$contactNumber,
		$address,
		$status,
		$registrationStatus,
		$familyId
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to update family: " . $stmt->error);
	}
	$stmt->close();

	// ============================================
	// STEP 7: Get Head Member ID
	// ============================================
	$stmt = $mysqli->prepare("SELECT id FROM members WHERE family_id = ? AND is_head = 1");
	$stmt->bind_param("i", $familyId);
	$stmt->execute();
	$result = $stmt->get_result();
	$headMember = $result->fetch_assoc();

	if (!$headMember) {
		throw new Exception("Head of family not found.");
	}

	$memberId = $headMember['id'];
	$stmt->close();

	// ============================================
	// STEP 8: Update Member (Head of Family)
	// ============================================
	$stmt = $mysqli->prepare("
        UPDATE members 
        SET 
            first_name = ?,
            middle_name = ?,
            last_name = ?,
            suffix = ?,
            sex = ?,
            date_of_birth = ?,
            place_of_birth = ?,
            civil_status = ?,
            nationality = ?,
            religion = ?,
            occupation = ?,
            educational_attainment = ?,
            relationship_to_head = ?,
            is_voter = ?,
            is_indigenous = ?,
            indigenous_group = ?
        WHERE id = ?
    ");

	$stmt->bind_param(
		"sssssssssssssissi",
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
		$relationshipToHead,
		$isVoter,
		$isIndigenous,
		$indigenousGroup,
		$memberId
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to update member: " . $stmt->error);
	}
	$stmt->close();

	// ============================================
	// STEP 9: Update Beneficiary Programs
	// ============================================

	// First, delete existing beneficiary programs for this member
	$stmt = $mysqli->prepare("DELETE FROM member_beneficiaries WHERE member_id = ?");
	$stmt->bind_param("i", $memberId);
	if (!$stmt->execute()) {
		throw new Exception("Failed to remove existing beneficiary programs: " . $stmt->error);
	}
	$stmt->close();

	// Then insert new beneficiary programs if beneficiary is yes
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
	// STEP 10: Get Account ID
	// ============================================
	$stmt = $mysqli->prepare("SELECT id FROM accounts WHERE member_id = ?");
	$stmt->bind_param("i", $memberId);
	$stmt->execute();
	$result = $stmt->get_result();
	$account = $result->fetch_assoc();

	if (!$account) {
		throw new Exception("Account not found.");
	}

	$accountId = $account['id'];
	$stmt->close();

	// ============================================
	// STEP 11: Update Account
	// ============================================
	$roleId = 3; // Default family_admin role

	if (!empty($password)) {
		// Update with new password
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $mysqli->prepare("
            UPDATE accounts 
            SET 
                username = ?,
                email = ?,
                password_hash = ?,
                role_id = ?
            WHERE id = ?
        ");
		$stmt->bind_param("sssii", $username, $email, $hashedPassword, $roleId, $accountId);
	} else {
		// Update without changing password
		$stmt = $mysqli->prepare("
            UPDATE accounts 
            SET 
                username = ?,
                email = ?,
                role_id = ?
            WHERE id = ?
        ");
		$stmt->bind_param("ssii", $username, $email, $roleId, $accountId);
	}

	if (!$stmt->execute()) {
		throw new Exception("Failed to update account: " . $stmt->error);
	}
	$stmt->close();

	// ============================================
	// STEP 12: Commit Transaction
	// ============================================
	$mysqli->commit();

	// ============================================
	// Return Success Response
	// ============================================
	http_response_code(200);
	echo json_encode([
		"success" => true,
		"message" => "Family updated successfully!",
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