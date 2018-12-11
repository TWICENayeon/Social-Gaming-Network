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

	$chat_id = $_POST["chat_id"];
	$chat_message = $conn->real_escape_string($_POST["chat_message"]);
	
	if(empty($chat_message)) {
		exit;
	}
	
	$insert_new_message_query = "INSERT INTO chat_group_messages (chat_id, chat_writer_id, chat_write_date, chat_write_time, chat_message)
								VALUES (" . $chat_id . ", " . $_SESSION["current_user_id"] . ", CURRENT_DATE(), CURRENT_TIME(), '" . $chat_message . "');";
								
	echo $insert_new_message_query;
								
	$conn->query($insert_new_message_query);
	
	$other_chatter_id_query = "SELECT chat_member_id FROM chat_group_members WHERE chat_id = " . $chat_id . " AND chat_member_id != " . $_SESSION["current_user_id"] . ";";
	
	$other_chatter_id = (($conn->query($other_chatter_id_query))->fetch_assoc())["chat_member_id"];
	

	$update_other_chatter_new_query = "UPDATE chat_group_members
										SET new_message = 1
										WHERE chat_id = " . $chat_id . " AND chat_member_id = " . $other_chatter_id . ";";
										
	$conn->query($update_other_chatter_new_query);


?>