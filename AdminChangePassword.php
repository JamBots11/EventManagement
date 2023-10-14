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
$dbname = "testDB";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the current admin's username from the session
$currentAdminUser = $_SESSION['adminUser'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = mysqli_real_escape_string($conn, $_POST["oldPassword"]);
    $newPassword = mysqli_real_escape_string($conn, $_POST["newPassword"]);

    // Check if the old password matches the current password in the database
    $checkSql = "SELECT adminPassword FROM `Admin` WHERE `adminUser`='$currentAdminUser'";
    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) == 1) {
        $row = mysqli_fetch_assoc($checkResult);
        $currentPassword = $row['adminPassword'];

        // Verify the old password
        if ($oldPassword === $currentPassword) {
            // Update the admin's password in the database
            $updateSql = "UPDATE `Admin` SET `adminPassword`='$newPassword' WHERE `adminUser`='$currentAdminUser'";

            if (mysqli_query($conn, $updateSql)) {
                // Password successfully updated
                echo "Password updated successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Old password is incorrect.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
</head>

<body>
    <h2>Change Password</h2>
    <form action="AdminChangePassword.php" method="post">
        <label for="oldPassword">Old Password:</label>
        <input type="password" name="oldPassword" id="oldPassword" required><br><br>

        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" id="newPassword" required><br><br>

        <input type="submit" value="Change Password">
    </form>
    <a href="AdminHome.php">Back to Admin Home</a><br><br>
    <a href="AdminLogout.php">Logout</a>
</body>

</html>