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
	
	$event_id = $_POST["event_id"];
	$attendance = $_POST["attendance"];
	
	if($attendance == "1") {
		$add_attendance_query = "INSERT INTO attendees
									VALUES (" . $_SESSION["current_user_id"] . ", " . $event_id . ", CURRENT_DATE(), CURRENT_TIME, '')";
									
		echo $add_attendance_query;
									
		$conn->query($add_attendance_query);
	}
	else {
		$remove_attendance_query = "DELETE FROM attendees
									WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND attended_event_id = " . $event_id . ";";
									
		echo $remove_attendance_query;
									
		$conn->query($remove_attendance_query);
	}
?>
</html>