<?php
$host = "relational.fit.cvut.cz";
$username = "guest";
$password = "relational";
$database_in_use = "classicmodels";

$mysqli = new mysqli($host, $username, $password, $database_in_use);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>