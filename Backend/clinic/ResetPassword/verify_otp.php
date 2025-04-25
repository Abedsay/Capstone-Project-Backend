<?php
require_once '../connection.php'; // Adjust path as needed

if (isset($_POST['contact_value']) && isset($_POST['code'])) {
    $contact = $_POST['contact_value'];
    $otpCode = $_POST['code'];

    // Delete expired OTPs
    $conn->query("DELETE FROM otps WHERE expiry < NOW()");

    // Get the most recent valid OTP for this contact
    $stmt = $conn->prepare("
        SELECT code 
        FROM otps 
        WHERE contact_value = ? AND expiry > NOW() 
        ORDER BY expiry DESC 
        LIMIT 1
    ");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $stmt->bind_result($latestCode);
    $stmt->fetch();
    $stmt->close();

    // Compare the most recent valid code to the one submitted
    if (!empty($latestCode) && $latestCode === $otpCode) {
        echo "true";
    } else {
        echo "false";
    }
} else {
    echo "Missing fields";
}

$conn->close();
?>
