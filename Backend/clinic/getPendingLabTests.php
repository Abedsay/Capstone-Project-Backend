<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

// Fetch all LabTest records that are not yet submitted
$sql = "SELECT record_id, patient_id, doctor_id, content 
        FROM medical_records 
        WHERE type = 'LabTest'";

$result = $connect->query($sql);

$records = [];

while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

echo json_encode($records);
$connect->close();
?>
