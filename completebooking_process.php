<?php
require 'db.php';
// Retrieve the data sent from the client-side
$userEmail = $_POST['userEmail'];
$movieName = $_POST['movieName'];
$roomName = $_POST['roomName'];
$seatName = $_POST['seatName'];
$startDate = $_POST['startDate'];
$startHrs = $_POST['startHrs'];

// Perform the database insertion


// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "INSERT INTO completed_bookings (userEmail, movieName, roomName, seatName, startDate, startHours) VALUES (?, ?, ?, ?, ?, ?)";

// Create a prepared statement
$stmt = $conn->prepare($sql);

// Bind the parameters to the statement
$stmt->bind_param("ssssss", $userEmail, $movieName, $roomName, $seatName, $startDate, $startHrs);

// Execute the statement
if ($stmt->execute()) {
    echo "Booking completed successfully!";
} else {
    echo "Error: " . $conn->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
