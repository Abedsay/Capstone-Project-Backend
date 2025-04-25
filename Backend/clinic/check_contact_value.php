<?php
header("Content-Type: text/plain");

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_value'])) {
    $contact = $conn->real_escape_string($_POST['contact_value']);

    // Check the contact_value column only
    $sql = "SELECT id FROM users WHERE contact_value = '$contact' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "USED";
    } else {
        echo "NOT USED";
    }
} else {
    echo "Invalid Request";
}

$conn->close();
?>