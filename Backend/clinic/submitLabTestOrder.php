<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$patient_id = $_POST['patient_id'];
$doctor_id = $_POST['doctor_id'];
$appointment_id = $_POST['appointment_id']; // ✅ NEW
$test_name = $_POST['test_name'];
$reason = $_POST['reason'];
$instructions = $_POST['instructions'];

if (!$patient_id || !$doctor_id || !$appointment_id || !$test_name || !$reason) {
    echo "error: missing fields";
    exit();
}

$content = "Test: $test_name\nReason: $reason\nInstructions: $instructions";

$stmt1 = $connect->prepare("
    INSERT INTO medical_records (patient_id, doctor_id, appointment_id, type, content, created_at)
    VALUES (?, ?, ?, 'LabTest', ?, NOW())");
$stmt1->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);
$success1 = $stmt1->execute();
$stmt1->close();

$stmt2 = $connect->prepare("
    INSERT INTO medical_records_pt (patient_id, doctor_id, appointment_id, type, content, created_at)
    VALUES (?, ?, ?, 'LabTest', ?, NOW())");
$stmt2->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);
$success2 = $stmt2->execute();
$stmt2->close();

if ($success1 && $success2) {
    echo "success";
} else {
    echo "error";
}
?>
