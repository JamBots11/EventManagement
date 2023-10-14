<?php
session_start();

// Check if the user is not logged in, redirect to AdminLogin.php if not
if (!isset($_SESSION['adminUser'])) {
    header("Location: AdminLogin.php");
    exit;
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "testDB"; // Replace with your actual database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = mysqli_real_escape_string($conn, $_POST["eventName"]);
    $eventType = mysqli_real_escape_string($conn, $_POST["eventType"]);
    $eventDescription = mysqli_real_escape_string($conn, $_POST["eventDescription"]);
    $eventPlace = mysqli_real_escape_string($conn, $_POST["eventPlace"]);
    $eventTime = mysqli_real_escape_string($conn, $_POST["eventTime"]);
    $eventCost = mysqli_real_escape_string($conn, $_POST["eventCost"]);

    // Insert event data into the Event table
    $insertSql = "INSERT INTO `Event` (`eventName`, `eventType`, `eventDescription`, `eventPlace`, `eventTime`, `eventCost`) 
                  VALUES ('$eventName', '$eventType', '$eventDescription', '$eventPlace', '$eventTime', '$eventCost')";

    if (mysqli_query($conn, $insertSql)) {
        echo "Event added successfully!";
    } else {
        echo "Error adding event: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Event</title>
</head>

<body>
    <h2>Create Event</h2>
    <form action="AdminCreateEvent.php" method="post">
        <label for="eventName">Event Name:</label>
        <input type="text" name="eventName" id="eventName" required><br><br>

        <label for="eventType">Event Type:</label>
        <select name="eventType" id="eventType" required>
            <option value="conference">Conference</option>
            <option value="meeting">Meeting</option>
            <option value="concert">Concert</option>
            <option value="virtual_meeting">Virtual Meeting</option>
            <option value="workshops">Workshops</option>
            <option value="product_launch">Product Launch</option>
        </select><br><br>

        <label for="eventDescription">Event Description:</label>
        <textarea name="eventDescription" id="eventDescription" rows="4" required></textarea><br><br>

        <label for="eventPlace">Event Place:</label>
        <input type="text" name="eventPlace" id="eventPlace" required><br><br>

        <label for="eventTime">Event Time:</label>
        <input type="datetime-local" name="eventTime" id="eventTime" required><br><br>

        <label for="eventCost">Event Cost:</label>
        <input type="number" name="eventCost" id="eventCost" required><br><br>

        <input type="submit" value="Create Event">
    </form> <br>
    <a href="AdminHome.php">Back to Admin Home</a><br><br>
    <a href="AdminLogout.php">Logout</a>
</body>

</html>
