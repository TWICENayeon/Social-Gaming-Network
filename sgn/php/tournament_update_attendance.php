<!DOCTYPE html>
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
		$num_participants_query = "SELECT count(participant_id) AS partCount
									FROM sgn_database.tournament_participants
									WHERE tournament_id = " . $_POST["tournament_id"] . ";";
									
		$count_result = intval((($conn->query($num_participants_query))->fetch_assoc())["partCount"]);;
		// process sign up
		if($_POST["actionType"] == 0) {
			
			$new_participance_query =  "INSERT INTO sgn_database.tournament_participants 
										VALUES (" . $_POST["tournament_id"] . ", " . $_SESSION["current_user_id"] . "," . (string) ($count_result + 1) . ");";
		
			$new_contender_result = $conn->query($new_participance_query);
		
			
			if($new_contender_result === false) {
				echo("Failed to insert new attendence");
				exit();
			}
		}
		// process leave
		else {
			// Get the ordering of the leaving contender
			$get_order = "SELECT ordering 
							FROM tournament_participants
							WHERE participant_id = " . $_SESSION["current_user_id"] . " AND tournament_id = " . $_POST["tournament_id"] . ";";
			
			$leaving_order_num = (($conn->query($get_order))->fetch_assoc())["ordering"];
							
			$reorder_counter = $leaving_order_num + 1;
			echo "To higher order";
			
			
			// Remove the leaving contender
			$remove_participance_query =  "DELETE FROM sgn_database.tournament_participants 
											WHERE participant_id = " . $_SESSION["current_user_id"] . " AND tournament_id = " . $_POST["tournament_id"] . ";";
		
			$result = $conn->query($remove_participance_query);
			
			if($result === false) {
				echo("Failed to remove attendence");
				exit();
			}
			
			// Update the contenders of higher order
			while ($reorder_counter <= $count_result) {
				$reorder_query = "UPDATE sgn_database.tournament_participants
									SET ordering = " . (string) ($reorder_counter - 1) . "
									WHERE tournament_id = " . $_POST["tournament_id"] . " AND ordering = " . $reorder_counter . ";";
									
				$conn->query($reorder_query);					
				
				$reorder_counter += 1;
			}
		}
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
</html>