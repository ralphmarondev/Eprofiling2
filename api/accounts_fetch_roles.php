<?php
require_once '../config/database.php';

// Example: Querying by a specific role_id using parameters
$sql = "SELECT * FROM `role`";

$stmt = $mysqli->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$accounts = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($accounts);

$stmt->close();
