<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

$record_id = $_POST['record_id'];

$result = $connect->query("SELECT * FROM generated_lab_tests WHERE record_id = $record_id");
$row = $result->fetch_assoc();

if ($row) {
    $insert = $connect->prepare("INSERT INTO submitted_lab_tests (record_id, patient_id, doctor_id, content) VALUES (?, ?, ?, ?)");
    $insert->bind_param("iiis", $row['record_id'], $row['patient_id'], $row['doctor_id'], $row['content']);
    $insert->execute();
    $insert->close();

    $connect->query("INSERT INTO hidden_records (record_id, patient_id, doctor_id, type, content) 
                     SELECT record_id, patient_id, doctor_id, 'LabTest', content 
                     FROM medical_records WHERE record_id = $record_id");

    $connect->query("DELETE FROM medical_records WHERE record_id = $record_id");
    $connect->query("DELETE FROM generated_lab_tests WHERE record_id = $record_id");

    echo "success";
} else {
    echo "not_found";
}
?>
