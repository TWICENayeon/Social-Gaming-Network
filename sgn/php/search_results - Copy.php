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

<?php
// Get number of unresolved notifications
	$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
												FROM notifications
												WHERE recipient_id = " . $_SESSION["current_user_id"] . " and resolved_status = false;";
	
	// echo $fetch_num_unresolved_notifications_query;
												
	$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];



?>



<!-- Results within users -->
<u>Users</u>
 <?php
		
		
		$search_users =  "SELECT username, user_id
						  FROM sgn_database.users
						  WHERE username LIKE '%" . $_GET["search_term"]. "%';";
		
		$result = $conn->query($search_users);
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/user_page.php?page_id=" . $tuple["user_id"] . "'>" . $tuple["username"] . " </a> <br> <br>";
			}
		}
		
?>
</p>
<br> <br> <br> <br> <br>

<p>
<!-- Results in Groups -->
<u>Groups</u>
<?php
		
		$search_groups =  "SELECT group_id, group_name
						  FROM sgn_database.groups
						  WHERE group_name LIKE '%" . $_GET["search_term"]. "%' AND group_privacy = 0
						  UNION
						  SELECT group_id, group_name
						  FROM sgn_database.groups JOIN sgn_database.memberships
						  ON groups.group_id = memberships.of_group_id
						  WHERE group_name LIKE '%" . $_GET["search_term"]. "%' AND group_privacy = 1 AND member_id = " . $_SESSION["current_user_id"] . ";";
		
		$result = $conn->query($search_groups);
		
		
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/group_page.php?page_id=" . $tuple["group_id"] . "'>" . $tuple["group_name"] . " </a> <br> <br>";
			}
		}
		
?>
</p>
<br> <br> <br> <br> <br>

<p>
<!-- Results in Events -->
<u>Events</u>
<?php
	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		//TODO: Show only events that are public or private to current user's group
		
		$search_events =  "SELECT event_id, event_name, event_start_date, event_start_time
							FROM sgn_database.group_events  JOIN sgn_database.events JOIN sgn_database.memberships
							ON `group_events`.`hosted_event_id` = `events`.`event_id` AND `group_events`.`hosting_group_id` = `memberships`.`of_group_id`
							WHERE  member_id = " . $_SESSION["current_user_id"] . " AND event_privacy = 1 AND event_name LIKE '%" . $_GET["search_term"]. "%'" .
							" UNION
							SELECT event_id, event_name, event_start_date, event_start_time
							FROM  sgn_database.events
							WHERE  event_privacy = 0 AND event_name LIKE '%" . $_GET["search_term"]. "%' 
							ORDER BY event_start_date, event_start_time ASC;";
		
		$result = $conn->query($search_events);
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br>" . $tuple["event_start_date"] . "<br>" . $tuple["event_start_time"] . "<br>";
			}
		}
		
?>
</p>

</html>