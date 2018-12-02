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
	// Connect to the database
	$conn = new mysqli("localhost", "root", "");

		
	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}
	
	$conn->select_db("sgn_database");
	
	$curr_group_id = $_POST["group_id"];
	



$fetch_group_future_events_query = "SELECT event_id, event_name, event_start_date, event_start_time
																	FROM events INNER JOIN group_events
																	ON event_id = hosted_event_id
																	WHERE hosting_group_id = " . $curr_group_id . " AND 
																	(event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME()));";
																	
$group_future_events_result = $conn->query($fetch_group_future_events_query);

if($group_future_events_result->num_rows == 0) {
	echo "<div class='groupEventsDialog'>No upcoming events just yet!</div>";
}
else {
	
	echo "<div class='groupEventsTitle'>Upcoming Events</div>
	";
	while($future_event_tuple = $group_future_events_result->fetch_assoc()) {
		echo "<div class='eventContBox'>							        		
			<div class='listEventName'>" . $future_event_tuple["event_name"] . "</div>
			<div class='listEventDate'>" . $future_event_tuple["event_start_date"] . "</div>
			<div class='listEventTime'>" . $future_event_tuple["event_start_time"] . "</div>
			<div class='listEventButtons'>";
			
				$fetch_current_user_attendance = "SELECT attendee_id
													FROM attendees
													WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND attended_event_id = " . $future_event_tuple["event_id"] . ";";
										
				$is_attending_result = $conn->query($fetch_current_user_attendance);
			
				if(($is_attending_result->num_rows) == 0) {
					echo "<button type='button' class='btn btn-primary' onclick='processAttendance(" . $future_event_tuple["event_id"] . ", 1, " . $curr_group_id . ")'>Join</button>";
				}
				else {
					echo "<button type='button' class='btn btn-primary' onclick='processAttendance(" . $future_event_tuple["event_id"] . ", 0, " . $curr_group_id . ")'>Leave</button>";
				}
			echo "</div>
		</div>";
	}
		
}
								
?>

</html>