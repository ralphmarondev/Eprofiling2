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

// Start transaction
$mysqli->begin_transaction();

try {
    // ============================================
    // STEP 1: Get Member ID
    // ============================================
    $memberId = isset($_POST["member_id"]) ? intval($_POST["member_id"]) : 0;

    if ($memberId === 0) {
        throw new Exception("Member ID is required.");
    }

    // ============================================
    // STEP 2: Check if member exists and get details
    // ============================================
    $stmt = $mysqli->prepare("
        SELECT id, first_name, last_name, is_head, family_id 
        FROM members 
        WHERE id = ?
    ");
    $stmt->bind_param("i", $memberId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Member not found.");
    }

    $member = $result->fetch_assoc();
    $stmt->close();

    // ============================================
    // STEP 3: Check if member is head of family
    // ============================================
    if ($member['is_head'] == 1) {
        // Check if there are other members in the family
        $stmt = $mysqli->prepare("
            SELECT COUNT(*) as total FROM members 
            WHERE family_id = ? AND id != ?
        ");
        $stmt->bind_param("ii", $member['family_id'], $memberId);
        $stmt->execute();
        $countResult = $stmt->get_result();
        $count = $countResult->fetch_assoc();
        $stmt->close();

        if ($count['total'] > 0) {
            throw new Exception("Cannot delete the head of family. Please assign a new head first.");
        }
    }

    // ============================================
    // STEP 4: Delete member (cascade will handle related records)
    // ============================================
    $stmt = $mysqli->prepare("DELETE FROM members WHERE id = ?");
    $stmt->bind_param("i", $memberId);

    if (!$stmt->execute()) {
        throw new Exception("Failed to delete member: " . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $mysqli->commit();

    // ============================================
    // Return Success Response
    // ============================================
    echo json_encode([
        "success" => true,
        "message" => "Member deleted successfully!",
        "data" => [
            "member_id" => $memberId,
            "member_name" => $member['first_name'] . " " . $member['last_name']
        ]
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $mysqli->rollback();

    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$mysqli->close();
?>