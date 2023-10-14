<?php
session_start();

// Destroy all user-related sessions
session_unset();
session_destroy();

// Redirect to the login page
header("Location: AdminLogin.php");
exit;
?>