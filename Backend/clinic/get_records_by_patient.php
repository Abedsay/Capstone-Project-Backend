<?php
require_once 'connection.php';

// Get the patient ID from the GET request
$patientId = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';  // Retrieve patient_id from GET request

if (empty($patientId)) {
    // If no patient ID is provided, return an error message
    echo json_encode(array("Success" => false, "message" => "Patient ID is missing"));
    exit();
}

// Query to get records for the specific patient
$sql = "SELECT r.record_id, r.doctor_id, r.type, r.content, r.created_at, r.appointment_id, 
               CONCAT(d.first_name, ' ', d.last_name) AS doctor_name
        FROM medical_records_pt r
        JOIN doctors d ON r.doctor_id = d.doctor_id
        WHERE r.patient_id = ?";

$stmt = $conn->prepare($sql);

// Check if prepare() failed
if ($stmt === false) {
    echo json_encode(array("Success" => false, "message" => "Database error: " . $conn->error));
    exit();
}

$stmt->bind_param("i", $patientId);  // Bind the patient ID to the SQL query
$stmt->execute();
$stmt->store_result();

// Check if the patient has any records
if ($stmt->num_rows > 0) {
    $records = array();

    // Bind the result to variables
    $stmt->bind_result($recordId, $doctorId, $type, $content, $createdAt, $appointmentId, $doctorName);

    // Fetch all records and store them in an array
    while ($stmt->fetch()) {
        $records[] = array(
            "record_id" => $recordId,
            "doctor_id" => $doctorId,
            "doctor_name" => $doctorName,
            "type" => $type,
            "content" => $content,
            "created_at" => $createdAt,
            "appointment_id" => $appointmentId
        );
    }

    // Return the records as a JSON response
    echo json_encode(array("Success" => true, "records" => $records));
} else {
    // If no records are found, return an error message
    echo json_encode(array("Success" => false, "message" => "No records found for this patient"));
}

// Close the database connection
$stmt->close();
$conn->close();
?>