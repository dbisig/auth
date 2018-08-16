<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'pass');
define('DB_NAME', 'auth2');
define('SALT1', 'cd58d7d930f8ad3e15e7cbb7477ebf49f9548f9717e298b6af431e468bdcb746');

/* Attempt to connect to MySQL database */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conn->connect_error){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>
