<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$patient_id = $_POST['patient_id'];
$doctor_id = $_POST['doctor_id'];
$appointment_id = $_POST['appointment_id']; // ✅ NEW
$diagnosis = $_POST['diagnosis'];
$symptoms = $_POST['symptoms'];
$notes = $_POST['notes'];

if (!$patient_id || !$doctor_id || !$appointment_id || !$diagnosis || !$symptoms) {
    echo "error: missing fields";
    exit();
}

$content = "Diagnosis: $diagnosis\nSymptoms: $symptoms\nNotes: $notes";

$stmt1 = $connect->prepare("
    INSERT INTO medical_records (patient_id, doctor_id, appointment_id, type, content, created_at)
    VALUES (?, ?, ?, 'Medical', ?, NOW())");
$stmt1->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);
$success1 = $stmt1->execute();
$stmt1->close();

$stmt2 = $connect->prepare("
    INSERT INTO medical_records_pt (patient_id, doctor_id, appointment_id, type, content, created_at)
    VALUES (?, ?, ?, 'Medical', ?, NOW())");
$stmt2->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);
$success2 = $stmt2->execute();
$stmt2->close();

if ($success1 && $success2) {
    echo "success";
} else {
    echo "error";
}
?>
