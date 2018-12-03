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
	
	$group_id = $_POST["group_id"];
	
	$insert_new_membership_query = "INSERT INTO memberships
									VALUES(" . $_SESSION["current_user_id"] . ", " . $group_id . ", 0, CURRENT_DATE(), CURRENT_TIME());";
									
	$conn->query($insert_new_membership_query);
	
?>