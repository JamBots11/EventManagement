<?php
session_start();

// Check if the user is not logged in, redirect to login.php if not
if (!isset($_SESSION['adminUser'])) {
    header("Location: AdminLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Home</title>
</head>

<body>
    <h2>Welcome,
        <?php echo $_SESSION['adminUser']; ?>!
    </h2>
    <p>This is the Admin home page. You can view various information here.</p>
    <a href="AdminChangePassword.php">Change Password</a><br><br>
    <a href="AdminCreateEvent.php">Admin Create Event</a> <br><br>
    <a href="AdminViewEvents.php">Admin View Events</a> <br><br>
    <a href="AdminViewUserData.php">Admin View User Data</a> <br><br>
    <a href="AdminLogout.php">Logout</a>
</body>

</html>