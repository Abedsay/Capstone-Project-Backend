<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed";
    exit();
}

$patient_id = $_POST['patient_id'] ?? '';
$doctor_id = $_POST['doctor_id'] ?? '';
$appointment_id = $_POST['appointment_id'] ?? '';
$medication = $_POST['medication'] ?? '';
$dosage = $_POST['dosage'] ?? '';
$instructions = $_POST['instructions'] ?? '';

if (!$patient_id || !$doctor_id || !$appointment_id || !$medication || !$dosage) {
    http_response_code(400);
    echo "Missing fields";
    exit();
}

$content = "Medication: $medication\nDosage: $dosage\nInstructions: $instructions";

$stmt1 = $connect->prepare("
    INSERT INTO medical_records (patient_id, doctor_id, appointment_id, type, content, created_at)
    VALUES (?, ?, ?, 'Prescription', ?, NOW())");
$stmt1->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);

if ($stmt1->execute()) {
    $stmt2 = $connect->prepare("
        INSERT INTO medical_records_pt (patient_id, doctor_id, appointment_id, type, content, created_at)
        VALUES (?, ?, ?, 'Prescription', ?, NOW())");
    $stmt2->bind_param("iiis", $patient_id, $doctor_id, $appointment_id, $content);

    if ($stmt2->execute()) {
        echo "success";
    } else {
        echo "error: failed to insert into medical_records_pt";
    }

    $stmt2->close();
} else {
    echo "error: failed to insert into medical_records";
}

$stmt1->close();
$connect->close();
?>
