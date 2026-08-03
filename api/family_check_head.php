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

$family_id = isset($_GET['family_id']) ? intval($_GET['family_id']) : 0;

if ($family_id === 0) {
	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => "Family ID is required."
	]);
	exit;
}

try {
	$stmt = $mysqli->prepare("
        SELECT id, first_name, last_name 
        FROM members 
        WHERE family_id = ? AND is_head = 1
        LIMIT 1
    ");
	$stmt->bind_param("i", $family_id);
	$stmt->execute();
	$result = $stmt->get_result();

	$has_head = $result->num_rows > 0;
	$head_name = null;

	if ($has_head) {
		$head = $result->fetch_assoc();
		$head_name = $head['first_name'] . ' ' . $head['last_name'];
	}

	$stmt->close();

	echo json_encode([
		"success" => true,
		"has_head" => $has_head,
		"head_name" => $head_name
	]);

} catch (Exception $e) {
	http_response_code(500);
	echo json_encode([
		"success" => false,
		"message" => $e->getMessage()
	]);
}

$mysqli->close();
?>