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

$name = trim($_POST["name"] ?? "");
$familyCode = trim($_POST["family_code"] ?? "");
$address = trim($_POST["address"] ?? "");
$landline = trim($_POST["landline"] ?? "");

// Debug log
error_log("Received: name=" . $name . ", family_code=" . $familyCode);

if (
    empty($name) ||
    empty($familyCode) ||
    empty($address)
) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Please complete all required fields.",
        "debug" => [
            "name" => empty($name) ? "Missing" : "OK",
            "family_code" => empty($familyCode) ? "Missing" : "OK",
            "address" => empty($address) ? "Missing" : "OK"
        ]
    ]);

    exit;
}

// Check if family code exists
$stmt = $mysqli->prepare("
    SELECT id
    FROM family
    WHERE family_code = ?
");

$stmt->bind_param("s", $familyCode);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    http_response_code(409);

    echo json_encode([
        "success" => false,
        "message" => "Family code already exists."
    ]);

    $stmt->close();
    $mysqli->close();
    exit;
}

$stmt->close();

// Insert family - adjust columns based on your actual database schema
$stmt = $mysqli->prepare("
    INSERT INTO family
    (
        family_code,
        name,
        address,
        landline,
        status,
        created_at
    )
    VALUES
    (?, ?, ?, ?, 'active', NOW())
");

$stmt->bind_param(
    "ssss",
    $familyCode,
    $name,
    $address,
    $landline
);

if ($stmt->execute()) {

    $familyId = $mysqli->insert_id;

    http_response_code(201);

    echo json_encode([
        "success" => true,
        "message" => "Family created successfully.",
        "family" => [
            "id" => $familyId,
            "family_code" => $familyCode,
            "name" => $name,
            "address" => $address,
            "landline" => $landline,
            "status" => "active"
        ]
    ]);

} else {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Unable to create family: " . $stmt->error
    ]);
}

$stmt->close();
$mysqli->close();
?>