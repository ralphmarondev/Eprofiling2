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
            f.id,
            f.family_code,
            f.name AS family_name,
            f.status,
            (
                SELECT CONCAT(
                    COALESCE(m2.first_name, ''),
                    ' ',
                    COALESCE(m2.middle_name, ''),
                    ' ',
                    COALESCE(m2.last_name, '')
                )
                FROM members m2
                WHERE m2.family_id = f.id 
                AND m2.is_head = 1
                LIMIT 1
            ) AS head_name
        FROM families f
        ORDER BY f.create_date DESC
    ";

    $result = $mysqli->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $mysqli->error);
    }

    $families = [];

    while ($row = $result->fetch_assoc()) {
        // Clean up head_name
        $row['head_name'] = trim($row['head_name'] ?? 'No head assigned');

        $families[] = $row;
    }

    echo json_encode([
        "success" => true,
        "families" => $families,
        "total" => count($families)
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