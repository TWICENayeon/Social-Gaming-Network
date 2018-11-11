<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

if($_SESSION["page_type"] != 2) {
	header("Location: http://localhost/sgn/user_page.php?page_id=" . $_SESSION["current_user_id"]);
	exit();
}
?>
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
<html>
Event's settings page is under construction. <br><br><br><br><br><br><br>	
<?php

	
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");

		$check_group_privacy_query = "SELECT event_privacy
										FROM events
										WHERE event_id = " . $_SESSION["page_id"] . ";";
										
		// echo $check_group_privacy_query;
										
		$privacy_value = (($conn->query($check_group_privacy_query))->fetch_assoc())["event_privacy"];
	
?>
   <body>
   <form action='update_information.php' method='post'>
					New Event Name: <input type='text' name = 'new_event_name' > <br>
					New Event's Description: <input type='text' name = 'new_event_description' > <br>
					New Event's Date: <input type='date' name = 'new_event_date'> <br>
					New Event's Time: <input type='time' name = 'new_event_time' step = '2'> <br>
					Privacy: <br><br>
					<input type='radio' name = 'privacy' value = 'on' <?php if($privacy_value) {echo "checked='checked'";} ?>> On <br>
					<input type='radio' name = 'privacy' value = 'off' <?php if(!$privacy_value) {echo "checked='checked'";} ?>> Off <br>
					<input type='submit' value='Update'>
	</form>
      
   </body>

</html>