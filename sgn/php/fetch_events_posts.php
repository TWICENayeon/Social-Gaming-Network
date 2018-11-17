<!DOCTYPE html>

<?php
// Allows access to the session array
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
	
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
?>




<!-- Print out all of the current user's upcoming events --> 	

 <?php
		
		$search_future_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
								ORDER BY date_time ASC;";
								
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		$future_counter = 0;
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
	
				echo "<div class='modal fade' id='futureEventModal_" . (string)$future_counter . "' tabindex='-1' role='dialog' aria-hidden='true'>
					  <div class='modal-dialog' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>" . $tuple["event_name"] . "</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					        <div class='modalEventInfoCont'>
					        	<!-- should disappear if the event hasnt started -->
					        	<div class='modalEventStartedWarning'>Note: Event has already started!</div>
					        	<h1 id='modalEventDescTitle'>Description</h1>					        	
					        	<div class='modalEventDesc'>" . $tuple["event_description"] . "</div>
					        	<h1 id='modalEventDateTime'>Date/Time</h1>
					        	<div class='eventDate'>" . $tuple["event_start_date"] . "</div>
		  						<div class='eventTime'>" . $tuple["event_start_time"] . "</div>
					        </div>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-primary' id='eventSignUpButton'>Sign Up</button>
					        <button type='button' class='btn btn-primary' id='eventLeaveButton'>Leave</button>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
					      </div>
					    </div>
					  </div>
					</div>";
					
				++$future_counter;
			}
		}
 
 
 
		$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_SESSION["page_id"] . " AND wall_type = 2" .
								   " ORDER BY post_id DESC;";
								   
		$result = $conn->query($search_event_wall_posts);
		
		echo $search_event_wall_posts;
		
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
				//echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				echo "<div class='eventPostCont'>
					        		<div class='eventPostProfileImage'></div>
					        		<div class='eventPostGap'></div>
					        		<div class='eventPostName'>" . $tuple["username"] . "</div>
					        		<div class='eventPostDate'>" . $tuple["post_date"] . "</div>
					        		<div class='eventPostTime'>" . $tuple["post_time"] . "</div>
					        		<div class='eventPostComment'>". $tuple["post_text"] . "</div>
					        		<div class='eventPostVoteButtons'>					        			
					        			<div class='eventPostUpvote'>10M<i class='fa fa-hand-o-up' id='handUp' aria-hidden='true'></i></div>
					        			<div class='eventPostDownvote'>15K<i class='fa fa-hand-o-down' id='handDown' aria-hidden='true'></i></div>
					        			<button type='button' class='btn btn-primary' id='eventReplyButton'>Reply</button>
					        		</div>
					        	</div>";
					  
			}
		}
		else {
			echo "<div class='modalEventStartedWarning'>No posts to show</div>";
		}
		
		$conn->close();
?>


</html>