<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $connect->connect_error]);
    exit();
}

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

if ($doctor_id === 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid doctor ID"]);
    exit();
}

$sql = "SELECT a.appointment_id, u.id AS id, u.username AS name, a.reason_for_visit AS reason
        FROM appointments a
        JOIN users u ON a.patient_id = u.id
        WHERE a.doctor_id = ?
        ORDER BY u.username ASC";

$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();

$result = $stmt->get_result();
$patients = [];

while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode($patients);
?>
