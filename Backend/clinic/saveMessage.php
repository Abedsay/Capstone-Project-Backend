<?php
header("Content-Type: application/json");
$connect = new mysqli("localhost", "root", "", "cpc_app");

$senderId = $_POST['sender_id'];
$recipientId = $_POST['recipient_id'];
$message = $_POST['message'];

$stmt = $connect->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $senderId, $recipientId, $message);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $connect->error]);
}

$stmt->close();
$connect->close();
?>
