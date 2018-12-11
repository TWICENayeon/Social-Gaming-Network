<?php
// Allows access to the session array
session_start();

// Check if there is a user signed in_array
// If not, redirect to index page
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.html");
	exit();
}
?>
<?php 

	$conn = new mysqli("localhost", "root", "");

		
	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}
	
	$conn->select_db("sgn_database");

?>

<?php
	$fetch_friends_query = "SELECT friend_id_2 AS friend_id, username AS friend_username
								FROM sgn_database.friendships JOIN sgn_database.users
								ON friendships.friend_id_2 = users.user_id
								WHERE friend_id_1 = " . $_SESSION["current_user_id"] . " AND active = true
								UNION
								SELECT friend_id_1 AS friend_id, username
								FROM sgn_database.friendships JOIN sgn_database.users
								ON friendships.friend_id_1 = users.user_id
								WHERE friend_id_2 = " . $_SESSION["current_user_id"] . " AND active = true
								ORDER BY friend_id ASC;";
								
	$friends_result = $conn->query($fetch_friends_query);
	
	

	echo "<div class='friendList' id='friendContBox'><div class='friendsListTitle'>Friends List</div>
			<div id='friendsClosedContainables'>
				<div class='friendsPopChatDialog'>Click/drag to show chat!</div>
				<div class='friendArrowDirection'>&#8595;</div>
			</div>
			<div class='friendListBox' id='friendBox'>
				<div class='friendListContent'>
				";
			while($friend_tuple = $friends_result->fetch_assoc()) {
				$friend_id = $friend_tuple["friend_id"];
				
				$fetch_friend_picture_name = "SELECT image_name
											FROM images
											WHERE owner_type = 0 AND owner_id = " . $friend_id . " AND currently_set = 1 AND image_type = 0;";
											
				$friend_picture_name = (($conn->query($fetch_friend_picture_name))->fetch_assoc())["image_name"];
				
				$check_new_message_status_query = "SELECT new_message
													FROM chat_group_members
													WHERE chat";
													
				$friend_chat_info_query = "SELECT new_message
											FROM chat_group_members
											WHERE chat_id IN(
											SELECT chat_id 
											FROM chat_group_members
											WHERE chat_member_id = " . $friend_id . ") AND chat_member_id = " . $_SESSION["current_user_id"] . ";";
											
				$has_new_message = (($conn->query($friend_chat_info_query))->fetch_assoc())["new_message"] == "1";
				
				
				echo "<div class=\"friendCont\">
						<div class=\"friendHeader\">
							<div class=\"friendContImage\" style='background-image: url(user_images/" . $friend_picture_name . ")'></div>
							<div class=\"friendName\">" . $friend_tuple["friend_username"] . "</div>
						</div>
						<div class=\"friendButtons\">
							<button class=\"btn btn-primary\" id=\"friendWallButton\" onclick='showTab(0, " . $friend_id . ")'>Wall</button>
							<button class=\"btn btn-" . ($has_new_message? "warning" : "primary") . "\" id=\"friendChatButton\" onclick='fetchSidebarChat(" . $friend_id . "); '>Chat</button>
						</div>
					</div>";
			}
				echo "</div>
					</div>
				</div>";

?>