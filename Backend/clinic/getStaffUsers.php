<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $connect->connect_error]));
}

$currentId = isset($_GET['exclude_id']) ? intval($_GET['exclude_id']) : 0;

$sql = "SELECT id, username, type FROM users WHERE type != 'Patient' AND id != $currentId";
$result = $connect->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $connect->error]));
}

$staff = [];
while ($row = $result->fetch_assoc()) {
    $staff[] = $row;
}

echo json_encode($staff);
?>
