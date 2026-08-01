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
	$houseNo = trim($_POST["house_no"] ?? "");
	$barangay = trim($_POST["barangay"] ?? "");
	$municipality = trim($_POST["municipality"] ?? "");
	$province = trim($_POST["province"] ?? "");

	// Validate required family fields
	if (empty($familyName)) {
		throw new Exception("Family name is required.");
	}
	if (empty($familyCode)) {
		throw new Exception("Family code is required.");
	}
	if (empty($houseNo)) {
		throw new Exception("House number/street is required.");
	}
	if (empty($barangay)) {
		throw new Exception("Barangay is required.");
	}
	if (empty($municipality)) {
		throw new Exception("Municipality/City is required.");
	}
	if (empty($province)) {
		throw new Exception("Province is required.");
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

	// ============================================
	// STEP 3: Get Account Data
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

	// ============================================
	// STEP 4: Check for Duplicates
	// ============================================

	// Check if family code exists
	$stmt = $mysqli->prepare("SELECT id FROM family WHERE family_code = ?");
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
	// STEP 5: Insert Family
	// ============================================
	$address = trim($houseNo . ", " . $barangay . ", " . $municipality . ", " . $province);

	$stmt = $mysqli->prepare("
        INSERT INTO family (
            family_code,
            name,
            household_number,
            household_type,
            housing_ownership,
            contact_number,
            address,
            status,
            registration_status,
            created_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'active', 'approved', NOW())
    ");

	$stmt->bind_param(
		"sssssss",
		$familyCode,
		$familyName,
		$householdNumber,
		$householdType,
		$housingOwnership,
		$contactNumber,
		$address
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create family: " . $stmt->error);
	}

	$familyId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 6: Insert Member (Head of Family)
	// ============================================
	$isHead = 1;

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
            created_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

	$stmt->bind_param(
		"issssssssssi",
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
		$isHead
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create member: " . $stmt->error);
	}

	$memberId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 7: Insert Account
	// ============================================
	$roleId = 3; // Default FamilyAdmin role
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

	$stmt = $mysqli->prepare("
        INSERT INTO accounts (
            username,
            email,
            password,
            member_id,
            role_id,
            created_date
        ) VALUES (?, ?, ?, ?, ?, NOW())
    ");

	$stmt->bind_param(
		"sssii",
		$username,
		$email,
		$hashedPassword,
		$memberId,
		$roleId
	);

	if (!$stmt->execute()) {
		throw new Exception("Failed to create account: " . $stmt->error);
	}

	$accountId = $mysqli->insert_id;
	$stmt->close();

	// ============================================
	// STEP 8: Update Family with Head of Family
	// ============================================
	// Uncomment this if you want to track head of family in family table
	$stmt = $mysqli->prepare("UPDATE family SET head_of_family_id = ? WHERE id = ?");
	$stmt->bind_param("ii", $memberId, $familyId);
	$stmt->execute();
	$stmt->close();

	// Commit transaction
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
			"member_id" => $memberId,
			"member_name" => trim($firstName . " " . ($middleName ? $middleName . " " : "") . $lastName),
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