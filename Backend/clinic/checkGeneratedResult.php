<?php
header("Content-Type: application/json");
$connect = new mysqli("localhost", "root", "", "cpc_app");

$record_id = isset($_GET['record_id']) ? intval($_GET['record_id']) : 0;

$sql = "SELECT * FROM generated_lab_tests WHERE record_id = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $record_id);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode($rows);
?>
