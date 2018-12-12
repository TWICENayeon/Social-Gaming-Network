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
								
	// echo $_POST["notification_id"];
	// echo $_POST["action"];
	// echo $_POST["notification_id"];
	$notification_data_result = $conn->query($fetch_notification_data_query);
	
	if($notification_data_result->num_rows == 1) {
		$notification_data_tuple = $notification_data_result->fetch_assoc();
		// If notification is for an esport chat
		
		if($_POST["action"] == "1") {
			// If notification is for a group invite, is 1
			if($notification_data_tuple["notification_type"] == "1") {
				
				$new_group_member_query = "INSERT INTO sgn_database.memberships 
											VALUES (" . $_SESSION["current_user_id"] . ", " . $notification_data_tuple["invitation_to_id"] . ", 0, CURRENT_DATE(), CURRENT_TIME());";
											
					
				$conn->query($new_group_member_query);
			}
			// If notification is for a friend invite, is 0
			else if($notification_data_tuple["notification_type"] == "0") {
				$search_friend =  "SELECT friendship_id, active
									FROM sgn_database.friendships
									WHERE ((friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $notification_data_tuple["invitation_to_id"] . ") OR 
									(friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $notification_data_tuple["invitation_to_id"] . "));";
				
				$result = $conn->query($search_friend);
				
				if($result->num_rows == 0) {
					
					// Add new chat group for the new friendship pair
					
					$new_friend_chat_query =  "INSERT INTO sgn_database.chat_groups (esport_id) 
											  VALUES (0);";										// 0 means it is a friend chat 
				
					$result = $conn->query($new_friend_chat_query);
					
					if($result === false) {
						echo("Failed to insert new friendship chat pair");
						exit();
					}
					
					$chat_id = $conn->insert_id;
					
					// Make current user as a member to new chat group
					
					$new_chat_member_one = "INSERT INTO sgn_database.chat_group_members 
											VALUES (" . $chat_id . ", " . $_SESSION["current_user_id"] . ", 0)";
											
					
				
					$result = $conn->query($new_chat_member_one);
					
					if($result === false) {
						echo($chat_id);
						echo("				");
						echo($_SESSION["current_user_id"]);
						echo $new_chat_member_one;
						echo("Failed to insert new chat friend 1");
						exit();
					}
					
					
					// Make new friend as a member to new chat group
					
					$new_chat_member_two = "INSERT INTO sgn_database.chat_group_members 
											VALUES (" . $chat_id . ", " . $notification_data_tuple["invitation_to_id"] . ", 0)";
											
					
				
					$result = $conn->query($new_chat_member_two);
					
					if($result === false) {
						echo("Failed to insert new chat friend 2");
						exit();
					}
					
					// add frienship
					$new_friendship_query =  "INSERT INTO sgn_database.friendships (friend_id_1, friend_id_2, friendship_start_date, chat_id, active)
											  VALUES (" . $_SESSION["current_user_id"] . ", " . $notification_data_tuple["invitation_to_id"] . ", CURRENT_DATE(), " . $chat_id . ", 1);";
				
					$result = $conn->query($new_friendship_query);
					
					if($result === false) {
						echo $new_friendship_query;
						echo("<br> <br> <br> Failed to insert new friendship!!");
						exit();
					}
				}
				else {
					$refriend_query =  "UPDATE sgn_database.friendships
									SET active = true
									WHERE ((friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $notification_data_tuple["invitation_to_id"] . ") OR 
									(friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $notification_data_tuple["invitation_to_id"] . "));";
			
					$result = $conn->query($refriend_query);
					
					if($result === false) {
						echo $refriend_query;
						echo("Failed to update friendship active status to false");
						exit();
					}
				}
				$insert_friendship_accept_notification_query = "INSERT INTO notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
											VALUES (2, " . $_SESSION["current_user_id"] . ", " . $notification_data_tuple["invitation_to_id"] . ", '" . $_SESSION["current_username"] . " has accepted your friend request', 0, CURRENT_DATE(), CURRENT_TIME());";
									
				$conn->query($insert_friendship_accept_notification_query);
				
				echo $insert_friendship_accept_notification_query;
			}
		}
		else {
			if($notification_data_tuple["notification_type"] == "0") {
				$insert_friendship_rejection_notification_query = "INSERT INTO notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
											VALUES (2, " . $_SESSION["current_user_id"] . ", " . $notification_data_tuple["invitation_to_id"] . ", '" . $_SESSION["current_username"] . " has declined your friend request', 0, CURRENT_DATE(), CURRENT_TIME());";
									
				$conn->query($insert_friendship_rejection_notification_query);
				
				echo $insert_friendship_rejection_notification_query;
				
			}
		}
		
		
		$update_resolved_query = "UPDATE notifications
							SET resolved_status = 1
							WHERE notification_id = " . $_POST["notification_id"] . ";";
		
		
		
		if(!$conn->query($update_resolved_query)) {
			echo $conn->error;
		}
	}
	else {
		
		echo "<br>fetch notification data failed";
		exit();
	}

	// if(ob_get_length()) {
		// ob_end_clean();
	// }

	// header("Location: http://localhost/sgn/my_notifications.php");

?>