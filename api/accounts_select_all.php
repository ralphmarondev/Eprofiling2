<?php
include '../config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $sql = 'SELECT `id`, `username`, `email`, `member_id`, `role_id`, `is_deleted` FROM accounts';
  $result = $mysqli->query($sql);
  $data = array();
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
  echo json_encode($data);
}
