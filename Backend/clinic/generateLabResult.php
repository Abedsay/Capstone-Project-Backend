<?php
header('Content-Type: application/json');
$connect = new mysqli("localhost", "root", "", "cpc_app");

$record_id = $_POST['record_id'] ?? null;
$patient_id = $_POST['patient_id'] ?? null;
$doctor_id = $_POST['doctor_id'] ?? null;
$content = $_POST['content'] ?? null;

if (!$record_id || !$patient_id || !$doctor_id || !$content) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

$checkSql = "SELECT 1 FROM generated_lab_tests WHERE record_id = ?";
$checkStmt = $connect->prepare($checkSql);
$checkStmt->bind_param("i", $record_id);
$checkStmt->execute();
$exists = $checkStmt->get_result()->fetch_row();

if ($exists) {
    $sql = "UPDATE generated_lab_tests SET content = ? WHERE record_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $content, $record_id);
} else {
    $sql = "INSERT INTO generated_lab_tests (record_id, patient_id, doctor_id, content) VALUES (?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iiis", $record_id, $patient_id, $doctor_id, $content);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
}

$connect->close();
?>