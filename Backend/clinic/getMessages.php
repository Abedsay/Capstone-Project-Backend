<?php
header("Content-Type: application/json");

// Turn off notices/warnings in production
error_reporting(0);
ini_set('display_errors', 0);

// Connect to DB
$connect = new mysqli("localhost", "root", "", "cpc_app");
if ($connect->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $connect->connect_error]);
    exit();
}

// Validate input
if (!isset($_GET['user_id']) || !isset($_GET['other_id'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit();
}

$userId = intval($_GET['user_id']);
$otherId = intval($_GET['other_id']);

// Fetch chat messages between user and other user
$sql = "SELECT id, sender_id, recipient_id, message, timestamp, delivered, `read`
        FROM messages
        WHERE (sender_id = ? AND recipient_id = ?) OR (sender_id = ? AND recipient_id = ?)
        ORDER BY timestamp ASC";

$stmt = $connect->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $connect->error]);
    exit();
}

$stmt->bind_param("iiii", $userId, $otherId, $otherId, $userId);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
$connect->close();
?>
