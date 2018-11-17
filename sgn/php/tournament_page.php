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
	
	if(isset($_GET["page_id"])) {
		$_SESSION["page_id"] = $_GET["page_id"];
	}
	
	if(isset($_POST["page_id"])) {
		$_SESSION["page_id"] = $_POST["page_id"];
	}
	$_SESSION["page_type"] = 4; // tournament type of page;
	$_SESSION["page_id"] = '5';
?>
<html>



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
// Get number of unresolved notifications
	$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
												FROM notifications
												WHERE recipient_id = " . $_SESSION["current_user_id"] . " and resolved_status = false;";
	
	// echo $fetch_num_unresolved_notifications_query;
												
	$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];



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
	<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <?php if(intval($num_unresolved_string) > 0) {echo "[" . $num_unresolved_string . "]";}?> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<a href="http://localhost/sgn/settings.php"> User settings </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->




	
	<?php 
	

		//echo $_SESSION["page_id"] .  "<br><br><br><br><br><br>";
		
		
		// Process sign up or leave of event
		if(!empty($_POST["sign_up"])) {
			$search_participance_query =  "SELECT participant_id
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . " AND participant_id = ". $_SESSION["current_user_id"] .";";
		
			//echo $search_participance_query;
			$result = $conn->query($search_participance_query);
			if($result->num_rows == 0) {
				$num_participants_query = "SELECT count(participant_id) AS partCount
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . ";";
										
				$result = $conn->query($num_participants_query);
				
				$num_parti = intval(($result->fetch_assoc())["partCount"]);
				
				$new_participance_query =  "INSERT INTO sgn_database.tournament_participants 
											VALUES (" . $_SESSION["page_id"] . ", " . $_SESSION["current_user_id"] . "," . (string) ($num_parti + 1) . ");";
			
				$result = $conn->query($new_participance_query);
			
				
				if($result === false) {
					echo("Failed to insert new attendence");
					exit();
				}
			}
			else {
				echo "You have already signed up.";
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
									WHERE tournament_id = " . $_SESSION["page_id"] .";";
		
		$result = ($conn->query($search_tournament_event));
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			echo "<u>" . $tuple["tournament_name"] . "</u>'s tournament page <br>Date:	" . $tuple["tournament_date"] . "<br>Time:		" . $tuple["tournament_time"] . " <br> <br> <br>";
		}
		else {
			// echo "Hello";
			echo "<br> <br> Resulting for current event's tuple returned a non-one tuple result. <br><br>";
			echo $search_tournament_event;
			exit();
		}
		$search_participant_count_event =  "SELECT COUNT(tournament_id) as partCount
											FROM sgn_database.tournament_participants
											WHERE tournament_id = " . $_SESSION["page_id"] .";";
											
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
		
		// List out all the current participants
		$search_participants_name =  "SELECT username, ordering
										FROM sgn_database.tournament_participants INNER JOIN sgn_database.users
										ON tournament_participants.participant_id = users.user_id 
										WHERE tournament_id = " . $_SESSION["page_id"] .
										" ORDER BY ordering ASC;";
											
		$result = ($conn->query($search_participants_name));
		
		echo "Current Participants: <br><br>";
		if($result->num_rows >= 0) {
			while($tuple = $result->fetch_assoc()) { 
				echo $tuple["ordering"] . ") " .$tuple["username"] . " <br>";
			}
		}
		else {
			echo "<br> <br> Result for participant count returned a non-one tuple result. Hello Hello Hello";
			echo $search_tournament_event;
			exit();
		}
		
		echo "<br><br><br><br><br><br>";
		
		
		$tournament_start_query = "SELECT started
									FROM sgn_database.tournaments
									WHERE started = 1 AND tournament_id = " . $_SESSION["page_id"] .";";
									
		$start_result = ($conn->query($tournament_start_query));
		
		$start_value = intval(($start_result->fetch_assoc())["started"]);
		
		if($start_value == 0) {
		
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
		
		}
		
		
		
		
	?>
	<br><br><br>
	
	<?php
	// Process new stream submission 
	if(isset($_POST["new_stream_name"])) {
		$update_tournament_stream = "UPDATE tournaments
										SET twitch_stream = '" . $_POST["new_stream_name"] . "'
										WHERE tournament_id = " . $_SESSION["page_id"] . ";";
		
		// echo $update_tournament_stream . "<br><br><br>";
										
		$conn->query($update_tournament_stream);
		
	}
	
	
	
	$has_stream_query = "SELECT twitch_stream
							FROM tournaments
							WHERE tournament_id = " . $_SESSION["page_id"] . ";";
							
	$tournament_stream_name = (($conn->query($has_stream_query))->fetch_assoc())["twitch_stream"];
	
	// Form to submit new stream name
	echo "
		<form action='tournament_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			Enter Stream Name: <input type='text' name='new_stream_name' value=''>
			<input type='submit' name='submit'>
		</form> ";
		
	// echo $has_stream_query;
	// echo $tournament_stream_name;
	
	if(!empty($tournament_stream_name)) {
		//twitch stream 
		echo " 
				<div id='twitch-embed-one'></div>

				<script src='https://embed.twitch.tv/embed/v1.js'></script>

				<script type='text/javascript'>
				  new Twitch.Embed('twitch-embed-one', {
					width: 854,
					height: 480,
					layout: 'video',
					channel: \"" . $tournament_stream_name . "\"
				  });
				</script>";
		
	}
	 
	?>
	
	<br><br><br>
	
	<?php 
		$tournament_start_query = "SELECT started
									FROM sgn_database.tournaments
									WHERE started = 1 AND tournament_id = " . $_SESSION["page_id"] .";";
									
		$start_result = ($conn->query($tournament_start_query));
		
		 
		
		if($start_result->num_rows == 0) {
			$user_group_status_query = "SELECT membership_role
											FROM sgn_database.memberships
											WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = 
											(	SELECT hosting_group_id
											FROM sgn_database.group_events
											WHERE hosted_event_id =
											(SELECT host_event_id
											FROM sgn_database.tournaments
											WHERE tournament_id = " . $_SESSION["page_id"] . "))";
											
				// echo "user group status query: " . $user_group_status_query . "<br><br><br><br>";
											
			$status_value = intval((($conn->query($user_group_status_query))->fetch_assoc())["membership_role"]);
			
			
			
			
			
			if($status_value == 1 ) {
				
				$num_participants_query = "SELECT count(participant_id) AS partCount
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . ";";
										
				$result = $conn->query($num_participants_query);
				
				$num_parti = intval(($result->fetch_assoc())["partCount"]);
				
				if($num_parti > 0) {
				
					echo "<form action='update_tournament_ordering.php' method='post'>
							Name:
						  <select name='user_id'>";
					$counter = 0;
					$search_participants_name =  "SELECT username, user_id, ordering
												FROM sgn_database.tournament_participants INNER JOIN sgn_database.users
												ON tournament_participants.participant_id = users.user_id 
												WHERE tournament_id = " . $_SESSION["page_id"] ."
												ORDER BY ordering ASC;";
					
					$result = ($conn->query($search_participants_name));
					while($tuple = $result->fetch_assoc()) { 
						echo "<option value='" . $tuple["user_id"] . "'>" . $tuple["username"] . "</option>";
						$counter += 1;
					}
							
							
					echo "
					  </select>
					  Order:
					  <select name='order'>";
					$i = 1;
					$result = ($conn->query($search_participants_name));
					while($i <= $counter) { 
						echo "<option value='" . $i . "'>" . $i . "</option>";
						$i += 1;
					}
								
					echo "
					  </select>
					  <br><br>
					  <input type='submit'>
					</form>";
				}
				echo "
					<form action='tournament_start.php' method='post'>
						<br>
					  <input type='submit' value='Start Tournament'>
					</form>";
			}
			else {
				echo "The tournament has not started yet.";
			}
		}
		else {
			
			echo "<br><br><br>Tournament started!! <br><br><br>";
			// $round_counter = 1;
			$num_participants_query = "SELECT count(participant_id) AS partCount
										FROM sgn_database.tournament_participants
										WHERE tournament_id = " . $_SESSION["page_id"] . ";";
										
			$result = $conn->query($num_participants_query);
			
			$num_parti = intval(($result->fetch_assoc())["partCount"]);
			for($round_counter = 1; $round_counter <= ceil(log($num_parti, 2)); ++$round_counter) {
				
				
				$fetch_rounds_query = "SELECT relative_match_id, participant_1_id, participant_2_id
										FROM sgn_database.tournament_matches
										WHERE tournament_id = " . $_SESSION["page_id"] . " AND round = " . $round_counter . ";";
										
				// echo "fetch_rounds_query" . $fetch_rounds_query . "<br><br><br><br>";
				// echo "<br><br><br> " . $fetch_rounds_query . "<br><br><br>";		
				$result = ($conn->query($fetch_rounds_query));		
				$num_tuples = $result->num_rows;
				// echo "<br><br><br> num tuples" . $num_tuples . "<br><br><br>";
				if ($num_tuples == 0) {
					// ++$round_counter;
					continue;
				}
				echo "---------------------------------------------<br>";
				echo "ROUND " . $round_counter . "!<br><br>";
				for($i = 0; $i < $num_tuples; ++$i) {
					$tuple = $result->fetch_assoc();
					// echo "round counter: " . $round_counter . "<br><br>";
					// echo "relative_match_id: " . $tuple["relative_match_id"] . "<br><br>";
					// echo "participant 1: " . $tuple["participant_1_id"] . "<br><br>";
					// echo "participant 2: " . $tuple["participant_2_id"] . "<br><br>";
					$parti_1_username = "";
					if (isset($tuple["participant_1_id"])) {
						$parti_1_username_query = "SELECT username
													FROM sgn_database.users
													WHERE user_id = " . $tuple["participant_1_id"] . ";";
						$parti_1_username = (($conn->query($parti_1_username_query))->fetch_assoc())["username"];
					}
					else {
					}
					$parti_2_username = "";
					if (isset($tuple["participant_2_id"])) {
						$parti_2_username_query = "SELECT username
												FROM sgn_database.users
												WHERE user_id = " . $tuple["participant_2_id"] . ";";
												
						$parti_2_username = (($conn->query($parti_2_username_query))->fetch_assoc())["username"];
					}
					
					echo "Match: <br>";
					if(!empty($parti_1_username)) {
						echo $parti_1_username;
					}
					else {
						echo "__________";
					}
					echo "<br>";
					if(!empty($parti_2_username)) {
						echo $parti_2_username;
					}
					else {
						echo "__________";
					}
					echo "<br><br>";
					
					$check_finished_query = "SELECT finished, participant_1_id, participant_2_id
												FROM sgn_database.tournament_matches
												WHERE tournament_id = " . $_SESSION["page_id"] . " AND relative_match_id = " . $tuple["relative_match_id"] . " AND round = " . $round_counter . ";";
					
					
					// echo $check_finished_query;
					$finished_result = ($conn->query($check_finished_query));
					$finished_tuple = $finished_result->fetch_assoc();
					$finished_status = $finished_tuple["finished"];
					
					if ($finished_status) {
						// echo 
						echo "Match Complete!<br><br><br>";
					}
					else if(!empty($finished_tuple["participant_1_id"] && !empty($finished_tuple["participant_2_id"]))){
						echo"<form action='update_tournament_score.php' method='post'>
							Winner:
						  <select name='winner_id'>
							<option value=" . $finished_tuple["participant_1_id"] . "> " . $parti_1_username . "</option>
							<option value=" . $finished_tuple["participant_2_id"] . "> " . $parti_2_username . "</option>
						  </select>
						  <br>
						  <input type='hidden' name='old_round_num' value=" . $round_counter . ">
						  <input type='hidden' name='old_match_num' value=" . $tuple["relative_match_id"] . ">
						  <input type='submit'>
						</form> <br><br><br>";
					}
				}
			}
			
			$get_winner_query = "SELECT participant_1_id
									FROM sgn_database.tournament_matches
									WHERE tournament_id = " . $_SESSION["page_id"] . " AND relative_match_id = 0 AND round = 0;";
									
			
			
			$result = $conn->query($get_winner_query);
			
			if ($result->num_rows == 1) {
				$winner_id = intval(($result)->fetch_assoc()["participant_1_id"]);
				
				// echo $winner_id;
				
				// echo "<br><br><br>";
				
				$winner_username_query = "SELECT username
											FROM sgn_database.users
											WHERE user_id = " . $winner_id . ";";
				// echo $get_winner_query;
				// echo "<br><br><br>";
				// echo $winner_username_query;
											
				$winner_username = (($conn->query($winner_username_query))->fetch_assoc())["username"];
				
				
				echo "The winner of this tournament is >>>> " . $winner_username . " <<<< !!!";
			}
			
			
		}
	?>

</html>