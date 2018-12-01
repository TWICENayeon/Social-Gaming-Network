<!DOCTYPE html>



<?php
// Gain access to the session array
session_start();

 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

// $_SESSION["page_id"] = $_POST["page_id"];
?>
<?php
	
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
?>

<?php

		// Get number of unresolved notifications
		$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
								FROM notifications
								WHERE recipient_id = " . $_SESSION["current_user_id"] . " and
								resolved_status = false;";
	
		// echo $fetch_num_unresolved_notifications_query;
		$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];


		// Manage chat invite
		if(!empty($_POST['invited_username'])) {
			$search_valid_user = "SELECT user_id 
									  FROM sgn_database.users 
									  WHERE username = '" .  $_POST['invited_username'] . "';";
			
										  
			$tuple = ($conn->query($search_valid_user))->fetch_assoc();
			if(!empty($tuple["user_id"])) {
				echo $tuple["user_id"] . "<br><br>";
				//echo "invited user found";
				$search_in_chat = "SELECT chat_member_id 
											  FROM sgn_database.chat_group_members 
											  WHERE chat_member_id = " .  $tuple['user_id'] . " AND chat_id = " . $_POST["chat_group_id"] . ";";
											  
										  
				if(empty(($conn->query($search_in_chat))->fetch_assoc()["chat_member_id"])) {
					
					// Get chat name
					$search_in_chat = "SELECT chat_name 
											  FROM sgn_database.chat_groups 
											  WHERE chat_id = " . $_POST["chat_group_id"] . ";";
											  
					$esport_chat_name = (($conn->query($search_in_chat))->fetch_assoc())["chat_name"];
					
																	
					$insert_esport_chat_invitation_notification = "INSERT into sgn_database.notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
															VALUES(1, " . $_POST["chat_group_id"] . "," . $tuple['user_id'] . ", 'COME JOIN ESPORT CHAT -" . $conn->real_escape_string($esport_chat_name) . "-' , 0, CURRENT_DATE(), CURRENT_TIME());";
					
					if ( ($conn->query($insert_esport_chat_invitation_notification)) === TRUE) {
							echo "Notification has been properly sent.";
					} 
					else {
						echo $insert_esport_chat_invitation_notification;
						echo "Error: " . $insert_esport_chat_invitation_notification . "<br>" . $conn->error;
					}
				}
				else {
					echo $search_in_chat;
					echo "Specified user is already in the chat";
					exit();
				}
			}
			else {
				echo "Specified username is invalid";
				exit();
			}
			
		}



		// Get esports data
		$fetch_esports_data =  "SELECT esport_name, esport_stream_name
									FROM sgn_database.esports
									WHERE esport_id = 1";//" . $_SESSION["page_id"] .";";
		
		$result = ($conn->query($fetch_esports_data)->fetch_assoc());
		
		
		if(isset($_POST["create_flag"])) {
			echo "Create flag prompt received <br> <br> <br> <br> <br> <br>";
			$add_chat_id = "INSERT into sgn_database.chat_groups (chat_name, esport_id)
							VALUE ( '" . $_SESSION["current_username"] . "''s " . $result["esport_name"] . " Chat Room', " . $_SESSION["page_id"] . " );";
							
			$chat_id = $conn->insert_id;
			
			$add_chat_member_id = "INSERT into sgn_database.chat_group_members
										VALUE ( " . $chat_id . ", " . $_SESSION["current_user_id"] . " );";
										

		}


		echo "
<div class='streamCont'>
<iframe
    src='https://player.twitch.tv/?channel=riotgames&muted=true'
    height='480'
    width='760'
    frameborder='0'
    scrolling='no'
    allowfullscreen='true'>
</iframe>
</div>
<div class='streamChatCont'>
	<div class='streamChat'>
	</div>
</div>
";


		$conn->close();
?>


</html>
