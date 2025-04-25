<?php
$connect = new mysqli("localhost", "root", "", "cpc_app");

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

$doctor_id = $_GET['doctor_id'];
$query = "SELECT CONCAT('Dr. ', first_name, ' ', last_name) AS full_name FROM doctors WHERE doctor_id = $doctor_id";
$result = $connect->query($query);

if ($row = $result->fetch_assoc()) {
    echo $row['full_name'];
} else {
    echo "Doctor";
}
?>
