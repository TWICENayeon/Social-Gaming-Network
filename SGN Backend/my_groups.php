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

	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
	$conn->select_db("sgn_database");

?>


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

<!-- TODO: Test for data overflow -->
Create a new group
<form action="new_group.php" method="post">
	New Group's Name: <input type="text" name = "new_group_name" > <br>
	New Group's Description <input type="text" name = "new_group_description" >
	Privacy: <input type='radio' name = 'new_group_privacy'> <br>
	<input type="submit" value="Create">
</form>
<br>
<br>
<br>
<br>
<br>

<!-- Print out all of the current user's groups -->
<?php echo "<u> " . $_SESSION["current_username"]?>'s Groups </u>
 <?php
		
		$search_user_groups =  "SELECT group_id, group_name
									FROM sgn_database.memberships JOIN sgn_database.groups
									ON memberships.of_group_id = groups.group_id
									WHERE member_id = " . $_SESSION["current_user_id"] . ";";
		
		$result = $conn->query($search_user_groups);
		
		
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/group_page.php?page_id=" . $tuple["group_id"] . "'>" . $tuple["group_name"] . " </a> <br> <br>";
			}
		}
		
?>

</html>