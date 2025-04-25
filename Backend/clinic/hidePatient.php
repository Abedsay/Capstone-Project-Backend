<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed.";
    exit();
}

$appointment_id = isset($_POST['appointment_id']) ? intval($_POST['appointment_id']) : 0;

if ($appointment_id === 0) {
    http_response_code(400);
    echo "Missing appointment ID.";
    exit();
}

$stmtDelete = $connect->prepare("DELETE FROM appointments WHERE appointment_id = ?");
$stmtDelete->bind_param("i", $appointment_id);

if ($stmtDelete->execute()) {
    echo "success";
} else {
    echo "Failed to delete from appointments";
}
?>
