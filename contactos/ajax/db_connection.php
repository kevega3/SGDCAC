<?php

// Connection variables 
$host = "localhost"; // MySQL host name eg. localhost
$user = "altocost_wp"; // MySQL user. eg. root ( if your on localserver)
$password = "z#wc4C2o18*"; // MySQL user password  (if password is not set for your root user then keep it empty )
$database = "sgdcac"; // MySQL Database name

// Connect to MySQL Database
$con = new mysqli($host, $user, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>