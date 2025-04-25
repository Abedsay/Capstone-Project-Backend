<?php
header("Content-Type: text/plain");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed.";
    exit();
}

$sql = "SELECT COUNT(*) AS total FROM medical_records WHERE type = 'LabTest'";
$result = $connect->query($sql);

if ($row = $result->fetch_assoc()) {
    echo $row['total'];
} else {
    echo "0";
}

$connect->close();
?>
