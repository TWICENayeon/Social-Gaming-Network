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
	
	$invited_username = $_POST["invited_username"];
	
	
	$fetch_group_name_query = "SELECT group_name
								FROM groups
								WHERE group_id = " . $group_id . ";";
								
	$inviting_group_name = (($conn->query($fetch_group_name_query))->fetch_assoc())["group_name"];
	
	$fetch_invited_user_id_query = "SELECT user_id
									FROM users
									WHERE username = '" . $invited_username . "';";
									
	$invited_user_id = (($conn->query($fetch_invited_user_id_query))->fetch_assoc())["user_id"];
	
	$insert_group_invite_notification_query = "INSERT INTO notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
											VALUES(1, " . $group_id . ", " . $invited_user_id . ", 'Come join -" . $inviting_group_name . "-', 0, CURRENT_DATE(), CURRENT_TIME());";
									
	$conn->query($insert_group_invite_notification_query);
	
?>