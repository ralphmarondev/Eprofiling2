<?php
require_once '../config/database.php';

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
  $sql = "SELECT 
          accounts.id, 
          accounts.username, 
          accounts.email, 
          members.id AS member_id, 
          accounts.role_id,
          roles.name AS role_name,
          CONCAT(members.first_name, ' ', members.last_name) AS member_full_name,
          accounts.is_deleted
        FROM `accounts`
        INNER JOIN `roles` ON accounts.role_id = roles.id
        LEFT JOIN `members` ON accounts.member_id = members.id
        ORDER BY accounts.id;";

  $result = $mysqli->query($sql);

  if (!$result) {
    throw new Exception("Query failed: " . $mysqli->error);
  }

  $accounts = [];

  while ($row = $result->fetch_assoc()) {
    $accounts[] = $row;
  }

  echo json_encode([
    "success" => true,
    "accounts" => $accounts,
    "total" => count($accounts)
  ]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => $e->getMessage()
  ]);
}
