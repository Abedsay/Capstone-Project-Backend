<?php
header("Content-Type: text/plain");
$connect = new mysqli("localhost", "root", "", "cpc_app");

if (!isset($_GET['record_id'])) {
    echo "Missing record_id";
    exit();
}

$recordId = intval($_GET['record_id']);
$sql = "SELECT content FROM medical_records WHERE record_id = ? AND type = 'Prescription'";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $recordId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo $row['content'];
} else {
    echo "Prescription not found.";
}

$stmt->close();
$connect->close();
?>
