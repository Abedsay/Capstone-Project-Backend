<?php
header("Content-Type: text/plain");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if (!isset($_GET['pharmacist_id'])) {
    echo "Missing pharmacist_id";
    exit();
}

$pharmacistId = intval($_GET['pharmacist_id']);

$sql = "SELECT username FROM users WHERE id = ? AND type = 'Pharmacist'";
$stmt = $connect->prepare($sql);

if (!$stmt) {
    echo "SQL prepare error: " . $connect->error;
    exit();
}

$stmt->bind_param("i", $pharmacistId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo $row['username'];
} else {
    echo "Pharmacist";
}

$stmt->close();
$connect->close();
?>
