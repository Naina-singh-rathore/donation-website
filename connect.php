
<?php
$host = "localhost"; // or "localhost"
$username = "root";
$password = "";
$database = "givers";
$port = 3306; // Default MySQL port

$con = mysqli_connect($host, $username, $password, $database, $port);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
