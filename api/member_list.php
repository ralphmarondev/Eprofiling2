<?php
require_once "../config/database.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
	http_response_code(405);

	echo json_encode([
		"success" => false,
		"message" => "Method Not Allowed."
	]);

	exit;
}

$familyId = isset($_GET["family_id"]) && $_GET["family_id"] !== ""
	? intval($_GET["family_id"])
	: null;

if ($familyId === null) {

	$stmt = $mysqli->prepare("
		SELECT
			m.id,
			m.first_name,
			m.middle_name,
			m.last_name,
			m.suffix,
			m.age,
			m.family_id,
			f.family_code,
			f.name AS family_name,
			m.created_date,
			m.updated_date
		FROM members m
		INNER JOIN family f
			ON m.family_id = f.id
		ORDER BY
			f.name,
			m.last_name,
			m.first_name
	");

} else {

	$stmt = $mysqli->prepare("
		SELECT
			m.id,
			m.first_name,
			m.middle_name,
			m.last_name,
			m.suffix,
			m.age,
			m.family_id,
			f.family_code,
			f.name AS family_name,
			m.created_date,
			m.updated_date
		FROM members m
		INNER JOIN family f
			ON m.family_id = f.id
		WHERE
			m.family_id = ?
		ORDER BY
			m.last_name,
			m.first_name
	");

	$stmt->bind_param("i", $familyId);
}

$stmt->execute();

$result = $stmt->get_result();

$members = [];

while ($row = $result->fetch_assoc()) {
	$members[] = $row;
}

echo json_encode([
	"success" => true,
	"members" => $members
]);

$stmt->close();
$mysqli->close();
?>