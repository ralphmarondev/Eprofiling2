<?php
require_once '../config/database.php';

// Example: Querying by a specific role_id using parameters
$sql = "SELECT 
          accounts.id, 
          accounts.username, 
          accounts.email, 
          members.id AS member_id, 
          accounts.role_id,
          role.name AS role_name
        FROM `accounts`
        INNER JOIN `role` ON accounts.role_id = role.id
        LEFT JOIN `members` ON accounts.member_id = members.id
        ORDER BY accounts.id;";

$stmt = $mysqli->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$accounts = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($accounts);

$stmt->close();
