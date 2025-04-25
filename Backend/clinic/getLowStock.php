<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

$sql = "SELECT name, quantity FROM medicines WHERE quantity < 50";
$result = $connect->query($sql);

$rows = array();
while($row = $result->fetch_assoc()) {
    $rows[] = $row;
}
echo json_encode($rows);
?>
