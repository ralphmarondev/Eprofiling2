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

$sql = "
    SELECT
        f.id,
        f.family_code,
        f.name,
        f.created_date,
        f.updated_date,
        COUNT(m.id) AS member_count
    FROM family f
    LEFT JOIN members m
        ON f.id = m.family_id
    GROUP BY
        f.id,
        f.family_code,
        f.name,
        f.created_date,
        f.updated_date
    ORDER BY
        f.created_date DESC
";

$result = $mysqli->query($sql);

$families = [];

while ($row = $result->fetch_assoc()) {
    $families[] = $row;
}

echo json_encode([
    "success" => true,
    "families" => $families
]);

$mysqli->close();
?>