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
	
	$insert_friendship_request_notification_query = "INSERT INTO notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
											VALUES(0, " . $_SESSION["current_user_id"] . ", " . $friended_id . ", '" . $_SESSION["current_username"] . " wants to be your friend', 0, CURRENT_DATE(), CURRENT_TIME());";
									
	$conn->query($insert_friendship_request_notification_query);
	
?>