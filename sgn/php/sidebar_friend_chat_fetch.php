<?php
// Allows access to the session array
session_start();

// Check if there is a user signed in_array
// If not, redirect to index page
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
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
	$friend_id = $_POST["friend_id"];
	
	$friend_name_query = "SELECT username
							FROM users
							WHERE user_id = " . $friend_id . ";";
							
	$friend_name = (($conn->query($friend_name_query))->fetch_assoc())["username"];
	
	$friend_profile_picture_query = "SELECT image_name
							FROM images
							WHERE owner_type = 0 AND owner_id = " . $friend_id . " AND currently_set = 1 AND image_type = 0;";
							
	
	$friend_profile_picture_name = (($conn->query($friend_profile_picture_query))->fetch_assoc())["image_name"];
	
	$self_profile_picture_name_query = "SELECT image_name
							FROM images
							WHERE owner_type = 0 AND owner_id = " . $_SESSION["current_user_id"] . " AND currently_set = 1 AND image_type = 0;";
							
							
	$self_profile_picture_name = (($conn->query($self_profile_picture_name_query))->fetch_assoc())["image_name"];

	echo "
				<div class='chatFriendName'>" . $friend_name . "</div>
				<div class='messageBoxCont' id='messageContID'>
					<!-- <div class='messageCont' ></div> -->";
					
					$fetch_chat_room_id_query = "SELECT chat_id 
												FROM friendships
												WHERE (friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 =  " . $friend_id . " ) OR  (friend_id_1 = " . $friend_id . "  AND friend_id_2 = " . $_SESSION["current_user_id"] . " );";
												
					$chat_room_id = (($conn->query($fetch_chat_room_id_query))->fetch_assoc())["chat_id"];
					
					$get_chat_messages_query = "SELECT chat_writer_id, chat_message
											FROM sgn_database.chat_group_messages
											WHERE chat_id = " . $chat_room_id . ";";
											
					$chat_messages_result = $conn->query($get_chat_messages_query);
					
					
					if($chat_messages_result->num_rows > 0) {
					
						while($chat_message_tuple = $chat_messages_result->fetch_assoc()) {
							if($chat_message_tuple["chat_writer_id"] == $_SESSION["current_user_id"]) {
								echo "<div class='container darker' >
										  <div class='chatProfImage' style='background-image: url(user_images/" . (!empty($self_profile_picture_name) ? $self_profile_picture_name : "Profile-icon-9.png") . ")'></div>
										  ";
							}
							else {
								echo "<div class='container'>
								  <div class='friendChatImage'  style='background-image: url(user_images/" . (!empty($friend_profile_picture_name) ? $friend_profile_picture_name : "Profile-icon-9.png") . ")'></div>
								  ";
							}
							echo "<p id='chatText'>" . $chat_message_tuple["chat_message"] . "</p>					  
								</div>";
						}
					}
					else {		
						echo "<div class='container darker' >
										  <p id='chatText' style='text-align:center;color:white'>No messages</p>					  
								</div>";

					}
											
					
					
		echo "</div>
				<div class='chatTextBox'>
					<form name='chatTextCont' id='chatTextCont'>
						<input name='usermsg' type='text' id='usermsg' size='63'>
						<input name='submitmsg' type='button' id='submitmsg' value='Send' onclick='sidebarSubmitNewMessage(" . $chat_room_id . ")'>
					</form>
				</div>
				<div class='chatButtons'>
					<button class='btn btn-primary friendListButton' onclick='fetchSidebarFriendsList();'>Back to Friends List</button>
				</div>";
				
		$unset_self_new_message_query = "UPDATE chat_group_members
										SET new_message = 0
										WHERE chat_id = " . $chat_room_id . " AND chat_member_id = " . $_SESSION["current_user_id"] . ";";
										
		$conn->query($unset_self_new_message_query);

?>