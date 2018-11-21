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
		
		$fetch_num_notifications_query = "SELECT username
											FROM users
											WHERE user_id = " . $_SESSION["current_user_id"] . ";";
		
		echo (($conn->query($fetch_num_notifications_query))->fetch_assoc())["username"];
		
		$conn->close();
?>

</html>