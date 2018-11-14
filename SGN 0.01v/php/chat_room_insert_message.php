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
	$debug = false;
	
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$new_message = $_POST["new_message"];
		$chat_id = $_POST["chat_id"];
		$writer_id = $_POST["writer_id"];

		$conn->select_db("sgn_database");
		
		$insert_message_query ="INSERT INTO chat_group_messages (chat_id, chat_writer_id, chat_write_date, chat_write_time, chat_message)
				VALUES (" . $chat_id . ", " . $writer_id . ", CURRENT_DATE(), CURRENT_TIME(), '" . $new_message . "');";
		
		if(!$debug) {
			echo $insert_message_query;
			$conn->query($insert_message_query);
		}
		
		
		mysqli_close($conn);
		
	?>
	
</html>