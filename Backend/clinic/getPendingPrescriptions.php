<?php
header("Content-Type: application/json");
$connect = new mysqli("localhost", "root", "", "cpc_app");

$sql = "SELECT * FROM medical_records WHERE type = 'Prescription'";
$result = $connect->query($sql);

$prescriptions = [];

while ($row = $result->fetch_assoc()) {
    $prescriptions[] = $row;
}

echo json_encode($prescriptions);
?>
