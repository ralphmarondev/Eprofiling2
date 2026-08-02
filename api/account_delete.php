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
  $deleteAccountID = isset($_POST["delete_account_id"]) ? (int) $_POST["delete_account_id"] : 0;

  // Validate required fields
  if ($deleteAccountID <= 0) {
    throw new Exception("Account ID is required.");
  }

  // PrepareStatements
  $stmt = $mysqli->prepare("
      DELETE FROM `accounts`
      WHERE id = ?
  ");

  $stmt->bind_param(
    "i",
    $deleteAccountID
  );


  if (!$stmt->execute()) {
    throw new Exception("Failed to delete account: " . $stmt->error);
  }
  $stmt->close();

  $mysqli->commit();

  http_response_code(200);
  echo json_encode([
    "success" => true,
    "message" => "Account deleted successfully!"
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
