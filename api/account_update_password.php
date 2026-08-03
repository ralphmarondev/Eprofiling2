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
  $updateAccountID = isset($_POST["change_password_account_id"]) ? (int) $_POST["change_password_account_id"] : 0;
  $updateAccountNewPassword = trim($_POST["change_password_account_password"] ?? "");

  // Validate required fields
  if ($updateAccountID <= 0) {
    throw new Exception("Account ID is required.");
  }
  if (empty($updateAccountNewPassword)) {
    throw new Exception("Password is required.");
  }
  if (strlen($updateAccountNewPassword) < 8) {
    throw new Exception("Password must be at least 8 characters.");
  }

  $hashedUpdateAccountNewPassword = password_hash($updateAccountNewPassword, PASSWORD_DEFAULT);

  // PrepareStatements
  $stmt = $mysqli->prepare("
      UPDATE accounts 
      SET 
        password = ?
      WHERE id = ?
  ");

  $stmt->bind_param(
    "si",
    $hashedUpdateAccountNewPassword,
    $updateAccountID
  );

  if (!$stmt->execute()) {
    throw new Exception("Failed to update account: " . $stmt->error);
  }
  $stmt->close();

  $mysqli->commit();

  http_response_code(200);
  echo json_encode([
    "success" => true,
    "message" => "Password updated successfully!",
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
