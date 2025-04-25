<?php
header("Content-Type: text/plain");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    http_response_code(500);
    echo "Connection failed.";
    exit();
}

$record_id = isset($_GET['record_id']) ? intval($_GET['record_id']) : 0;

if ($record_id === 0) {
    http_response_code(400);
    echo "Missing or invalid record_id.";
    exit();
}

$sql = "SELECT type, content, created_at FROM medical_records WHERE record_id = ? AND type = 'LabTest' LIMIT 1";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $record_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "Type: " . $row['type'] . "\n";
    echo "Date: " . $row['created_at'] . "\n\n";
    echo $row['content'];
} else {
    echo "No lab test found for this ID.";
}

$stmt->close();
$connect->close();
?>
