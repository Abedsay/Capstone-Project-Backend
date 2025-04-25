<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';
require_once 'connection.php';

if (isset($_POST['contact_value'])) {
    $contact = $_POST['contact_value'];
    $otp = rand(100000, 999999);
    // Display current time
    date_default_timezone_set('Asia/Beirut');

    // Calculate expiry time (5 minutes ahead)
    $expiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));

    // Step 1: Delete expired OTPs
    $conn->query("DELETE FROM otps WHERE expiry < NOW()");

    // Step 2: Insert new OTP into database
    $stmt = $conn->prepare("INSERT INTO otps (contact_value, code, expiry) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $contact, $otp, $expiry);
    $stmt->execute();

    // Step 3: Send the OTP using PHPMailer + Mailjet
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'in-v3.mailjet.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '85369245d86121cecab62469a987c886';        // Replace with your Mailjet Public API Key
        $mail->Password   = '106303408a139b6147602de8b71305cb';     // Replace with your Mailjet Secret Key
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('cpcclinic3@gmail.com', 'CPC Clinic'); // Use your verified sender address
        $mail->addAddress($contact);                         // Recipient
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP is: <b>$otp</b>";
        $mail->AltBody = "Your OTP is: $otp";

        $mail->send();
        echo 'OTP sent';
    } catch (Exception $e) {
        echo "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
    }

    $stmt->close();
}
 else {
    echo "Missing contact_value";
    }

$conn->close();