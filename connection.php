<?php 
	/**
	 * 
	 * Author : sachin chandrakant mohite
	 * Project: augment
	 * Date: 21 Dec 2021
	 * Database connection file
	 * 
	 * 
	 * */


	$host = 'localhost';
	$username = "root";
	$password = '';
	$db = 'testdb';
 
	// Create connection
	$conn = new mysqli($host, $username, $password,$db);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

?>
