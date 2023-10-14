<?php
session_start();

// Check if the user is not logged in, redirect to login.php if not
if (!isset($_SESSION['userid'])) {
    header("Location: userLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Home</title>
</head>

<body>
    <h2>Welcome,
        <?php echo $_SESSION['userid']; ?>!
    </h2>
    <p>This is the User home page. You can view events and other information here.</p>
    <a href="userChangeUsername.php">Change Username</a><br> <br>
    <a href="userChangePassword.php">Change Password</a><br> <br>
    <a href="userViewEvents.php">View Events</a><br> <br>
    <a href="userLogout.php">Logout</a><br>
</body>

</html>