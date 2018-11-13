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
		echo "GET USED! <br><br><br><br>";
		$_SESSION["page_id"] = $_GET["page_id"];
	}
	
	if(isset($_POST["page_id"])) {
		echo "POST USED! <br><br><br><br>";
		$_SESSION["page_id"] = $_POST["page_id"];
	}
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
		
		$conn->select_db("sgn_database");
		
		// Fetch the posts on the current wall
		$search_group_name =  "SELECT group_name
									FROM sgn_database.groups
									WHERE group_id = " . $_SESSION["page_id"] .";";
		
		$group_name_tuple = ($conn->query($search_group_name)->fetch_assoc());
		
		
	?>
	
	
	
	
	<?php 
		$search_member_role_query = "SELECT membership_role
									 FROM sgn_database.memberships
									 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
		
		
		$result = $conn->query($search_member_role_query);
		
		// echo $_SESSION["current_user_id"] . "<br> <br> <br>";
		// echo $_SESSION["page_id"] . "<br> <br> <br>";
		
		
		if($result->num_rows == 1) {
			$tuple = $result->fetch_assoc();
			//echo $tuple["membership_role"] . "<br> <br> <br>";
		}
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

	<?php if($tuple["membership_role"] == 1) {
				echo "<a href='http://localhost/sgn/settings_group.php'> Group settings </a> <br> ";
			} ?>
	
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>

	
	
	
	
	<?php 
	
		echo "<u> " . $group_name_tuple["group_name"] . "</u>'s group page <br> <br> <br> <br>";
			// Print Greetings
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
	
	
		// Process leave from the leave button from the page
		if(!empty($_POST["leave"])) {
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
	
	// Sign up button
	if($result->num_rows == 0) {
		echo "
		<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='sign_up' value='Sign Up'>
		</form> ";
	}
	// Leave button
	else if($result->num_rows == 1) {
		echo "
		<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
			<input type='submit' name='leave' value='Leave'>
		</form> ";
	}
	?>
	
	
	
	<br> <br> <br> <br>
	
	<a href="http://localhost/sgn/group_members.php"> See members </a> <br>
	
	<br> <br> <br> <br>
	
	<?php	
		// Form to create a new event for certified members
		if($tuple["membership_role"] = 2 || $tuple["membership_role"] = 1) {
			echo "Create a new event <br> <br>
				<form action='new_event.php' method='post'>
					New Event's Name: <input type='text' name = 'new_event_name' > <br>
					New Event's Description: <input type='text' name = 'new_event_description' > <br>
					New Event's Date: <input type='date' name = 'new_event_date'> <br>
					New Event's Time: <input type='time' name = 'new_event_time' step = '2'> <br>
					Privacy: <input type='radio' name = 'new_event_privacy'> <br>
					<input type='submit' value='Create'>
				</form>";
		}
	?>
	
	
	<?php
			
		echo "<br><br><br>
			<form action='group_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
				Invite an user: <input type='text' name = 'invited_username' > <br>
				<input type='submit' value='Invite'>
			</form>";
			
		// Sending notification to user
		if(!empty($_POST['invited_username'])) {
			$search_valid_user = "SELECT user_id 
									  FROM sgn_database.users 
									  WHERE username = '" .  $_POST['invited_username'] . "';";
			
										  
			$tuple = ($conn->query($search_valid_user))->fetch_assoc();
			if(!empty($tuple["user_id"])) {
				//echo "invited user found";
				$search_invited_membership = "SELECT member_id 
											  FROM sgn_database.memberships 
											  WHERE member_id = " .  $tuple['user_id'] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
											  
										  
				if(empty(($conn->query($search_invited_membership))->fetch_assoc()["member_id"])) {
																	
					$insert_group_invitation_notification = "INSERT into sgn_database.notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
															VALUES(0, " . $_SESSION["page_id"] . "," . $tuple['user_id'] . ", 'COME JOIN GROUP-" . $group_name_tuple["group_name"] . "-' , 0, CURRENT_DATE(), CURRENT_TIME());";
					
					if ( ($conn->query($insert_group_invitation_notification))) {
							echo "Notification has been properly sent.";
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
									WHERE hosting_group_id = " . $_SESSION["page_id"] . " AND member_id = " . $_SESSION["current_user_id"] . " AND event_privacy = 1 AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
									UNION
									SELECT event_id, event_name, event_start_date, event_start_time
									FROM sgn_database.group_events  JOIN sgn_database.events
									ON `group_events`.`hosted_event_id` = `events`.`event_id`
									WHERE hosting_group_id = " . $_SESSION["page_id"] . " AND event_privacy = 0 AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
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
	
	<!-- Form to add a new post to the wall -->
	<form action="new_post.php" method="post">
		<input type="text" name = "post_text" placeholder="Write a post. . ." >
		<input type="submit" value="Submit">
	</form>
	
	<?php	
		// Print all of the posts onto the page
		
		
		// Fetch the parent posts on the current wall
		$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_SESSION["page_id"] . " AND wall_type = 1 AND parent_post_id = 0" .
								   " ORDER BY post_id DESC;";
		
		$result = $conn->query($search_event_wall_posts);
		
		// For each parent post
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// Get vote count
				
				if(!isset($tuple["post_id"])) {
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