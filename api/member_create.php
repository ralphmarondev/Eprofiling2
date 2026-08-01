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

$firstName = trim($_POST["first_name"] ?? "");
$lastName = trim($_POST["last_name"] ?? "");
$middleName = trim($_POST["middle_name"] ?? "");
$suffix = trim($_POST["suffix"] ?? "");
$age = intval($_POST["age"] ?? 0);
$familyId = intval($_POST["family_id"] ?? 0);

if (empty($firstName)) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "First name is required."
	]);

	exit;
}

if (empty($lastName)) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Last name is required."
	]);

	exit;
}

if ($age <= 0) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Age is required."
	]);

	exit;
}

if ($familyId <= 0) {
	http_response_code(400);

	echo json_encode([
		"success" => false,
		"message" => "Family is required."
	]);

	exit;
}

// Check family exists
$stmt = $mysqli->prepare("
	SELECT id
	FROM family
	WHERE id = ?
");

$stmt->bind_param("i", $familyId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {

	http_response_code(404);

	echo json_encode([
		"success" => false,
		"message" => "Family not found."
	]);

	$stmt->close();
	$mysqli->close();
	exit;
}

$stmt->close();

$stmt = $mysqli->prepare("
	INSERT INTO members
	(
		first_name,
		last_name,
		middle_name,
		suffix,
		age,
		family_id
	)
	VALUES
	(?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
	"ssssii",
	$firstName,
	$lastName,
	$middleName,
	$suffix,
	$age,
	$familyId
);

if ($stmt->execute()) {

	$memberId = $mysqli->insert_id;

	http_response_code(201);

	echo json_encode([
		"success" => true,
		"message" => "Member created successfully.",
		"member" => [
			"id" => $memberId,
			"family_id" => $familyId,
			"first_name" => $firstName,
			"middle_name" => $middleName,
			"last_name" => $lastName,
			"suffix" => $suffix,
			"age" => $age
		]
	]);

} else {

	http_response_code(500);

	echo json_encode([
		"success" => false,
		"message" => "Unable to create member."
	]);
}

$stmt->close();
$mysqli->close();
?>