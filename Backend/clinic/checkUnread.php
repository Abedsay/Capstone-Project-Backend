<?php
header("Content-Type: application/json");

$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $connect->connect_error]));
}

$my_id = isset($_GET['my_id']) ? intval($_GET['my_id']) : 0;
$other_id = isset($_GET['other_id']) ? intval($_GET['other_id']) : 0;

$sql = "SELECT COUNT(*) as unread_count FROM messages 
        WHERE sender_id = $other_id AND recipient_id = $my_id AND `read` = 0";

$result = $connect->query($sql);
$row = $result->fetch_assoc();

echo json_encode(["unread" => $row['unread_count'] > 0 ? 1 : 0]);
?>
