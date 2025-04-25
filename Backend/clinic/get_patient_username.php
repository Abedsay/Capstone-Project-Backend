<?php
require_once 'connection.php';  
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username);

if ($stmt->fetch()) {
    header('Content-Type: application/json');
    echo json_encode(['username' => $username]);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$conn->close();
?>