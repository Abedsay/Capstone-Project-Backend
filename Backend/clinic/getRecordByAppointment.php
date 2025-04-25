<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed.";
    exit();
}

$appointment_id = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;

if ($appointment_id === 0) {
    http_response_code(400);
    echo "Missing appointment_id.";
    exit();
}

$sql = "SELECT content FROM medical_records WHERE appointment_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo $row['content'];
} else {
    echo "No record found for this appointment.";
}
?>
