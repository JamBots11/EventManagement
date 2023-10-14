<?php
session_start();

// Check if the user is already logged in, redirect to home.php if so
if (isset($_SESSION['userid'])) {
    header("Location: userHome.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username and password match a record in the database
    $sql = "SELECT * FROM `User` WHERE `username`='$username' AND `userPassword`='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Store user information in session variables
        // $_SESSION['user_id'] = $row['id'];
        $_SESSION['userid'] = $row['username'];
        $_SESSION['userPassword'] = $row['userPassword'];
        // Redirect to the home page
        header("Location: userHome.php");
        exit;
    } else {
        $login_error = "Username or password is incorrect.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>User Login</h2>
    <form action="userLogin.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Log In">
    </form>
    <?php if (isset($login_error)) {
        echo "<p>$login_error</p>";
    } ?>
</body>

</html>