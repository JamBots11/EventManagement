<?php

session_start();
// if Not logged in then redirect to login page
if (!isset($_SESSION['adminUser'])) {
    header("Location : AdminLogin.php");
    exit;
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "testDB";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die ('connection failed : ' . mysqli_connect_error());
}

// write query to get the data 
$checkSql = "SELECT * FROM `User`";

// execute query
$result = mysqli_query($conn, $checkSql);

if ($result) {
    // check if query retured rows

    if (mysqli_num_rows($result) > 0) {
        // Output table header
        echo "<table>";
        echo "<tr><th>Username</th></tr>";

        // Output data from each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "</tr>";
        }

        // Close the table
        echo "</table><br><br><br>";
    }
    else {
        echo 'no records found !!!';
    }

}
else {
    "echo error : " . mysqli_error($conn);
}

// close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View User Data</title>
</head>

<body>

    <a href="AdminHome.php">Back to Admin Home</a><br>
    <a href="AdminLogout.php">Logout</a>
</body>

</html>

