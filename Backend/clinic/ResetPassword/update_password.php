<?php
require_once '../connection.php';

if (isset($_POST['contact_value']) && isset($_POST['new_password'])) {
    $contact = $_POST['contact_value'];
    $newPassword = $_POST['new_password'];

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the users table
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE contact_value = ?");
    $stmt->bind_param("ss", $hashedPassword, $contact);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "failed";
    }

    $stmt->close();
} else {
    echo "Missing fields";
}

$conn->close();
?>
