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
	
	$_SESSION["page_id"] = $_GET["page_id"];
	$_SESSION["page_type"] = 4 // tournament type of page;
?>

<!-- Banner Start -->
	<a href="http://localhost/sgn/user_page.php?page_id=<?php echo $_SESSION["current_user_id"]; ?>"> SGN </a> <br>
	<form action="search_results.php" method="get">
		<input type="text" name = "search_term" placeholder="Search. . ." >
		<input type="submit" value="Search">
	</form>
	<br>
	<a href="http://localhost/sgn/my_groups.php"> My Groups </a> <br>
	<a href="http://localhost/sgn/my_events.php"> My Events </a> <br>
	<a href="http://localhost/sgn/my_friends.php"> My Friends </a> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->



<html>
	
	<?php 
	

		//echo $_SESSION["page_id"] .  "<br><br><br><br><br><br>";
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		
		// Process sign up or leave of event
		if(!empty($_POST["sign_up"])) {
			$new_participance_query =  "INSERT INTO sgn_database.tournament_participants 
										VALUES (" . $_SESSION["page_id"] . ", " . $_SESSION["current_user_id"] . ");";
		
			$result = $conn->query($new_participance_query);
		
			
			if($result === false) {
				echo("Failed to insert new attendence");
				exit();
			}
		}
		else if(!empty($_POST["leave"])) {
			$remove_participance_query =  "DELETE FROM sgn_database.tournament_participants 
											WHERE participant_id = " . $_SESSION["current_user_id"] . " AND tournament_id = " . $_SESSION["page_id"] . ";";
		
			$result = $conn->query($remove_participance_query);
			
			if($result === false) {
				echo("Failed to remove attendence");
				exit();
			}
		}
		
		
		$search_tournament_event =  "SELECT tournament_name, tournament_date, tournament_time
									FROM sgn_database.tournaments
									WHERE tournament_id = " . $_GET["page_id"] .";";
		
		$result = ($conn->query($search_tournament_event));
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			echo "<u>" . $tuple["tournament_name"] . "</u>'s tournament page <br>Date:	" . $tuple["tournament_date"] . "<br>Time:		" . $tuple["tournament_time"] . " <br> <br> <br>";
		}
		else {
			echo "<br> <br> Resulting for current event's tuple returned a non-one tuple result.";
			echo $search_tournament_event;
			exit();
		}
		$search_participant_count_event =  "SELECT COUNT(tournament_id) as partCount
											FROM sgn_database.tournament_participants
											WHERE tournament_id = " . $_GET["page_id"] .";";
											
		$result = ($conn->query($search_participant_count_event));
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			echo "Number of participants: " . $tuple["partCount"] . " <br> <br> <br>";
		}
		else {
			echo "<br> <br> Result for participant count returned a non-one tuple result.";
			echo $search_tournament_event;
			exit();
		}
		
		$search_participants_name =  "SELECT username 
											FROM sgn_database.tournament_participants INNER JOIN sgn_database.users
											ON tournament_participants.participant_id = users.user_id 
											WHERE tournament_id = " . $_GET["page_id"] .";";
											
		$result = ($conn->query($search_participants_name));
		
		if($result->num_rows > 0) {
			echo "Current Participants: <br><br>";
			while($tuple = $result->fetch_assoc()) { 
				echo $tuple["username"] . " <br>";
			}
		}
		else {
			echo "<br> <br> Result for participant count returned a non-one tuple result.";
			echo $search_tournament_event;
			exit();
		}
		
		echo "<br><br><br><br><br><br>";
		
		// Sign up or leave event button
		$search_participance_query =  "SELECT participant_id
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . " AND participant_id = ". $_SESSION["current_user_id"] .";";
		
		//echo $search_participance_query;
		$result = $conn->query($search_participance_query);
		
		if($result->num_rows == 0) {
			echo "
				<form action='tournament_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
					<input type='submit' name='sign_up' value='Sign Up'>
				</form> ";
			}
		else if($result->num_rows == 1) {
			echo "
			<form action='tournament_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
				<input type='submit' name='leave' value='Leave'>
			</form> ";
			}
		else {
				echo "\nReceived a result that has more than one tuple for search attendance query\n";
				exit();
		}
		
	
		// if($result->num_rows == 1) {
			// $tuple = $result->fetch_assoc();
			// echo "<u>" . $tuple["event_name"] . "</u>'s event page <br>Date:	" . $tuple["event_start_date"] . "<br>Time:		" . $tuple["event_start_time"] . "<br> <br> <br> <br> <br>";
		// }
		// else {
			// echo "<br> <br> Resulting for current event's tuple returned a non-one tuple result.";
			// exit();
		// }
		
	?>
	
	Tournament page under construction

</html>