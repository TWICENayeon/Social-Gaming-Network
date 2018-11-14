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
	<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	
	<?php 
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		// Fetch the posts on the current wall
		$search_current_event =  "SELECT event_name, event_start_date, event_start_time
									FROM sgn_database.events
									WHERE event_id = " . $_GET["page_id"] .";";
		
		$result = ($conn->query($search_current_event));
		
		
		
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			echo "<u>" . $tuple["event_name"] . "</u>'s event page <br>Date:	" . $tuple["event_start_date"] . "<br>Time:		" . $tuple["event_start_time"] . "<br> <br> <br> <br> <br>";
		}
		else {
			echo "<br> <br> Resulting for current event's tuple returned a non-one tuple result.";
			exit();
		}
		
	?>
	
	
	<?php 
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
	
	?>
	
	<?php
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
	$search_existing_tournament_query = "SELECT tournament_id
										 FROM sgn_database.tournaments
										 WHERE host_event_id =  " . $_SESSION["page_id"] . ";";
	
	$result = $conn->query($search_existing_tournament_query);
	echo "<br><br><br><br><br>";
	if($result->num_rows == 1) {
		echo "<a href='http://localhost/sgn/tournament_page.php?page_id=" . $result->fetch_assoc()["tournament_id"] . "'> Tournament Link </a> <br>";
	}
	else if($result->num_rows == 0) {
		// Get the role of the current member
		$search_member_role_query = "SELECT membership_role
									 FROM sgn_database.memberships
									 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = 
									 (	SELECT hosting_group_id
										FROM sgn_database.group_events
										WHERE hosted_event_id = " . $_SESSION["page_id"] . ");";
		echo $search_member_role_query;
		
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
	
	?>
	<br><br><br><br><br><br>
	<!-- Form to add a new post to the wall -->
	<form action="new_post.php" method="post">
		<input type="text" name = "post_text" placeholder="Write a post. . ." >
		<input type="submit" value="Submit">
	</form>

	<?php
		// Print all of the posts onto the page
		
		
		// Fetch the posts on the current wall
		$search_user_wall_posts =  "SELECT username, post_text, post_date, post_time, post_votes
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_GET["page_id"] . " AND wall_type = 2 " .
								   " ORDER BY post_id DESC;";
		
		$result = $conn->query($search_user_wall_posts);
		
		
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>". $tuple["post_votes"] . "<br> <br>";
			}
		}

	?>

</html>