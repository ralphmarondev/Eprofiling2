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
    // Fixed: Changed table name from 'family' to 'families'
    // Fixed: Changed column names from 'created_date' to 'created_at'
    // Removed 'updated_date' as your schema uses 'updated_at'
    $sql = "
        SELECT
            f.id,
            f.family_code,
            f.name AS family_name,
            f.household_number,
            f.household_type,
            f.housing_ownership,
            f.contact_number,
            f.address,
            f.status,
            f.registration_status,
            f.created_at,
            f.updated_at,
            COUNT(m.id) AS member_count,
            -- Get the head of family name
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
        LEFT JOIN members m
            ON f.id = m.family_id
        GROUP BY
            f.id,
            f.family_code,
            f.name,
            f.household_number,
            f.household_type,
            f.housing_ownership,
            f.contact_number,
            f.address,
            f.status,
            f.registration_status,
            f.created_at,
            f.updated_at
        ORDER BY
            f.created_at DESC
    ";

    $result = $mysqli->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $mysqli->error);
    }

    $families = [];

    while ($row = $result->fetch_assoc()) {
        // Format the data for better display
        $row['head_name'] = trim($row['head_name'] ?? 'No head assigned');

        // Format status badges
        $row['status_badge'] = getStatusBadge($row['status']);
        $row['registration_status_badge'] = getRegistrationStatusBadge($row['registration_status']);

        // Format dates
        $row['created_at_formatted'] = date('Y-m-d', strtotime($row['created_at']));
        $row['updated_at_formatted'] = date('Y-m-d H:i', strtotime($row['updated_at']));

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

// Helper function for status badges
function getStatusBadge($status)
{
    $badges = [
        'active' => 'success',
        'inactive' => 'secondary'
    ];
    return $badges[$status] ?? 'secondary';
}

// Helper function for registration status badges
function getRegistrationStatusBadge($status)
{
    $badges = [
        'pending' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger'
    ];
    return $badges[$status] ?? 'secondary';
}
?>