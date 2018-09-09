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
	
	
	// Check if the post text has text
	// If so, insert the post int the database
	if(!empty($_POST["new_event_name"])) {
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}

		echo  "<br>";
		echo "Connection successful";
		echo  "<br>";

		
		// TODO: Escape single quotes and other sensitive characters
		if(isset($_POST["new_event_privacy"])) 
		{ 
			$new_event_privacy = 1;
		} else {
			$new_event_privacy = 0;
		}
		
		$new_event_query = "INSERT INTO sgn_database.events (event_name, event_description, event_start_date, event_start_time, event_privacy)
							VALUES ('" . $_POST["new_event_name"] . "', '" . $_POST["new_event_description"] . "', CURRENT_DATE(), CURRENT_TIME(), " . $new_event_privacy . ");";


		echo $new_event_query;
		$result = $conn->query($new_event_query);
		
		$new_event_id = $conn->insert_id;

		if($result === false) {
			echo "Event insertion query failed";
			exit();
		
		}
		
		$new_group_event_query = "INSERT INTO sgn_database.group_events
							VALUES (" . $_SESSION["page_id"] . ", " . $new_event_id . ");";


		echo $new_group_event_query;
		$result = $conn->query($new_group_event_query);
		

		if($result === false) {
			echo "Event insertion query failed" . $conn->error;
			exit();
		
		}
		
		$new_attendee_query = "INSERT INTO sgn_database.attendees 
							VALUES (" . $_SESSION["current_user_id"] . ", " . $new_event_id . ", CURRENT_DATE(), CURRENT_TIME(), " . " 'Creator');";


		echo $new_attendee_query;
		$result = $conn->query($new_attendee_query);

		if($result === false) {
			echo "Attendee insertion query failed " . 	$conn->error;
			exit();
		}

		$conn->close();
	// Redirect back to the page
	if(ob_get_length()) {
		ob_end_clean();
	}

	// TODO: Redirect to the page that has been posted
	// Not just to the user's page
	header("Location: http://localhost/sgn/event_page.php?page_id=" . $new_event_id);
	}
	


?>