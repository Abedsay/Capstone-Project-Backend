<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

$name = $_POST['name'];
$quantity = intval($_POST['quantity']);

$stmt = $connect->prepare("UPDATE medicines SET quantity = ? WHERE name = ?");
$stmt->bind_param("is", $quantity, $name);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$connect->close();
?>
