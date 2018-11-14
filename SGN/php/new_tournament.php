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
	
	
	// Check if the entire form is filled
	if(!empty($_POST["tournament_name"])) {
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}

		echo  "<br>";
		echo "Connection successful";
		echo  "<br>";

		
		$insert_new_tournament_query = "INSERT INTO sgn_database.tournaments (host_event_id, tournament_name, tournament_date, tournament_time)
								    VALUES (" . $_GET["event_id"] . ", '" . $_POST["tournament_name"] . "', '" . $_POST["tournament_date"] . "', '" . $_POST["tournament_time"] ."');";
									
		echo $insert_new_tournament_query;
		$result = $conn->query($insert_new_tournament_query);

		if($result === false) {
			echo "tournament insertion query failed";
			exit();
		}
		
		$new_tournament_id = $conn->insert_id;
		//Redirect back to the group page
		echo "This is the new tournament page";

		if(ob_get_length()) {
			ob_end_clean();
		}

		// echo "Heading to tournament page";
		header("Location: http://localhost/sgn/tournament_page.php?page_id=" . $new_tournament_id);
	}
	else {
		echo "Complete and utter failure";
	}


?>