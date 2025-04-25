<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$db = "cpc_app";

// Connect
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

if ($doctor_id === 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid doctor ID"]);
    exit();
}

$sql = "SELECT a.time, u.username AS patient_name
        FROM appointments a
        JOIN users u ON a.patient_id = u.id
        WHERE a.doctor_id = ? AND a.date = CURDATE()";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];

while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

echo json_encode($appointments);
$conn->close();
?>
