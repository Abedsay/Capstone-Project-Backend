<?php
require_once 'connection.php';  
$sql = "SELECT first_name, last_name FROM doctors";
$result = $conn->query($sql);

$doctors = array(); // Array to hold doctors' names

// Check if we have any results
if ($result->num_rows > 0) {
    // Fetch each row
    while($row = $result->fetch_assoc()) {
        // Combine first name and last name and add to the array
        $doctors[] = $row['first_name'] . ' ' . $row['last_name'];
    }
} else {
    echo "0 results";
}

$conn->close();

// Send the doctors' names as a simple JSON array
echo json_encode($doctors);
?>