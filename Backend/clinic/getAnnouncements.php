<?php

$connect = new mysqli("localhost", "root", "", "cpc_app");
if ($connect->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$connect->set_charset("utf8");

//delete announcements older than 7 days
$connect->query("DELETE FROM announcements WHERE created_at < NOW() - INTERVAL 7 DAY");

$sql = "SELECT content, DATE(created_at) AS date_only FROM announcements ORDER BY created_at DESC";
$result = $connect->query($sql);

$announcements = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $row['content'] = utf8_encode($row['content']);
        $announcements[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($announcements, JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
?>
