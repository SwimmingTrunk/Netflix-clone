<?php

$host = "localhost"; // the database server, localhost means it is running on the same machine
$username = "root"; // the database username, root is the default for local servers
$password = ""; // the database password, empty here because no password is set
$dbname = "netfish"; // the name of the database we want to connect to


$conn = new mysqli($host, $username, $password, $dbname);
// creates a new connection to the MySQL database using the details above


if ($conn->connect_error) {
    // checks if there was an error while trying to connect

    die("Connection failed: " . $conn->connect_error);
    // stops the script and shows an error message if connection failed
}


$conn->set_charset("utf8mb4");
// sets the character encoding to utf8mb4 so it supports all characters including emojis and special symbols

?>