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

		//echo $_SESSION["page_id"] .  "<br><br><br><br><br><br>";
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		echo "old_round_num: " . $_POST["old_round_num"] . "<br><br><br><br>";
		echo "old_match_num: " . $_POST["old_match_num"] . "<br><br><br><br>";
		
		$new_round_num = intval($_POST["old_round_num"]) + 1;
		$new_match_num = ceil(floatval($_POST["old_match_num"]) / 2);
		
		
		
		echo "new_round_num: " . $new_round_num . "<br><br><br><br>";
		echo "new_match_num: " . $new_match_num . "<br><br><br><br>";
		
		
		echo "winner_id: " . $_POST["winner_id"] . "<br><br><br><br>";
		
		
		$match_position = "";
		$result = 0;
		
		if($_POST["old_match_num"] % 2 == 1) {
			$match_position = "participant_1_id";
		}
		else {
			
			$match_position = "participant_2_id";
		}
		
		$update_finished_match_query = "UPDATE sgn_database.tournament_matches
										SET finished = true
										WHERE tournament_id = " . $_SESSION["page_id"] . " AND relative_match_id = " . $_POST["old_match_num"] . " AND round = " . $_POST["old_round_num"] . ";";
										
		if($debug) {	
			echo "update finished match query: " . $update_finished_match_query . "<br><br><br><br>";
		}
		else {
			$result = $conn->query($update_finished_match_query);
		}
		
		
		$search_match_exists_query = "SELECT match_id
								FROM sgn_database.tournament_matches
								WHERE tournament_id = " . $_SESSION["page_id"] . " AND relative_match_id = " . $new_match_num . " AND round = " . $new_round_num . ";";
		
		
		$result = 0;		
		
		if($debug) {	
			echo "search match exists query: " . $search_match_exists_query . "<br><br><br><br>";
		}
		
		$result = $conn->query($search_match_exists_query);
		
		echo $result->num_rows . "<br><br>";
		if($result->num_rows == 0) {
			
			// TODO: Check for solo matches that need to be bubbled up
			
			$update_id = $conn->insert_id;
			
			
			$num_participants_query = "SELECT count(participant_id) AS partCount
									FROM sgn_database.tournament_participants
									WHERE tournament_id = " . $_SESSION["page_id"] . ";";
									
			$result = $conn->query($num_participants_query);
			
			$num_players_total = intval(($result->fetch_assoc())["partCount"]);
			
			$num_players_current_round = ceil($num_players_total/pow(2, $_POST["old_round_num"]));
			
			// Check if there are an odd number of players this round, last one is alone in a match
			if($debug) {
				echo "$num_players_total/(pow(2, " . $_POST["old_round_num"] . ")): " . ($num_players_total/(pow(2, $_POST["old_round_num"]))) . "<br><br><br>";
			}
			if(($num_players_total/(pow(2, $_POST["old_round_num"]))) <= 1) {
				$new_round_num = 0;
				$new_match_num = 0;
				$match_position = "participant_1_id";
			}
			else if($num_players_current_round % 2 == 1) {
				// Find the match ID of the loner match and use it to validate if it is the match we want to insert is the loner match
				$rel_match_id_to_bubble = ceil($num_players_current_round / 2);
				
				// Bubble up the loner match by the appropiate amount
				if($new_match_num == $rel_match_id_to_bubble) {
					// Get number of matches to bubble the loner match up by
					$rounds_to_bubble = ceil($rel_match_id_to_bubble/2);
					$new_round_num += $rounds_to_bubble;
					$new_match_num = ceil($new_match_num/pow(2, $rounds_to_bubble));
				}
			}
			
			$insert_new_match_query = "INSERT INTO sgn_database.tournament_matches (tournament_id, relative_match_id, round, " . $match_position . ")
									VALUES ( " . $_SESSION["page_id"] . ", " . $new_match_num . ", " . $new_round_num . ", " . $_POST["winner_id"] . ");";
			
			
			if($debug) {							
				echo "insert new match query: " .  $insert_new_match_query . "<br><br><br><br>";
			}
			else {
				$result = $conn->query($insert_new_match_query);
			}
		}
		else {
			
			$current_match_id = ($result->fetch_assoc())["match_id"];
			
			$update_winner_query = "UPDATE sgn_database.tournament_matches
									SET " . $match_position . " = " . $_POST["winner_id"] . "
									WHERE match_id = " . $current_match_id . ";";		
			
			if($debug) {
				echo "update winner match query: " .  $update_winner_query . "<br><br><br><br>";
			}
			else {			
				$result = $conn->query($update_winner_query);
			}
			
		}
		
		if (!$debug) {
			if(ob_get_length()) {
				ob_end_clean();
			}

			// echo "Heading to tournament page";
			header("Location: http://localhost/sgn/tournament_page.php?page_id=" . $_SESSION["page_id"]);
		}
	?>
	<br>
	<br>
	<br>
	Tournament Score Update page under construction

</html>