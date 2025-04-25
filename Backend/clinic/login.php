<?php
require_once 'connection.php';  

if (isset($_POST['contact_value']) && isset($_POST['password'])) {
    $contactValue = $_POST['contact_value'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE contact_value = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $contactValue);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            echo "Success: Type=" . $user['type'] . ", ID=" . $user['id'];
        } 
        
        else {
            echo "Incorrect password";
        }
    } 
    
    else {
        echo "User not found";
    }

    $stmt->close();
} 
else {
    echo "Missing fields";
}

$conn->close();
?>
