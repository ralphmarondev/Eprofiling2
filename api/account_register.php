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

$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$memberId = isset($_POST["member_id"]) && $_POST["member_id"] !== ""
	? intval($_POST["member_id"])
	: null;

$roleId = 4; // resident

// ============================================
// Validate Required Fields
// ============================================
if (
	empty($username) ||
	empty($password) ||
	$memberId === null
) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Please complete all required fields."
	]);

	exit;
}

// ============================================
// Validate Email (Optional)
// ============================================
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Invalid email address."
	]);

	exit;
}

// ============================================
// Check Username
// ============================================
$stmt = $mysqli->prepare("
	SELECT id
	FROM accounts
	WHERE username = ?
");

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

	$stmt->close();

	echo json_encode([
		"success" => false,
		"message" => "Username already exists."
	]);

	exit;
}

$stmt->close();

// ============================================
// Check Email
// ============================================
if (!empty($email)) {

	$stmt = $mysqli->prepare("
		SELECT id
		FROM accounts
		WHERE email = ?
	");

	$stmt->bind_param("s", $email);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {

		$stmt->close();

		echo json_encode([
			"success" => false,
			"message" => "Email already exists."
		]);

		exit;
	}

	$stmt->close();
}

// ============================================
// Check Member Exists
// ============================================
$stmt = $mysqli->prepare("
	SELECT id
	FROM members
	WHERE id = ?
");

$stmt->bind_param("i", $memberId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {

	$stmt->close();

	http_response_code(404);

	echo json_encode([
		"success" => false,
		"message" => "Member not found."
	]);

	exit;
}

$stmt->close();

// ============================================
// Check Member Already Has Account
// ============================================
$stmt = $mysqli->prepare("
	SELECT id
	FROM accounts
	WHERE member_id = ?
");

$stmt->bind_param("i", $memberId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

	$stmt->close();

	http_response_code(409);

	echo json_encode([
		"success" => false,
		"message" => "This member already has an account."
	]);

	exit;
}

$stmt->close();

// ============================================
// Create Account
// ============================================
$hashedPassword = password_hash(
	$password,
	PASSWORD_DEFAULT
);

$stmt = $mysqli->prepare("
	INSERT INTO accounts
	(
		role_id,
		member_id,
		username,
		email,
		password_hash
	)
	VALUES
	(
		?, ?, ?, ?, ?
	)
");

$stmt->bind_param(
	"iisss",
	$roleId,
	$memberId,
	$username,
	$email,
	$hashedPassword
);

if ($stmt->execute()) {

	http_response_code(201);

	echo json_encode([
		"success" => true,
		"message" => "Account created successfully."
	]);

} else {

	http_response_code(500);

	echo json_encode([
		"success" => false,
		"message" => "Unable to create account."
	]);
}

$stmt->close();
$mysqli->close();
?>