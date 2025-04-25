<?php
header("Content-Type: text/plain");

require_once 'connection.php';
// Check if username is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = $conn->real_escape_string($_POST['username']);

    // Query to check if username exists
    $sql = "SELECT id FROM users WHERE username = '$username' LIMIT 1";
    $result = $conn->query($sql);

    // Check result
    if ($result->num_rows > 0) {
        echo "USED";
    } else {
        echo "NOT USED";
    }
} else {
    echo "No username provided";
}

$conn->close();
?>