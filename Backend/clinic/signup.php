<?php
require_once 'connection.php';

// Check if all required POST variables are set
if (
    isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['contact_type']) && 
    isset($_POST['contact_value'])
) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $contactType = $_POST['contact_type'];
    $contactValue = $_POST['contact_value'];

    // Optional: Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $type = "Patient";

    // Check if username already exists
    $checkQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists";
    } else {
        // Insert user
        $insertQuery = "INSERT INTO users (username, password, contact_type, contact_value, type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $username, $hashedPassword, $contactType, $contactValue, $type);

        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Failed to register. MySQL Error: " . $stmt->error;
        }
    }
    $stmt->close();
} else {
    echo "Missing fields";
}

$conn->close();
?>
