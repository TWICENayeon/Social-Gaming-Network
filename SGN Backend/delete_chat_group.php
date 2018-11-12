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
		
		// Get chat id of chat group to delete 
		
		
		$to_delete_chat_id = $_POST["chat_id"];
		
	?>
	
	
	<?php
	// Remove messages in chat
	
		$delete_chat_messages_query = "DELETE FROM chat_group_messages
										WHERE chat_id = " . $to_delete_chat_id . ";";
		
		echo $delete_chat_messages_query;
		
		$conn->query($delete_chat_messages_query);
		
		echo "<br><br><br>";
	// Remove memberships in chat
	
		$delete_chat_memberships_query = "DELETE FROM chat_group_members
											WHERE chat_id = " . $to_delete_chat_id . ";";
		
		echo $delete_chat_memberships_query;
		
		$conn->query($delete_chat_memberships_query);
		
		echo "<br><br><br>";
	// Remove memberships in chat
	
		$delete_chat_query = "DELETE FROM chat_groups
								WHERE chat_id = " . $to_delete_chat_id . ";";
		
		echo $delete_chat_query;
		
		$conn->query($delete_chat_query);
		
		
		header("Location: http://localhost/sgn/chat_room_list.php");
		
	?>