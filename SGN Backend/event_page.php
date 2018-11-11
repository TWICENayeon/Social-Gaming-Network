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
	$_SESSION["page_type"] = 2;
?>

<?php
// Connect to database

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



<html>
	
	

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
	<a href="http://localhost/sgn/settings_event.php"> Event Settings </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	
	<?php 
	// Connect to the database
		
		
		// Fetch the posts on the current wall
		$search_current_event =  "SELECT event_name, event_description, event_start_date, event_start_time
									FROM sgn_database.events
									WHERE event_id = " . $_SESSION["page_id"] .";";
		
		$result = ($conn->query($search_current_event));
		
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			echo "<u>" . $tuple["event_name"] . "</u>'s event page <br> <br>
												Description: " . $tuple["event_description"] . 
												"<br><br>Date:	" . $tuple["event_start_date"] . 
												"<br>Time:		" . $tuple["event_start_time"] . 
												"<br> <br> <br> <br> <br>";
		}
		else {
			echo "<br> <br> Resulting for current event's tuple returned a non-one tuple result.";
			exit();
		}
		
	$check_event_past_query = "SELECT CASE WHEN (event_start_date < CURRENT_DATE OR (event_start_date = CURRENT_DATE AND event_start_time < CURRENT_TIME())) THEN 'True' ELSE 'FALSE' END AS past
								FROM sgn_database.events
								WHERE event_id =  " . $_SESSION["page_id"] . ";";
	// echo "<br><br>" . $check_event_past_query;
	$event_past_value = (($conn->query($check_event_past_query))->fetch_assoc())["past"];
	
	if ($event_past_value === "FALSE") {
		// echo "<br>It's false";
	}
	
	// echo "<br><br>event past value:" . $event_past_value . "<br><br>";
	
	
	if ($event_past_value === "FALSE") {
		// Process sign up or leave of event
			if(!empty($_POST["sign_up"])) {
				$new_attendence_query =  "INSERT INTO sgn_database.attendees 
										  VALUES (" . $_SESSION["current_user_id"] . ", " . $_SESSION["page_id"] . ", CURRENT_DATE(), CURRENT_TIME(), " . "' Attendee '" . ");";
			
				$result = $conn->query($new_attendence_query);
			
				
				if($result === false) {
					echo("Failed to insert new attendence");
					exit();
				}
			}
			else if(!empty($_POST["leave"])) {
				$new_attendence_query =  "DELETE FROM sgn_database.attendees 
										  WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND attended_event_id = " . $_SESSION["page_id"] . ";";
			
				$result = $conn->query($new_attendence_query);
				
				if($result === false) {
					echo("Failed to remove attendence");
					exit();
				}
			}
		
		// Sign up or leave event button
		$search_attendance_query =  "SELECT attendee_id
										FROM sgn_database.attendees
										WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND attended_event_id = " . $_SESSION["page_id"] . ";";
		
		$result = $conn->query($search_attendance_query);
		
		if($result->num_rows == 0) {
		echo "
		<form action='event_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='sign_up' value='Sign Up'>
		</form> ";
		}
		else if($result->num_rows == 1) {
		echo "
		<form action='event_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='leave' value='Leave'>
		</form> ";
		}
		else {
				echo "\nReceived a result that has more than one tuple for search attendance query\n";
				exit();
		}
	}
	else {
		// echo $check_event_past_query . "<br>";
		// echo $event_past_value . "<br>";
		echo "The event has started!";
	}
	
	
	// Tournament Section
	$search_existing_tournament_query = "SELECT tournament_id
										 FROM sgn_database.tournaments
										 WHERE host_event_id =  " . $_SESSION["page_id"] . ";";
	
	$result = $conn->query($search_existing_tournament_query);
	echo "<br><br><br><br><br>";
	if($result->num_rows == 1) {
		echo "<a href='http://localhost/sgn/tournament_page.php?page_id=" . $result->fetch_assoc()["tournament_id"] . "'> Tournament Link </a> <br>";
	}
	else if($result->num_rows == 0) {
		if($event_past_value === "TRUE") {
			// Get the role of the current member
			$search_member_role_query = "SELECT membership_role
										 FROM sgn_database.memberships
										 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = 
										 (	SELECT hosting_group_id
											FROM sgn_database.group_events
											WHERE hosted_event_id = " . $_SESSION["page_id"] . ");";
			// $search_member_role_query;
			
			$result = $conn->query($search_member_role_query);
			

			
			
			
			//echo "membership role: " . ($result->fetch_assoc())["membership_role"];
			
			// Option to create a new tournament if the user has the privilege to
			if($result->num_rows == 1) {
				$tuple = $result->fetch_assoc();
				//echo $tuple["membership_role"] . "<br> <br> <br>";
				if($tuple["membership_role"] > 0) {
					echo "<br> <br> <br> <br> <br> <br>
					Form to add a tournament to the event
					<form action='new_tournament.php?event_id=" . $_SESSION["page_id"] .  "' method='post'>
					Name: <input type='text' name = 'tournament_name'> <br>
					Date: <input type='date' name = 'tournament_date'> <br>
					Time: <input type='time' name = 'tournament_time'> <br>
					<input type='submit' value='Submit'>
					</form>  <br> <br> <br> <br> <br> <br>";
				}
			}
			else {
				echo "Got a non-one tuple return";
			}
		}
	}
	
	?>
	<br><br><br><br><br><br>
	<!-- Form to add a new post to the wall -->
	<form action="new_post.php" method="post">
		<input type="text" name = "post_text" placeholder="Write a post. . ." >
		<input type="submit" value="Post">
	</form>

	<?php	
		// Print all of the posts onto the page
		
		
		// Fetch the parent posts on the current wall
		$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_GET["page_id"] . " AND wall_type = 2 AND parent_post_id = 0" .
								   " ORDER BY post_id DESC;";
								   
		// echo $search_event_wall_posts . "<br><br><br>";
		
		$result = $conn->query($search_event_wall_posts);
		
		// For each parent post
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// Get vote count
				
				if(!isset($tuple["post_id"])) {
					echo "Breaking";
					break;
				}
				
				$fetch_post_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $tuple["post_id"] . ";";
											
				// echo $fetch_post_votes_query . "<br><br><br>";
											
				$vote_total = (($conn->query($fetch_post_votes_query))->fetch_assoc())["total"];
				
				
				if (!isset($vote_total)) {
					$vote_total = 0;
				}
				// Print Post
				echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				
				// Check upvote
				
				$fetch_upvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . " AND value = 1;";
										
				$result = $conn->query($fetch_upvote_query);
				
				$has_upvoted = false;
				
				// echo $fetch_upvote_query . "<br><br>";
				
				if($result->num_rows == 1) {
					$has_upvoted = true;
				}
				$fetch_downvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . " AND value = -1;";
										
				$result = $conn->query($fetch_downvote_query);
				
				$has_downvoted = false;
				// echo $fetch_downvote_query . "<br><br>";
				
				if($result->num_rows == 1) {
					$has_downvoted = true;
				}
				
				
				// Reply, Upvote, and Downvote Form
				echo "<form action='new_post.php' method='post'>
						<input type='text' name = 'post_text' placeholder='Reply Here. . .' >
						<input type='hidden' name = 'parent_post_id' value='" . $tuple["post_id"] . "'>
						<input type='submit' value='Reply'> 
					</form><br>";
				
				echo "<form action='process_vote.php' method='post'>
					<input type='hidden' name = 'post_id' value='" . $tuple["post_id"] . "'>";
					if($has_upvoted) {
						echo "<input type='submit' name='remove_upvote' value='Remove Upvote'>";
					}
					else {
						echo "<input type='submit' name='upvote' value='Upvote'>";
					}
					if($has_downvoted) {
						echo "<input type='submit' name='remove_downvote' value='Remove Downvote'>";
					}
					else {
						echo "<input type='submit' name='downvote' value='Downvote'>";
					}
				echo "</form> <br><br>";
					  
				// Fetch the children posts for each parent post	  
				$fetch_children_posts_query = "SELECT post_id, username, post_text, post_date, post_time, post_votes
												FROM sgn_database.posts JOIN sgn_database.users
												ON posts.poster_id = users.user_id
												WHERE parent_post_id = " . $tuple["post_id"] . ";";
				
				$children_result = $conn->query($fetch_children_posts_query);
				
				// Print Parent Post's children posts
				
				while($child_tuple = $children_result->fetch_assoc()) {
					$fetch_post_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $child_tuple["post_id"] . ";";
											
					$vote_total = (($conn->query($fetch_post_votes_query))->fetch_assoc())["total"];
					
					if (!isset($vote_total)) {
						$vote_total = 0;
					}
					
					
					// Print child
					echo "<br> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["username"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["post_date"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["post_time"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $child_tuple["post_text"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  . $vote_total . " <br> <br>";
					$fetch_upvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $child_tuple["post_id"] . " AND value = 1;";
										
					$result = $conn->query($fetch_upvote_query);
					
					// echo $fetch_upvote_query . "<br><br>";
					$has_upvoted = false;
					
					if($result->num_rows == 1) {
						$has_upvoted = true;
					}
					$fetch_downvote_query = "SELECT value 
											FROM sgn_database.post_votes
											WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $child_tuple["post_id"] . " AND value = -1;";
											
					$result = $conn->query($fetch_downvote_query);
					
					$has_downvoted = false;
					
					// echo $fetch_downvote_query . "<br><br>";
					if($result->num_rows == 1) {
						$has_downvoted = true;
					}
					
					// Upvote and Downvote Form
							
					echo "<form action='process_vote.php' method='post'>
							<input type='hidden' name = 'post_id' value='" . $child_tuple["post_id"] . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						if($has_upvoted) {
							echo "<input type='submit' name='remove_upvote' value='Remove Upvote'>";
						}
						else {
							echo "<input type='submit' name='upvote' value='Upvote'>";
						}
						if($has_downvoted) {
							echo "<input type='submit' name='remove_downvote' value='Remove Downvote'>";
						}
						else {
							echo "<input type='submit' name='downvote' value='Downvote'>";
						}
					echo "</form>  <br>";
				}
			}
		}

		$conn->close();
	?>

</html>