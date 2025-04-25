<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if (!isset($_GET['recipient_id'])) {
    echo json_encode(["error" => "Missing recipient_id"]);
    exit();
}

$recipientId = intval($_GET['recipient_id']);

$sql = "SELECT id, sender_id, message, timestamp, `read` 
        FROM messages 
        WHERE recipient_id = ? AND delivered = 0 AND `read` = 0";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $recipientId);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

if (!empty($messages)) {
    $ids = array_column($messages, 'id');
    $idList = implode(',', $ids);
    $connect->query("UPDATE messages SET delivered = 1 WHERE id IN ($idList)");
}

echo json_encode($messages);

$stmt->close();
$connect->close();
?>
