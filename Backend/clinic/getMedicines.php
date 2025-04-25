<?php
header("Content-Type: application/json");
$connect = new mysqli("localhost", "root", "", "cpc_app");

$sql = "SELECT id, name, quantity, image_url FROM medicines";
$result = $connect->query($sql);

$medicines = [];

while ($row = $result->fetch_assoc()) {
    $medicines[] = $row;
}

echo json_encode($medicines);

$connect->close();
?>
