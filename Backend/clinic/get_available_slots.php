<?php
require_once 'connection.php';
header('Content-Type: application/json');

// Get inputs
$doctor = isset($_GET['doctor']) ? $_GET['doctor'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (empty($doctor) || empty($date)) {
    echo json_encode([]);
    exit;
}

// All possible time slots
$all_slots = [
    "11:00", "11:30", "12:00", "12:30",
    "13:00", "13:30", "14:00", "14:30",
    "15:00", "15:30", "16:00", "16:30", "17:00"
];

// Split doctor full name
$doctor_parts = explode(' ', $doctor, 2);
$first_name = $doctor_parts[0];
$last_name = isset($doctor_parts[1]) ? $doctor_parts[1] : '';

// Step 1: Get doctor_id from doctors table
$sqlDoctorId = "SELECT doctor_id FROM doctors WHERE first_name = ? AND last_name = ?";
$stmt = $conn->prepare($sqlDoctorId);
$stmt->bind_param("ss", $first_name, $last_name);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $doctor_id = $row['doctor_id'];

    // Step 2: Get booked times for this doctor_id and date
    $sqlAppointments = "SELECT time FROM appointments WHERE doctor_id = ? AND date = ?";
    $stmt2 = $conn->prepare($sqlAppointments);
    $stmt2->bind_param("is", $doctor_id, $date);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $booked = [];
    while ($row2 = $result2->fetch_assoc()) {
        $booked[] = substr($row2['time'], 0, 5); // Get only HH:MM
    }

    $available = array_values(array_diff($all_slots, $booked));
    echo json_encode($available);
} else {
    // Doctor not found
    echo json_encode([]);
}

$conn->close();
?>
