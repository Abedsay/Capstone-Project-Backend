<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$suggestion = $_POST['suggestion'];
$staff_id = $_POST['staff_id'];

if (!empty($suggestion)) {
    $stmt = $connect->prepare("INSERT INTO announcement_suggestions (staff_id, suggestion) VALUES (?, ?)");
    $stmt->bind_param("is", $staff_id, $suggestion);
    $stmt->execute();
    echo "success";
} else {
    echo "error";
}
?>
