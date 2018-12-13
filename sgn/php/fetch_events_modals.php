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




<div class="eventsModals">

 <?php
		
		$search_future_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
								ORDER BY date_time ASC;";
								
		$result = $conn->query($search_future_user_events);
									
		
		// echo $search_future_user_events;
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
		
		
				$fetch_group_name_query = "SELECT group_name
									FROM groups
									WHERE group_id = (SELECT hosting_group_id FROM group_events WHERE hosted_event_id = " . $tuple["event_id"] . ");";
				
				
				$hosting_group_name = (($conn->query($fetch_group_name_query))->fetch_assoc())["group_name"];
				
	
				echo "<div class='modal fade' id='futureEventModal_"  . $tuple["event_id"] .   "' tabindex='-1' role='dialog' aria-hidden='true'>
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
									<div class='eventShortDesc' style='color:black'>Hosted by: ". $hosting_group_name . "</div>	
					        	<h1 id='modalEventDescTitle' style='color:black'>Description</h1>					        	
					        	<div class='modalEventDesc' style='color:black'>" . $tuple["event_description"] . "</div>
					        	<h1 id='modalEventDateTime' style='color:black'>Date/Time</h1>
					        	<div class='eventDate' style='color:black'>" . $tuple["event_start_date"] . "</div>
		  						<div class='eventTime' style='color:black'>" . $tuple["event_start_time"] . "</div>
					        </div>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-primary' id='eventLeaveButton'>Leave</button>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
					      </div>
					    </div>
					  </div>
					</div>";
					
			}
		}
		?>
		
		<?php
		
		$search_past_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								ORDER BY date_time DESC
								LIMIT 5;";
								
								
		$result = $conn->query($search_past_user_events);
		
		// echo $search_past_user_events;
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
				echo "<div class='modal fade' id='pastEventModal_"  . $tuple["event_id"] .   "' tabindex='-1' role='dialog' aria-hidden='true'>
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
					        	<div class='modalEventStartedWarning' style='color:black'>Note: Event has already started!</div>
					        	<h1 id='modalEventDescTitle' style='color:black'>Description</h1>					        	
					        	<div class='modalEventDesc' style='color:black'>" . $tuple["event_description"] . "</div>
					        	<h1 id='modalEventDateTime' style='color:black'>Date/Time</h1>
					        	<div class='eventDate' style='color:black'>" . $tuple["event_start_date"] . "</div>
		  						<div class='eventTime' style='color:black'>" . $tuple["event_start_time"] . "</div>
					        </div>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
					      </div>
					    </div>
					  </div>
					</div>";
			}
		}
		
		$conn->close();
?>
</div>
</html>