<?php
header("Content-Type: text/plain");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed.";
    exit();
}

$lab_tech_id = isset($_GET['lab_tech_id']) ? intval($_GET['lab_tech_id']) : 0;

if ($lab_tech_id === 0) {
    http_response_code(400);
    echo "Missing technician ID.";
    exit();
}

$sql = "SELECT username FROM users WHERE id = ? AND type = 'Lab Technician'";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $lab_tech_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo $row['username'];
} else {
    echo "Lab Technician";
}

$stmt->close();
$connect->close();
?>
