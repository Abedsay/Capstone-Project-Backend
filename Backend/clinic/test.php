<?php
// Set your local timezone
date_default_timezone_set('Asia/Beirut'); // Change to your timezone if needed

// Display current time
$currentTime = date("Y-m-d H:i:s");

// Calculate expiry time (5 minutes ahead)
$expiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));

// Output both
echo "<h3>PHP Time Test</h3>";
echo "Current Time: $currentTime<br>";
echo "Expiry Time (5 minutes later): $expiry<br>";
?>
