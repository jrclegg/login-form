<?php

$mysql_connection = new mysqli("localhost", "root", "root", "login_system");
// Opens a new connection to the MySQL server, server = localhost, username = root, password = root, database = login_system
// $mysql_connection is the variable that represents the connection

// Store Email and Password user inputted data in variables
$Email = $_POST['Email'];
$Password =$_POST['Password'];

// Create a unique activation code as we will put it in the database AND put it in the email
$code = rand(5000, 200);

// create an INSERT SQL query that populates the login_system rows with the user entered values stored inside the variables
$sql = "INSERT INTO login_system (email, password, activation_code) VALUES ('$Email', '$Password', '$code');";

// performs a query against the MySQL database
$result = mysqli_query($mysql_connection, $sql);

?>