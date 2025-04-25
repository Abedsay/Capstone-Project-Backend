<?php
header("Content-Type: application/json");
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$sql = "SELECT record_id FROM medical_records WHERE type = 'LabTest'";
$result = $connect->query($sql);

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode($records);
?>
