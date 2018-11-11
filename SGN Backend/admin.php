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

<?php

	

?>



<html>
	
	<body onload=refreshMessages()>

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
	
	ADMIN PAGE, USERS SHOULD NOT SEE THIS
	<br><br><br><br><br>
	
	<?php 
	
		$debug = false;
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
		
		
		// Resolve accept/decline
		
		if(isset($_POST["requestor_id"])) {
		$remove_request_query = "DELETE FROM requests
								WHERE requestor_id = " . $_POST["requestor_id"] . ";";
								
		echo $remove_request_query;
		
		$conn->query($remove_request_query);
		
		echo "<br><br><br><br>";
		
		if(isset($_POST["accept"])) {
			// UPDATE user tuple
			$update_user_privilege_query = "UPDATE users
											SET posts_articles = true
											WHERE user_id = " . $_POST["requestor_id"] . ";";
			
									
			echo $update_user_privilege_query;
			
			$conn->query($update_user_privilege_query);
			
			
			echo "<br><br><br><br>";
			// Send acceptance notification
			$insert_accept_request_notification = "INSERT into sgn_database.notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
															VALUES(2, 0, " . $_POST["requestor_id"] . ", 'Your request to post articles has been accepted' , 0, CURRENT_DATE(), CURRENT_TIME());";
									
			echo $insert_accept_request_notification;
			
			$conn->query($insert_accept_request_notification);
			echo "<br><br><br><br>";
		}
		else {
			// Send decline notification
			$insert_decline_request_notification = "INSERT into sgn_database.notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
															VALUES(2, 0, " . $_POST["requestor_id"] . ", 'Your request to post articles has been declined' , 0, CURRENT_DATE(), CURRENT_TIME());";
															
			echo $insert_decline_request_notification;
			
			$conn->query($insert_decline_request_notification);
			echo "<br><br><br><br>";
		}
	}
	
	// Print requests
		
		$fetch_all_requests = "SELECT * 
								FROM requests";
								
		$requests_result = $conn->query($fetch_all_requests);
		
		echo "Requests: <br><br><br>";
		while($request_tuple = $requests_result->fetch_assoc()) {
			echo $request_tuple["requestor_username"] . " requests permission to post articles! ";
			
				echo "<form action='' method='post'>
					<input type='hidden' name = 'requestor_id' value='" . $request_tuple["requestor_id"] . "'>";
					echo "<input type='submit' name='accept' value='Accept'>";
					echo "<input type='submit' name='decline' value='Decline'>";
				echo "</form> <br><br>";
		}
	?>
	
	<form 
	
	</body>
</html>