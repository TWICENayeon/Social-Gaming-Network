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
	
	$friended_id = $_POST["friended_id"]; 
	
	$remove_friendship_query = "UPDATE friendships
							SET active = 0
							WHERE (friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $friended_id  . " ) OR  (friend_id_1 = " . $friended_id . " AND friend_id_2 = " . $_SESSION["current_user_id"] . ");";
							
	$conn->query($remove_friendship_query);
	
?>