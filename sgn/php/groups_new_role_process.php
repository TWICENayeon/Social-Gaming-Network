<!DOCTYPE html>

<?php
	// Gain access to session array
	session_start();
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.php");
		exit();
	}
?>
<html>
<?php 
	// Connect to the database
	$conn = new mysqli("localhost", "root", "");

		
	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}
	
	$conn->select_db("sgn_database");
	
	$update_new_role_query = "UPDATE memberships
								SET membership_role = " . $_POST["new_role"] . "
								WHERE of_group_id = " . $_POST["group_id"] . " AND member_id = " . $_POST["member_id"] . ";";
								
	echo $update_new_role_query;
								
	$conn->query($update_new_role_query);
	
?>