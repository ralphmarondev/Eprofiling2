<?php
require_once '../config/database.php';

// Example: Querying by a specific role_id using parameters
$sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name  FROM `members`";

$stmt = $mysqli->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$accounts = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($accounts);

$stmt->close();
