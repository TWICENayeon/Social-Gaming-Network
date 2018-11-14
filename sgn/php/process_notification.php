<!DOCTYPE html>

<?php
	// Get access to the "$_SESSION" array
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

	$debug = false;
	$fetch_notification_data_query = "SELECT *
										FROM sgn_database.notifications
										WHERE notification_id = " . $_POST["notification_id"] . ";";

	echo $fetch_notification_data_query . "<br>";									
	// echo $_POST["notification_id"];
	$notification_data_result = $conn->query($fetch_notification_data_query);
	
	if($notification_data_result->num_rows == 1) {
		$notification_data_tuple = $notification_data_result->fetch_assoc();
		// If notification is for an esport chat
		
		if(isset($_POST["accept"])) {
			// If notification is for an esport chat, is 1
			if($notification_data_tuple["notification_type"]) {
				$new_esport_chat_member_query = "INSERT INTO sgn_database.chat_group_members 
											VALUES (" . $notification_data_tuple["invitation_to_id"] . ", " . $_SESSION["current_user_id"] . ")";
											
					
				if($debug) {
					echo "<br>New Esport Chat query: " . $new_esport_chat_member_query;
				}
				else {
					if(!$conn->query($new_esport_chat_member_query)) {
						echo $conn->error;
					}
				}
					
			}
			// If notification is for a group, is 0
			else {
				$new_group_member_query = "INSERT INTO sgn_database.memberships 
											VALUES (" . $_SESSION["current_user_id"] . ", " . $notification_data_tuple["invitation_to_id"] . ", 0, CURRENT_DATE(), CURRENT_TIME());";
											
					
				if($debug) {
					echo "<br>New Group member: " . $new_group_member_query;
				}
				else {
					if(!$conn->query($new_group_member_query)) {
						echo $conn->error;
					}
				}
			}
		}
		
		
		$update_resolved_query = "UPDATE notifications
							SET resolved_status = 1
							WHERE notification_id = " . $_POST["notification_id"] . ";";
		
		if($debug) {
			echo "<br>update decline query: " . $update_resolved_query;
		}
		else {
			if(!$conn->query($update_resolved_query)) {
				echo $conn->error;
			}
		}
	}
	else {
		
		echo "<br>fetch notification data failed";
		exit();
	}

	if(ob_get_length()) {
		ob_end_clean();
	}

	header("Location: http://localhost/sgn/my_notifications.php");

?>