<!DOCTYPE html>

<?php
// Allows access to the session array
session_start();

// Check if there is a user signed in_array
// If not, redirect to index page
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
	$conn->select_db("sgn_database");
	
	$freeStreamName = $_POST["freeStreamName"];
	
	echo "<iframe
			src='https://player.twitch.tv/?channel=". strtolower($freeStreamName) . "'
			height='478'
			width='765'
			frameborder='0'
			scrolling='no'
			allowfullscreen='true'>
		</iframe>";
	
?>