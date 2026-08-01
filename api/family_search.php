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

$familyCode = isset($_GET['code']) ? trim($_GET['code']) : '';

if (empty($familyCode)) {
	http_response_code(400);
	echo json_encode([
		"success" => false,
		"message" => "Family code is required."
	]);
	exit;
}

try {
	$stmt = $mysqli->prepare("
        SELECT 
            id,
            family_code,
            name AS family_name,
            address,
            contact_number,
            status,
            registration_status
        FROM families 
        WHERE family_code = ? 
        AND status = 'active'
        AND registration_status = 'approved'
        LIMIT 1
    ");

	$stmt->bind_param("s", $familyCode);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows === 0) {
		http_response_code(404);
		echo json_encode([
			"success" => false,
			"message" => "Family code not found or not active."
		]);
		$stmt->close();
		exit;
	}

	$family = $result->fetch_assoc();
	$stmt->close();

	// Get head of family
	$stmt = $mysqli->prepare("
        SELECT 
            CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS head_name
        FROM members 
        WHERE family_id = ? AND is_head = 1
        LIMIT 1
    ");
	$stmt->bind_param("i", $family['id']);
	$stmt->execute();
	$headResult = $stmt->get_result();
	$head = $headResult->fetch_assoc();
	$family['head_name'] = $head ? $head['head_name'] : 'Not assigned';
	$stmt->close();

	echo json_encode([
		"success" => true,
		"family" => $family
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