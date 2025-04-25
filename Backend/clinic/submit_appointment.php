<?php
require_once 'connection.php';

if (
    isset($_POST['patient_id']) &&
    isset($_POST['doctor_name']) &&
    isset($_POST['date']) &&
    isset($_POST['time']) &&
    isset($_POST['reason_for_visit'])
) {
    $patient_id = $_POST['patient_id'];
    $doctor_name = $_POST['doctor_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason_for_visit = $_POST['reason_for_visit'];
    $status = "Scheduled";

    $parts = explode(" ", $doctor_name, 2);
    $first_name = $parts[0];
    $last_name = isset($parts[1]) ? $parts[1] : '';

    $stmt = $conn->prepare("SELECT doctor_id FROM doctors WHERE first_name = ? AND last_name = ?");
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $doctor_id = $row['doctor_id'];

        $insert = $conn->prepare("INSERT INTO appointments_pt (patient_id, doctor_id, date, time, status, reason_for_visit) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->bind_param("iissss", $patient_id, $doctor_id, $date, $time, $status, $reason_for_visit);
        $insert->execute();
        echo $insert->affected_rows > 0 ? "Success" : "Failed";
        $insert->close();
    } else {
        echo "Failed";
    }

    $stmt->close();
} else {
    echo "Failed";
}

$conn->close();
?>
