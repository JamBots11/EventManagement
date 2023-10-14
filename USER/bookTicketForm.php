<?php
session_start();

// Check if the user is not logged in, redirect to userLogin.php if not
if (!isset($_SESSION['userid'])) {
    header("Location: userLogin.php");
    exit;
}

// Check if eventId is provided as a query parameter
if (!isset($_GET['eventId'])) {
    echo "Event ID is missing.";
    exit;
}

$eventId = $_GET['eventId'];

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

// Retrieve event details for the provided eventId
$eventSql = "SELECT * FROM `Event` WHERE `eventId` = $eventId";
$eventResult = mysqli_query($conn, $eventSql);

if (!$eventResult || mysqli_num_rows($eventResult) == 0) {
    echo "Event not found.";
    exit;
}

$eventRow = mysqli_fetch_assoc($eventResult);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $noOfTickets = mysqli_real_escape_string($conn, $_POST["noOfTickets"]);
    $paymentStatus = isset($_POST["paymentStatus"]) ? 1 : 0;

    // Generate a 6-digit random ticketId
    $ticketId = rand(100000, 999999);

    // Insert ticket booking data into the Ticket table
    $insertSql = "INSERT INTO `Ticket` (`ticketId`, `eventId`, `username`, `email`, `noOfTickets`, `paymentStatus`)
                  VALUES ($ticketId, $eventId, '" . $_SESSION['userid'] . "', '$email', $noOfTickets, $paymentStatus)";


    if (mysqli_query($conn, $insertSql)) {
        echo "Tickets booked successfully!";

        // update the userRegistered column here by writing the query
        // Update the usersRegistered column in the Event table
        $updateSql = "UPDATE `Event` SET `usersRegistered` = `usersRegistered` + $noOfTickets WHERE `eventId` = $eventId";
        if (mysqli_query($conn, $updateSql)) {
            echo "Event registration updated successfully!";
        } else {
            echo "Error updating event registration: " . mysqli_error($conn);
        }
    } else {
        echo "Error booking tickets: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Tickets</title>
</head>

<body>
    <h2>Book Tickets</h2>
    <p>Event Name:
        <?php echo $eventRow['eventName']; ?>
    </p>
    <p>Event Date and Time:
        <?php echo $eventRow['eventTime']; ?>
    </p>

    <form action="bookTicketForm.php?eventId=<?php echo $eventId; ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="noOfTickets">Number of Tickets:</label>
        <input type="number" name="noOfTickets" id="noOfTickets" required><br><br>

        <label for="paymentStatus">Payment Status:</label>
        <input type="checkbox" name="paymentStatus" id="paymentStatus" value="1"><br><br>

        <input type="submit" value="Book Tickets">
    </form>

    <br>
    <a href="userHome.php">Back to user Home</a><br><br>
    <a href="userLogout.php">Logout</a>
</body>

</html>