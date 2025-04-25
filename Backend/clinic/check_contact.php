<?php
require_once 'connection.php';

if (isset($_POST['contact_value'])) {
    $contact = $_POST['contact_value'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE contact_value = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $stmt->store_result();

    // Row exists = contact is registered
    if ($stmt->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }

    $stmt->close();
} else {
    echo "Missing contact_value";
}

$conn->close();
?>
