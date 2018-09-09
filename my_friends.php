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
<a href="http://localhost/sgn/user_page.php?page_id=<?php echo $_SESSION["current_user_id"]; ?> "> SGN </a> <br>
<form action="search_results.php" method="get">
	<input type="text" name = "search_term" placeholder="Search. . ." >
	<input type="submit" value="Search">
</form>
<br>
<a href="http://localhost/sgn/my_groups.php"> My Groups </a> <br>
<a href="http://localhost/sgn/my_events.php"> My Events </a> <br>
<br>
<br>

<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br> <br>
<!-- Banner End -->	
	
	
<!-- Print out all of the current user's events --> 	
<?php echo "<u>" . $_SESSION["current_username"]?>'s Friends </u>

 <?php
	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$search_user_events =  "SELECT friend_id_2 AS friend_id, username AS friend_username
								FROM sgn_database.friendships JOIN sgn_database.users
								ON friendships.friend_id_2 = users.user_id
								WHERE friend_id_1 = " . $_SESSION["current_user_id"] . "
								UNION
								SELECT friend_id_1 AS friend_id, username
								FROM sgn_database.friendships JOIN sgn_database.users
								ON friendships.friend_id_1 = users.user_id
								WHERE friend_id_2 = " . $_SESSION["current_user_id"] . "
								ORDER BY friend_id ASC;";
		
		$result = $conn->query($search_user_events);
		
		
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> <a href='http://localhost/sgn/user_page.php?page_id=" . $tuple["friend_id"] . "'>" . $tuple["friend_username"] . " </a> <br> <br>";
			}
		}
		
?>

</html>