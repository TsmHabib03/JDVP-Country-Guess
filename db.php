<?php
$host = "localhost";
$user = "root";
$pass = "muning0328";
$dbname = "country_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed");
}
?>