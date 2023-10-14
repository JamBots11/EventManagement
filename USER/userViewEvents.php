<?php
session_start();

// Check if the user is not logged in, redirect to AdminLogin.php if not
if (!isset($_SESSION['userid'])) {
    header("Location: userLogin.php");
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

// Retrieve all events from the Event table
$retrieveSql = "SELECT * FROM `Event`";

$result = mysqli_query($conn, $retrieveSql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>View Events</title>
</head>

<body>
    <h2>View Events</h2>
    <table border="1">
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Event Type</th>
            <th>Event Description</th>
            <th>Event Place</th>
            <th>Event Time</th>
            <th>Event Cost</th>
            <th>Action</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['eventId'] . "</td>";
                echo "<td>" . $row['eventName'] . "</td>";
                echo "<td>" . $row['eventType'] . "</td>";
                echo "<td>" . $row['eventDescription'] . "</td>";
                echo "<td>" . $row['eventPlace'] . "</td>";
                echo "<td>" . $row['eventTime'] . "</td>";
                echo "<td>" . $row['eventCost'] . "</td>";
                echo "<td>";
                echo "<a href='bookTicketForm.php?eventId=" . $row['eventId'] . "'>Book Ticket</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No events found.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="userHome.php">Back to user Home</a><br><br>
    <a href="userLogout.php">Logout</a>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);
?>