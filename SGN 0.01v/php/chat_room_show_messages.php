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
	
	//$_SESSION["page_id"] = $_GET["page_id"];
	//$_SESSION["page_type"] = 5;		// Chat page 
?>



<html>
	
	

	<!-- Banner Start -->
	
	<!-- Banner End-->
	
	
	<?php 
	// Connect to the database
		$chat_room_id = $_GET["chat_room_id"];
	
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$get_chat_messages_query = "SELECT chat_writer_id, chat_write_date, chat_write_time, chat_message
											FROM sgn_database.chat_group_messages
											WHERE chat_id = " . $chat_room_id . ";";
						
		$messages_result = $conn->query($get_chat_messages_query);
		
		while($row = $messages_result->fetch_assoc()) {
				$get_username_query = "SELECT username
										FROM sgn_database.users
										WHERE user_id = " . $row["chat_writer_id"] . ";";
				$username = (($conn->query($get_username_query))->fetch_assoc())["username"];
				echo "<u>" . $username . "</u><br>";
				echo $row["chat_write_date"] . "  " . $row["chat_write_time"] . "<br><br>";
				echo $row["chat_message"] . "<br><br><br>";
		}
		
	?>
</html>