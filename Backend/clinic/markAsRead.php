<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

$senderId = $_POST['sender_id'];
$recipientId = $_POST['recipient_id'];

$stmt = $connect->prepare("UPDATE messages SET `read` = 1 WHERE sender_id = ? AND recipient_id = ?");
$stmt->bind_param("ii", $senderId, $recipientId);
$stmt->execute();

echo json_encode(["success" => true]);
$stmt->close();
$connect->close();
?>
