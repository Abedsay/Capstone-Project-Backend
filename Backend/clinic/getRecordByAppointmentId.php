<?php
header("Content-Type: text/plain");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit();
}

$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;

if ($appointment_id === 0) {
    http_response_code(400);
    echo "Missing or invalid appointment_id.";
    exit();
}

$sql = "SELECT type, content, created_at FROM medical_records WHERE appointment_id = ? LIMIT 1";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "Type: " . $row['type'] . "\n";
    echo "Date: " . $row['created_at'] . "\n\n";
    echo $row['content'];
} else {
    echo "No record found for this appointment.";
}

$stmt->close();
$connect->close();
?>
