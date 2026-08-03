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

$member_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($member_id === 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Member ID is required."
    ]);
    exit;
}

try {
    $sql = "
        SELECT 
            m.id,
            m.family_id,
            m.first_name,
            m.middle_name,
            m.last_name,
            m.suffix,
            m.sex,
            m.date_of_birth,
            m.place_of_birth,
            m.civil_status,
            m.nationality,
            m.religion,
            m.occupation,
            m.educational_attainment,
            m.is_head,
            m.relationship_to_head,
            m.is_voter,
            m.is_indigenous,
            m.indigenous_group,
            m.create_date,
            m.update_date,
            f.family_code,
            f.name AS family_name
        FROM members m
        INNER JOIN families f ON m.family_id = f.id
        WHERE m.id = ?
    ";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            "success" => false,
            "message" => "Member not found."
        ]);
        exit;
    }

    $member = $result->fetch_assoc();
    $stmt->close();

    // Get beneficiary programs
    $programs_sql = "
        SELECT bp.id, bp.name, bp.description
        FROM member_beneficiaries mb
        INNER JOIN beneficiary_programs bp ON mb.program_id = bp.id
        WHERE mb.member_id = ?
    ";
    $stmt = $mysqli->prepare($programs_sql);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $programs_result = $stmt->get_result();
    $programs = [];
    while ($row = $programs_result->fetch_assoc()) {
        $programs[] = $row;
    }
    $stmt->close();

    $member['programs'] = $programs;

    echo json_encode([
        "success" => true,
        "data" => $member
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