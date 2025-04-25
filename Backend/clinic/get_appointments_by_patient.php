<?php
require_once 'connection.php';

// Get the patient ID from the GET request
$patientId = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';  // Retrieve patient_id from GET request

if (empty($patientId)) {
    // If no patient ID is provided, return an error message
    echo json_encode(array("Success" => false, "message" => "Patient ID is missing"));
    exit();
}

// Query to get appointments for the specific patient
$sql = "SELECT CONCAT(d.first_name, ' ', d.last_name) AS doctor_name, a.reason_for_visit, a.date, a.time 
        FROM appointments_pt a
        JOIN doctors d ON a.doctor_id = d.doctor_id
        WHERE a.patient_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientId);  // Bind the patient ID to the SQL query
$stmt->execute();
$stmt->store_result();

// Check if the patient has any appointments
if ($stmt->num_rows > 0) {
    $appointments = array();

    // Bind the result to variables
    $stmt->bind_result($doctorName, $reasonForVisit, $date, $time);

    // Fetch all appointments and store them in an array
    while ($stmt->fetch()) {
        $appointments[] = array(
            "doctor_name" => $doctorName,
            "reason_for_visit" => $reasonForVisit,
            "date" => $date,
            "time" => $time
        );
    }

    // Return the appointments as a JSON response
    echo json_encode(array("Success" => true, "appointments" => $appointments));
} else {
    // If no appointments are found, return an error message
    echo json_encode(array("Success" => false, "message" => "No appointments found for this patient"));
}

// Close the database connection
$stmt->close();
$conn->close();
?>
