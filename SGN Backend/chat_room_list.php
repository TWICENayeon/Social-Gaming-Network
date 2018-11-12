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
	
		// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
?>


<html>




<?php
// Get number of unresolved notifications
	$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
												FROM notifications
												WHERE recipient_id = " . $_SESSION["current_user_id"] . " and resolved_status = false;";
	
	// echo $fetch_num_unresolved_notifications_query;
												
	$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];



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
<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <?php if(intval($num_unresolved_string) > 0) {echo "[" . $num_unresolved_string . "]";}?> <br>
<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
<a href="http://localhost/sgn/settings.php"> User settings </a> <br>

<br>
<br>

<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	
	<?php 
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");
		

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
		
	?>
	
	Chat Rooms
	<?php
		$fetch_chat_groups = "SELECT * 
								FROM chat_groups JOIN chat_group_members
								ON chat_groups.chat_id = chat_group_members.chat_id
								WHERE chat_member_id = " . $_SESSION["current_user_id"] . " AND esport_id != 0;";
								
		$chat_groups_result = $conn->query($fetch_chat_groups);
		
		while($chat_group_tuple = $chat_groups_result->fetch_assoc()) {
			
			echo "<br> <br> <a href='http://localhost/sgn/chat_room_page.php?page_id=" . $chat_group_tuple["chat_id"] . "'>" . $chat_group_tuple["chat_name"] . " </a> <br>";
			echo "
					<form action='delete_chat_group.php' method='post'>
						<input type='hidden' name='chat_id' value = " . $chat_group_tuple["chat_id"] . ">
						<input type='submit' name='delete' value='Delete'>
					</form> ";
			echo "<br><br><br><br>";
		}
	?>
	