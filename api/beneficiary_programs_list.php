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

try {
	$sql = "
        SELECT 
            id,
            name,
            description,
            create_date,
            update_date
        FROM beneficiary_programs
        ORDER BY name ASC
    ";

	$result = $mysqli->query($sql);

	if (!$result) {
		throw new Exception("Query failed: " . $mysqli->error);
	}

	$programs = [];

	while ($row = $result->fetch_assoc()) {
		$programs[] = [
			"id" => (int) $row['id'],
			"name" => $row['name'],
			"description" => $row['description'],
			"create_date" => $row['create_date'],
			"update_date" => $row['update_date']
		];
	}

	echo json_encode([
		"success" => true,
		"programs" => $programs,
		"total" => count($programs)
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