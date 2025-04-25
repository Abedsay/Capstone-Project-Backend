<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $connect->connect_error]));
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT username FROM users WHERE id = $id";
$result = $connect->query($sql);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $connect->error]));
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
