<?php
// Gain access to the session array
session_start();

// 
// if(!isset($_SESSION["current_user_id"])) {
	// header("Location: http://localhost/sgn/index.php");
	// exit();
// }
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
		$stream_name = $_POST["stream_name"];
		
		$tournament_id = $_POST["tournament_id"];
		
		
		$update_tournament_stream = "UPDATE tournaments
									SET twitch_stream = '" . $stream_name . "'
									WHERE tournament_id = " . $tournament_id . ";";
									
		echo $update_tournament_stream;							
		$conn->query($update_tournament_stream);
		// if(!empty($_POST["sign_up"])) {
			// $search_participance_query =  "SELECT participant_id
										// FROM sgn_database.tournament_participants
										// WHERE tournament_id = " . $_SESSION["page_id"] . " AND participant_id = ". $_SESSION["current_user_id"] .";";
		
			// //echo $search_participance_query;
			// $result = $conn->query($search_participance_query);
			// if($result->num_rows == 0) {
				
			// }
			// else {
				// echo "You have already signed up.";
			// }
		// }
		// else if(!empty($_POST["leave"])) {
		// }

?>