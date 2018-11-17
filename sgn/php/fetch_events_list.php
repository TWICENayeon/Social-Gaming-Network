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
		
		echo "<div class='tabWelcome'>Upcoming Events</div>";
		
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
				
				echo "<div class='eventCont'>
							<div class='templateEvent'>
								<div class='eventHeaderCont'>		  					
									<div class='eventTitle'>" . $tuple["event_name"] . "</div>
									<div class='eventShortDesc'>" . $tuple["event_description"] . "</div>		  							  
								</div>
								<div class='eventDateTimePrivCont'>
									<div class='eventDate'>" . $tuple["event_start_date"] . "</div>
									<div class='eventTime'>" . $tuple["event_start_time"] . "</div>		  				
									<div class='eventPrivacy'>" . $tuple["event_privacy"] . "</div>
								</div>
								<div class='eventViewPostsButtons'>
									<button type='button' class='btn btn-primary' id='eventButton' data-toggle='modal' data-target='#futureEventModal_" . (string)$future_counter .  "'>View</button>
									<button type='button' class='btn btn-primary' id='eventPosts' data-toggle='modal' data-target='#futureEventPostsModal_" . (string)$future_counter ."'>Posts</button>			  
								</div>
							</div>
						</div>";	
				++$future_counter;
			}
		}
		?>
		
		<?php
		echo "<div class='futureEventTitle'>Past Events</div>";
		
		
		$search_past_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								ORDER BY date_time DESC
								LIMIT 5;";
		
		$result = $conn->query($search_past_user_events);
		
		// echo $search_past_user_events;
		
		
		$past_counter = 0;
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
				echo "<div class='futureEventCont'>
							<div class='templateEvent'>
								<div class='eventHeaderCont'>		  					
									<div class='eventTitle'>" . $tuple["event_name"] . "</div>
									<div class='eventShortDesc'>" . $tuple["event_description"] . "</div>		  							  
								</div>
								<div class='eventDateTimePrivCont'>
									<div class='eventDate'>" . $tuple["event_start_date"] . "</div>
									<div class='eventTime'>" . $tuple["event_start_time"] . "</div>		  				
									<div class='eventPrivacy'>" . $tuple["event_privacy"] . "</div>
								</div>
								<div class='eventViewPostsButtons'>
									<button type='button' class='btn btn-primary' id='eventButton' data-toggle='modal' data-target='#pastEventModal_" . (string)$past_counter .  "'>View</button>
									<button type='button' class='btn btn-primary' id='eventPosts' data-toggle='modal' data-target='#pastEventPostsModal_" . (string)$past_counter .  "'>Posts</button>			  
								</div>
							</div>
						</div>";	
				
				++$past_counter;		
			}
		}
		
		$conn->close();
?>

</html>