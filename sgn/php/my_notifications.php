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
	
	$conn->select_db("sgn_database");

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
<?php


?><?php
		
		$search_user_notifications =  "SELECT *
									FROM sgn_database.notifications
									WHERE recipient_id = " . $_SESSION["current_user_id"] . "
									ORDER BY notification_id DESC;";
		
		$user_notifications_result = $conn->query($search_user_notifications);
		
		$num_new_notifs_query = "SELECT COUNT(notification_id) AS num
									FROM sgn_database.notifications
									WHERE recipient_id = " . $_SESSION["current_user_id"] . " AND resolved_status = 0
									ORDER BY notification_id DESC;";
									
		$num_new_notifs_value = (($conn->query($num_new_notifs_query))->fetch_assoc())["num"];
		
		
		if($num_new_notifs_value == "0") {
			echo "
					      	<div class='noNotifsDialog'>No new notifications!</div>";
		}
		
		while($notif_tuple = $user_notifications_result->fetch_assoc()) {
			$is_resolved = $notif_tuple["resolved_status"] == "1";
			echo "
				<div class='notifCont'>
					<div class='notifDateTime'>
						<div class='notifDate' " . ($is_resolved ? " style='color:#C6C6C6' " : "") . ">" . $notif_tuple["date_created"] . "</div>
						<div class='notifTime' " . ($is_resolved ? " style='color:#C6C6C6' " : "") . ">" . $notif_tuple["time_created"] . "</div>
					</div>
					<div class='notifGroupRequestText' " . ($is_resolved ? " style='color:#C6C6C6' " : "") . ">" . $notif_tuple["message"] . "</div>";
			if(!$is_resolved) {
				if($notif_tuple["notification_type"] == "2") {
					echo "<button type='button' id='acceptButton' class='btn btn-primary' onclick='resolveNotif(" . $notif_tuple["notification_id"] . ", 1)'>OK</button>";
				}
				else {
					echo "<button type='button' id='acceptButton' class='btn btn-primary' onclick='resolveNotif(" . $notif_tuple["notification_id"] . ", 1)'>Accept</button>
					";
					echo "<button type='button' id='declineButton' class='btn btn-primary' onclick='resolveNotif(" . $notif_tuple["notification_id"] . ", 0)'>Decline</button>";
				}
			};
				echo "</div>";
			// echo "<br><br>";
			// if($tuple["resolved_status"] == 1) {
					// $isResolved = true;
					// echo "<p style='color:#C6C6C6'>";
			// }
			// else {
				// echo "<p>";
			// }
			// echo stripslashes($tuple["message"]) . " <br>" . $tuple["date_created"] . " " . $tuple["time_created"] . " </p>";
			// if(!$tuple["resolved_status"] && intval($tuple["notification_type"]) < 2 ) {
				// echo "<form action='process_notification.php' method='post'>
						// <input type='hidden' name='notification_id' value = " . $tuple["notification_id"] . ">
						// <input type='submit' name = 'accept' value='Accept'>
						// <input type='submit' name='decline' value='Decline'>
					// </form>";
			// }
			// else if(!$tuple["resolved_status"] && intval($tuple["notification_type"]) == 2 ) {
				// echo "<form action='process_notification.php' method='post'>
						// <input type='hidden' name='notification_id' value = " . $tuple["notification_id"] . ">
						// <input type='submit' name = 'ok' value='OK'>
					// </form>";
			// }
		}
		
		
		$conn->close();
?>
</html>