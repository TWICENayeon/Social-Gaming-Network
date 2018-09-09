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
	$_SESSION["page_type"] = 1;
?>



<html>
	
	<?php 
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		// Fetch the posts on the current wall
		$search_group_name =  "SELECT group_name
									FROM sgn_database.groups
									WHERE group_id = " . $_GET["page_id"] .";";
		
		$group_name_tuple = ($conn->query($search_group_name)->fetch_assoc());
		
		
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
	<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	<?php 
		echo "<u> " . $group_name_tuple["group_name"] . "</u>'s group page <br> <br> <br> <br>";
		$search_member_role_query = "SELECT membership_role
									 FROM sgn_database.memberships
									 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_GET["page_id"] . ";";
		
		
		$result = $conn->query($search_member_role_query);
		
		// echo $_SESSION["current_user_id"] . "<br> <br> <br>";
		// echo $_GET["page_id"] . "<br> <br> <br>";
		
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			//echo $tuple["membership_role"] . "<br> <br> <br>";
			echo "Welcome ";
			if($tuple["membership_role"] == 2) {
				echo "Founder ";
			}
			else if($tuple["membership_role"] == 1) {
				echo "Admin ";
			}
			else if($tuple["membership_role"] == 0) {
				echo "Member ";
			}
			echo "<u>" . $_SESSION["current_username"] . "</u> <br> <br>";
		}
	?>
	
	
	<a href="http://localhost/sgn/group_members.php"> See members </a> <br>
	
	<?php 
	// Process sign up or leave of group
		if(!empty($_POST["sign_up"])) {
			$new_attendence_query =  "INSERT INTO sgn_database.memberships 
									  VALUES (" . $_SESSION["current_user_id"] . ", " . $_SESSION["page_id"] . ", 0, CURRENT_DATE(), CURRENT_TIME());";
		
			$result = $conn->query($new_attendence_query);
			
			if($result === false) {
				echo("Failed to insert new membership");
				exit();
			}
			
			
			// Resolve notification
			if(!empty($_GET["notification_id"])) {
				$resolve_notification_query = "UPDATE sgn_database.notifications
												SET resolved_status = 1
												WHERE notification_id = " . $_GET["notification_id"] . ";";
			}
			
			if($conn->query($resolve_notification_query) === false) {
				echo "Failed to resolve notification";
			}
		}
		else if(!empty($_POST["leave"])) {
			$new_attendence_query =  "DELETE FROM sgn_database.memberships 
									  WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
		
			$result = $conn->query($new_attendence_query);
			
			if($result === false) {
				echo("Failed to remove membership");
				exit();
			}
		}
	
	?>
	
	<?php
	// Sign up or leave group button
	$search_membership_query =  "SELECT member_id
									FROM sgn_database.memberships
									WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
		
		
	$result = $conn->query($search_membership_query);
	
	
	if($result->num_rows == 0) {
		echo "
		<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='sign_up' value='Sign Up'>
		</form> ";
	}
	else if($result->num_rows == 1) {
		echo "
		<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='leave' value='Leave'>
		</form> ";
	}
	?>
	
	
	
	<!-- Form to add a new post to the wall -->
	<form action="new_post.php" method="post">
		<input type="text" name = "post_text" placeholder="Write a post. . ." >
		<input type="submit" value="Submit">
	</form>
	<br> <br> <br> <br>
	
	<?php	
		// Form to create a new event for certified members
		if($tuple["membership_role"] = 2 || $tuple["membership_role"] = 1) {
			echo "Create a new event <br> <br>
				<form action='new_event.php' method='post'>
					New Event's Name: <input type='text' name = 'new_event_name' > <br>
					New Event's Description: <input type='text' name = 'new_event_description' > <br>
					Privacy: <input type='radio' name = 'new_event_privacy'> <br>
					<input type='submit' value='Create'>
				</form>";
		}
	?>
	
	
	<?php
			
		echo "Invite another user <br> <br>
			<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
				Invited's username: <input type='text' name = 'invited_username' > <br>
				<input type='submit' value='Invite'>
			</form>";
			
		// Sending notification to user
		if(!empty($_POST['invited_username'])) {
			$search_valid_user = "SELECT user_id 
									  FROM sgn_database.users 
									  WHERE username = '" .  $_POST['invited_username'] . "';";
			
										  
			$tuple = ($conn->query($search_valid_user))->fetch_assoc();
			if(!empty(["user_id"])) {
				//echo "invited user found";
				$search_invited_membership = "SELECT member_id 
											  FROM sgn_database.memberships 
											  WHERE member_id = " .  $tuple['user_id'] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
											  
										  
				if(empty(($conn->query($search_invited_membership))->fetch_assoc()["member_id"])) {
																	
					$insert_group_invitation_notification = "INSERT into sgn_database.notifications (recipient_id, message, resolved_status, date_created, time_created)
															VALUES(" . $tuple['user_id'] . ", '' , 0, CURRENT_DATE(), CURRENT_TIME());";
					
					// echo "<br> <br> <br>";
					// echo $insert_group_invitation_notification;
					// echo "<br> <br> <br>";
					// $conn->query($insert_group_invitation_notification);
					// $conn->query($insert_group_invitation_notification);
					if ( ($conn->query($insert_group_invitation_notification)) === TRUE) {
						
						$new_notification_id = $conn->insert_id;
						$notification_message = $conn->real_escape_string("JOIN " . $group_name_tuple["group_name"] . "! <form action='group_page.php?page_id=" . $_SESSION['page_id'] . "&notification_id=" . $new_notification_id .  "' method='post'>
																		<input type='submit' name='sign_up' value='Sign Up'>
																	</form> <form action='my_notifications.php?notification_id=" . $new_notification_id . "' method='post'>
																		<input type='submit' name='decline' value='Decline'>
																	</form>");
						$update_group_invitation_notification = "UPDATE sgn_database.notifications SET message = '$notification_message' WHERE notification_id = " . $new_notification_id . ";";
						
						if ( ($conn->query($update_group_invitation_notification)) === TRUE) {
							echo "Notification has been properly sent.";
						}
					} 
					else {
						echo "Error: " . $insert_group_invitation_notification . "<br>" . $conn->error;
					}
				}
				else {
					echo "Specified user is already in the group";
				}
			}
			else {
				echo "Specified username is invalid";
			}
			
		}
	
	?>
	<br>
	<br>
	<br>
	Upcoming Events
	<?php
		// Print all of this group's events onto page
		$search_group_events =  "SELECT event_id, event_name, event_start_date, event_start_time
									FROM sgn_database.group_events  JOIN sgn_database.events JOIN sgn_database.memberships
									ON `group_events`.`hosted_event_id` = `events`.`event_id` AND `group_events`.`hosting_group_id` = `memberships`.`of_group_id`
									WHERE hosting_group_id = " . $_SESSION["page_id"] . " AND member_id = " . $_SESSION["current_user_id"] . " AND event_privacy = 1 
									UNION
									SELECT event_id, event_name, event_start_date, event_start_time
									FROM sgn_database.group_events  JOIN sgn_database.events
									ON `group_events`.`hosted_event_id` = `events`.`event_id`
									WHERE hosting_group_id = " . $_SESSION["page_id"] . " AND event_privacy = 0
									ORDER BY event_start_date, event_start_time ASC";
		
		$result = $conn->query($search_group_events);
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br>" . $tuple["event_start_date"] . "<br>" . $tuple["event_start_time"] . "<br>";
			}
		}
	
	?>
	
	<br> <br> <br> <br> <br> <br>
	Posts
	<br> <br>
	
	<?php
		// Print all of the posts onto the page
		// Fetch the posts on the current wall
		$search_user_wall_posts =  "SELECT username, post_text, post_date, post_time, post_votes
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_GET["page_id"] . " AND wall_type = 1 " . 
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