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
$dbname = "testDB";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the current admin's username from the session
$currentUser = $_SESSION['userid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $newUsername = mysqli_real_escape_string($conn, $_POST["newUsername"]);

    if ($newUsername == $currentUser) {
        echo "Username cannot be modified into old username!!!";
    }
    else {
        // Check if the new username is not present in the database because it should be unique
        $checkSql = "SELECT `username` FROM `User` WHERE `username`='$newUsername'";
        $checkResult = mysqli_query($conn, $checkSql);

        if ($checkResult) {

            // if it is 0 then we can modify this user's username
            if (mysqli_num_rows($checkResult) == 0) {

                // Update the username
                $updateSql = "UPDATE `User` set `username`='$newUsername' where `username`= '$currentUser'";

                if (mysqli_query($conn, $updateSql)) {
                    // Username successfully updated
                    echo "Username updated successfully!";
                    $_SESSION['userid'] = $newUsername;
                } else {
                    echo "Error updating Username: " . mysqli_error($conn);
                }
            } else {
                echo 'Username already exists. Try Different Username';
            }

        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Change Username</title>
</head>

<body>
    <h2>Change Username</h2>
    <form action="userChangeUsername.php" method="post">
        <label for="newUsername">New Username:</label>
        <input type="text" name="newUsername" id="newUsername" required><br><br>

        <input type="submit" value="Change Username">
    </form>
    <a href="userHome.php">Back to user Home</a><br><br>
    <a href="userLogout.php">Logout</a>
</body>

</html>