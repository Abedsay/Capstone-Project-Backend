<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if (!isset($_POST['record_id'])) {
    echo "Missing record_id";
    exit();
}

$recordId = intval($_POST['record_id']);

$result = $connect->query("SELECT * FROM medical_records WHERE record_id = $recordId");
$row = $result->fetch_assoc();

if ($row) {
    $stmt1 = $connect->prepare("INSERT INTO submitted_prescriptions (record_id, patient_id, doctor_id, content) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("iiis", $row['record_id'], $row['patient_id'], $row['doctor_id'], $row['content']);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $connect->prepare("INSERT INTO hidden_records (record_id, patient_id, doctor_id, type, content, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("iiisss", $row['record_id'], $row['patient_id'], $row['doctor_id'], $row['type'], $row['content'], $row['created_at']);
    $stmt2->execute();
    $stmt2->close();

    $connect->query("DELETE FROM medical_records WHERE record_id = $recordId");

    echo "success";
} else {
    echo "Record not found";
}
?>
