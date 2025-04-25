<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
$weekday = isset($_GET['weekday']) ? $_GET['weekday'] : '';

if ($doctor_id === 0 || $weekday === '') {
    echo json_encode([]);
    exit();
}

// Map weekday to date offset
$weekMap = [
    "Monday" => "1",
    "Tuesday" => "2",
    "Wednesday" => "3",
    "Thursday" => "4",
    "Friday" => "5"
];

if (!isset($weekMap[$weekday])) {
    echo json_encode([]);
    exit();
}

$targetDate = date('Y-m-d', strtotime("this week " . $weekday));

$sql = "SELECT a.time, u.username AS patient_name
        FROM appointments a
        JOIN users u ON a.patient_id = u.id
        WHERE a.doctor_id = ? AND a.date = ?";

$stmt = $connect->prepare($sql);
$stmt->bind_param("is", $doctor_id, $targetDate);
$stmt->execute();

$result = $stmt->get_result();
$schedule = [];

while ($row = $result->fetch_assoc()) {
    $schedule[] = $row;
}

echo json_encode($schedule);
?>
