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

<?php 

	$conn = new mysqli("localhost", "root", "");

		
	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}

?>

<?php
	// // Resolve notification
			// if(!empty($_GET["notification_id"])) {
				// $resolve_notification_query = "UPDATE sgn_database.notifications
												// SET resolved_status = 1
												// WHERE notification_id = " . $_GET["notification_id"] . ";";
			
				// if($conn->query($resolve_notification_query) === false) {
					// echo "Failed to resolve notification";
				// }
			// }

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
	

<!-- Print out all of the current user's groups -->
<?php echo "<u> " . $_SESSION["current_username"]?>'s Notifications </u> 


 <?php
		
		$search_user_notifications =  "SELECT *
									FROM sgn_database.notifications
									WHERE recipient_id = " . $_SESSION["current_user_id"] . "
									ORDER BY notification_id DESC;";
		
		$result = $conn->query($search_user_notifications);
		
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br><br>";
				if($tuple["resolved_status"] == 1) {
						$isResolved = true;
						echo "<p style='color:#C6C6C6'>";
				}
				else {
					echo "<p>";
				}
				echo stripslashes($tuple["message"]) . " <br>" . $tuple["date_created"] . " " . $tuple["time_created"] . " </p>";
				if(!$tuple["resolved_status"]) {
					echo "<form action='process_notification.php' method='post'>
							<input type='hidden' name='notification_id' value = " . $tuple["notification_id"] . ">
							<input type='submit' name = 'accept' value='Accept'>
							<input type='submit' name='decline' value='Decline'>
						</form>";
				}
			}
		}
		
		$conn->close();
?>

</html>