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
		
		$fetch_num_notifications_query = "SELECT COUNT(notification_id) AS num
											FROM notifications
											WHERE recipient_id = " . $_SESSION["current_user_id"] . " AND resolved_status = 0;";
		
		echo (($conn->query($fetch_num_notifications_query))->fetch_assoc())["num"];
		
		$conn->close();
?>

</html>