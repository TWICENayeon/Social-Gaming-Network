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
	
<!-- Print out all of the current user's events --> 	
<?php echo "<u>" . $_SESSION["current_username"]?>'s Future Events </u>

 <?php
	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$search_future_user_events =  "SELECT event_id, event_name
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME));";
		
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
			}
		}
		?>
		<br><br><br><br><br>
		<?php echo "<u>" . $_SESSION["current_username"]?>'s Past Events </u>
		
		<?php
		
		$search_future_user_events =  "SELECT event_id, event_name
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME));";
		
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
			}
		}
		
		$conn->close();
?>

</html>