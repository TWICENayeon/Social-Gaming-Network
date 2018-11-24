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
	

		//echo $_SESSION["page_id"] .  "<br><br><br><br><br><br>";
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");
		
		$conn->select_db("sgn_database");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		echo "user_id: " . $_POST["user_id"] . "<br><br><br>";
		
		echo "order: " . $_POST["order"] . "<br><br><br>";
		
		$num_contenders_query = "SELECT count(participant_id) AS contenderCount
									FROM tournament_participants
									WHERE tournament_id = " . $_POST["tournament_id"] . ";";
									
		$num_contenders = (($conn->query($num_contenders_query))->fetch_assoc())["contenderCount"];
		
		if(intval($_POST["order"]) < 1 || intval($_POST["order"]) > $num_contenders) {
			exit();
		}
		
		$fetch_old_order_query = "SELECT ordering
									FROM sgn_database.tournament_participants
									WHERE tournament_id = " . $_POST["tournament_id"] . " AND participant_id = " . $_POST["user_id"] . ";";
											
		$result = $conn->query($fetch_old_order_query);

		$int_old_value = intval(($result->fetch_assoc())["ordering"]);
		
		if($int_old_value < intval($_POST["order"])) {
			
			$reorder_counter = $int_old_value + 1;
			echo "To higher order";
			
			while ($reorder_counter <= intval($_POST["order"])) {
				$reorder_query = "UPDATE sgn_database.tournament_participants
									SET ordering = " . (string) ($reorder_counter - 1) . "
									WHERE tournament_id = " . $_POST["tournament_id"] . " AND ordering = " . $reorder_counter . ";";
									
				$conn->query($reorder_query);					
				
				$reorder_counter += 1;
			}
		}
		else if($int_old_value > intval($_POST["order"])) {
			$reorder_counter = $int_old_value - 1;
			echo "To lower order <br> <br> <br>";
			echo "Reorder counter: " . $reorder_counter . "<br> <br> <br>";
			echo "int old value: " . $int_old_value . "<br> <br> <br>";
			while ($reorder_counter >= intval($_POST["order"])) {
				$reorder_query = "UPDATE sgn_database.tournament_participants
									SET ordering = " . (string) ($reorder_counter + 1) . "
									WHERE tournament_id = " . $_POST["tournament_id"] . " AND ordering = " . $reorder_counter . ";";
									
				echo "Reorder query: " . $reorder_query . "<br> <br> <br>";
				
				
				$conn->query($reorder_query);					
				
				$reorder_counter -= 1;
			}
		}
		
		$update_order_query =  "UPDATE sgn_database.tournament_participants
									SET ordering = " . $_POST["order"] . "
									WHERE tournament_id = " . $_POST["tournament_id"] . " AND participant_id = " . $_POST["user_id"] . ";";
									
		
		echo $update_order_query . "<br><br><br><br><br><br>";
			
		$result = $conn->query($update_order_query);
		
		
		// $num_participant_count_query = "SELECT count(participant_id) AS COUNT
										// FROM sgn_database.tournament_participants
										// WHERE tournament_id = " . $_SESSION["page_id"] . ";";
		
		
		echo "done";
		// if(ob_get_length()) {
			// ob_end_clean();
		// }

		// // echo "Heading to tournament page";
		// header("Location: http://localhost/sgn/tournament_page.php?page_id=" . $_SESSION["page_id"]);
	?>
	
	Tournament Update page under construction

</html>