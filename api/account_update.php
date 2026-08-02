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
  // Get Account Data
  $updateAccountID = isset($_POST["update_account_id"]) ? (int) $_POST["update_account_id"] : 0;
  $updateAccountUsername = trim($_POST["update_account_username"] ?? "");
  $updateAccountRole = isset($_POST["update_account_role_id"]) ? (int) $_POST["update_account_role_id"] : 0;
  $updateAccountMemberID = isset($_POST["update_account_member_id"]) ? (int) $_POST["update_account_member_id"] : 0;
  $updateAccountEmail = trim($_POST["update_account_email"] ?? "");
  $updateAccountStatus = isset($_POST["update_account_status"]) ? (int) $_POST["update_account_status"] : 0;

  // Validate required fields
  if ($updateAccountID <= 0) {
    throw new Exception("Account ID is required.");
  }
  if (empty($updateAccountUsername)) {
    throw new Exception("Username is required.");
  }
  if ($updateAccountRole <= 0) {
    throw new Exception("User Role is required.");
  }
  if (empty($updateAccountEmail)) {
    throw new Exception("User Email is required.");
  }
  if ($updateAccountStatus < 0) {
    throw new Exception("User Status is required.");
  }

  // PrepareStatements
  if ($updateAccountMemberID == 0) {
    $stmt = $mysqli->prepare("
        UPDATE accounts 
        SET 
          username = ?,
          email = ?,
          role_id = ?,
          is_deleted = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
      "ssiii",
      $updateAccountUsername,
      $updateAccountEmail,
      $updateAccountRole,
      $updateAccountStatus,
      $updateAccountID
    );
  } else {
    $stmt = $mysqli->prepare("
        UPDATE accounts 
        SET 
          username = ?,
          email = ?,
          member_id = ?,
          role_id = ?,
          is_deleted = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
      "ssiiii",
      $updateAccountUsername,
      $updateAccountEmail,
      $updateAccountMemberID,
      $updateAccountRole,
      $updateAccountStatus,
      $updateAccountID
    );
  }


  if (!$stmt->execute()) {
    throw new Exception("Failed to update account: " . $stmt->error);
  }
  $stmt->close();

  $mysqli->commit();

  http_response_code(200);
  echo json_encode([
    "success" => true,
    "message" => "Account updated successfully!",
    "data" => [
      "id" => $updateAccountID,
      "username" => $updateAccountUsername,
      "role_id" => $updateAccountRole,
      "member_id" => $updateAccountMemberID,
      "email" => $updateAccountEmail,
      "is_deleted" => $updateAccountStatus
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
