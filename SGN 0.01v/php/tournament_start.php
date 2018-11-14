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
		$execute_all_queries = true;

		//echo $_SESSION["page_id"] .  "<br><br><br><br><br><br>";
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$num_participant_count_query = "SELECT count(participant_id) AS COUNT
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . ";";
										
		$result = $conn->query($num_participant_count_query);
		
		$participant_count = intval(($result->fetch_assoc())["COUNT"]);
		
		$highest_round = ceil(log($participant_count, 2));
		
		$num_startin_matches = 0;
		
		// for($counter = 1; $counter <= $highest_round; ++$counter) {
			// $total_matches += ceil($participant_count / pow(2, $counter));
		// }
		// $first_round_first_match_id = floor($total_matches - ($participant_count / 2) + 1);
		
		// echo "first round first match id: " . $first_round_first_match_id . "<br><br><br><br><br><br>";
		// echo "total matches: " . $total_matches . "<br><br><br><br><br><br>";
		// echo $highest_round;
		
		$order_num = 1;
		for($match_id = 1; $match_id <= ceil($participant_count/2); ++$match_id) {
			$search_participants_query = "SELECT participant_id
										 FROM sgn_database.tournament_participants
										 WHERE tournament_id = " . $_SESSION["page_id"] . " AND ordering = " . $order_num . 
										 " UNION 
										 SELECT participant_id
										 FROM sgn_database.tournament_participants
										 WHERE tournament_id = " . $_SESSION["page_id"] . " AND ordering = " . (string) ($order_num + 1) . ";";
										 

			
			$result = $conn->query($search_participants_query);
			
			$participant_one = ($result->fetch_assoc())["participant_id"];
			
			$participant_two = ($result->fetch_assoc())["participant_id"];
			
			
			
			
			echo $search_participants_query . "<br><br><br>";
			
			echo $participant_one . "<br>";
			
			
			echo $participant_two . "<br><br><br>";
			
			echo "Match ID: " . $match_id . "<br><br><br><br>";
			
			$insert_match_query = "";
			
			if (isset($participant_two)) {
				$insert_match_query = "INSERT INTO sgn_database.tournament_matches (tournament_id, relative_match_id, round, participant_1_id, participant_2_id) 
										VALUES (" . $_SESSION["page_id"] . ", " . $match_id . ", 1, " . $participant_one . ", " . $participant_two . " )";
			}
			else {
				echo "participant_count: " . $participant_count . "<br><br><br>";
				if (floor(log(($participant_count - 1), 2)) == log(($participant_count - 1), 2))  {
					$insert_match_query = "INSERT INTO sgn_database.tournament_matches (tournament_id, relative_match_id, round, participant_2_id) 
										VALUES (" . $_SESSION["page_id"] . ", 1, " . ceil(log($participant_count, 2)) . ", " . $participant_one . " )";
										
					echo ceil(log($participant_count, 2));
				}
				else {
					$insert_match_query = "INSERT INTO sgn_database.tournament_matches (tournament_id, relative_match_id, round, participant_2_id) 
										VALUES (" . $_SESSION["page_id"] . ", " . $match_id . ", 2, " . $participant_one . " )";
										
										echo "Else case";
				}
				// $insert_match_query = "INSERT INTO sgn_database.tournament_matches (tournament_id, relative_match_id, round, participant_1_id) 
										// VALUES (" . $_SESSION["page_id"] . ", " . $match_id . ", 1, " . $participant_one . " )";
										
				
			}
									
			
			if($execute_all_queries) {						
				$conn->query($insert_match_query);
			}
					
			echo "Insert Match Query: " . $insert_match_query . "<br><br><br><br>";
			
			$order_num += 2;
										 
			// $insert_round_query
		}
				
		$update_tournament_start_query = "UPDATE sgn_database.tournaments
										  SET started = true
										  WHERE tournament_id = " . $_SESSION["page_id"] . ";";
									
		if ($execute_all_queries) {							
			$conn->query($update_tournament_start_query);
		}
		
		echo $update_tournament_start_query;
		
		if(ob_get_length()) {
			ob_end_clean();
		}

		header("Location: http://localhost/sgn/tournament_page.php?page_id=" . $_SESSION["page_id"]);
	?>
	
	Tournament Update page under construction

</html>