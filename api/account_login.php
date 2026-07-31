<?php
session_start();
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
$password = $_POST["password"] ?? "";

if (
	empty($username) ||
	empty($password)
) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Please complete all required fields."
	]);

	exit;
}

$stmt = $mysqli->prepare("
	SELECT
		a.id,
		a.username,
		a.email,
		a.password,
		a.member_id,
		a.role_id,
		r.name AS role
	FROM accounts a
	INNER JOIN role r
		ON a.role_id = r.id
	WHERE
		a.username = ?
		AND a.is_deleted = 0
	LIMIT 1
");

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
	http_response_code(401);

	echo json_encode([
		"success" => false,
		"message" => "Invalid username or password."
	]);
	exit;
}

$account = $result->fetch_assoc();

if (!password_verify($password, $account["password"])) {
	http_response_code(401);
	echo json_encode([
		"success" => false,
		"message" => "Invalid username or password."
	]);

	exit;
}

// Create Session
$_SESSION["account_id"] = $account["id"];
$_SESSION["member_id"] = $account["member_id"];
$_SESSION["role_id"] = $account["role_id"];
$_SESSION["username"] = $account["username"];
$_SESSION["role"] = $account["role"];

// Remove password before returning data
unset($account["password"]);
echo json_encode([
	"success" => true,
	"message" => "Login successful.",
	"account" => $account
]);

$stmt->close();
$mysqli->close();

?>