<?php
require_once 'connection.php';

if (isset($_GET['record_id'])) {
    $id = $_GET['record_id'];

    $stmt = $conn->prepare("DELETE FROM medical_records_pt WHERE record_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Failed";
    }

    $stmt->close();
} else {
    echo "Missing record_id";
}

$conn->close();
?>
