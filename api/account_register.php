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
$roleId = 4; // Default User

if (
	empty($username) ||
	empty($email) ||
	empty($password)
) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Please complete all required fields."
	]);

	exit;
}

// Check username
$stmt = $mysqli->prepare("SELECT id FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
	echo json_encode([
		"success" => false,
		"message" => "Username already exists."
	]);

	exit;
}

$stmt->close();

// Check email
$stmt = $mysqli->prepare("SELECT id FROM accounts WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
	echo json_encode([
		"success" => false,
		"message" => "Email already exists."
	]);
	exit;
}

$stmt->close();
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("
    INSERT INTO accounts
    (
        username,
        email,
        password,
        member_id,
        role_id
    )
    VALUES
    (?, ?, ?, ?, ?)
");

$stmt->bind_param(
	"sssii",
	$username,
	$email,
	$hashedPassword,
	$memberId,
	$roleId
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