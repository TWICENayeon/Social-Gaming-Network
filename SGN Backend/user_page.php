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
	
	$_SESSION["page_id"] = $_GET["page_id"];
	$_SESSION["page_type"] = 0;
?>



<html>
	
	<?php 
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		// Fetch the posts on the current wall
		$search_current_username =  "SELECT username
									FROM sgn_database.users
									WHERE user_id = " . $_GET["page_id"] .";";
		
		$result = ($conn->query($search_current_username)->fetch_assoc());
		
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
	
	<?php
		
		if($_SESSION["current_user_id"] == $_GET["page_id"]) {
			echo "Welcome <u>" . $result["username"] . "</u>! <br> <br> <br>"; 
		}
		else {
			echo $result["username"] . "'s Page!<br> <br> <br>";
		}
	?>
	
	<!-- Form to add a new post to the wall -->
	<form action="new_post.php" method="post">
		<input type="text" name = "post_text" placeholder="Write a post. . ." >
		<input type="submit" value="Submit">
	</form>

		
	<?php	
		if($_SESSION["current_user_id"] != $_SESSION["page_id"]) {
			// Process Add Friend or Unfriend
			if(!empty($_POST["add_friend"])) {
				$new_attendence_query =  "INSERT INTO sgn_database.friendships 
										  VALUES (" . $_SESSION["current_user_id"] . ", " . $_SESSION["page_id"] . ", CURRENT_DATE());";
			
				$result = $conn->query($new_attendence_query);
				
				if($result === false) {
					echo("Failed to insert new friendship");
					exit();
				}
			}
			else if(!empty($_POST["unfriend"])) {
				$new_attendence_query =  "DELETE FROM sgn_database.friendships 
										  WHERE friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_SESSION["page_id"] . 
										  " OR friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_SESSION["page_id"] . ";";
			
				$result = $conn->query($new_attendence_query);
				
				if($result === false) {
					echo $new_attendence_query;
					echo("Failed to remove friendship");
					exit();
				}
			}
		
			$search_friend =  "SELECT friend_id_2 AS friend_id
								FROM sgn_database.friendships 
								WHERE friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_GET["page_id"] . " 
								UNION
								SELECT friend_id_1 AS friend_id
								FROM sgn_database.friendships
								WHERE friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_GET["page_id"] . " ;";
			
			$result = ($conn->query($search_friend));
			
			if($result->num_rows == 0) {
			echo "
				<form action='user_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
					<input type='submit' name='add_friend' value='Add Friend'>
				</form> ";
			}
			else if($result->num_rows == 1) {
				echo "
				<form action='user_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
					<input type='submit' name='unfriend' value='Unfriend'>
				</form> ";
			}
			else {
				echo "\nReceived a result that has more than one tuple for search friend query\n";
				exit();
			}
		}
		
		// Print all of the posts onto the page
		
		// Fetch the posts on the current wall
		$search_user_wall_posts =  "SELECT username, post_text, post_date, post_time, post_votes
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_GET["page_id"] . " AND wall_type = 0 " . 
								   " ORDER BY post_id DESC;";
		
		$result = $conn->query($search_user_wall_posts);
		
		
		
		
		$conn->close();
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>". $tuple["post_votes"] . "<br> <br>";
			}
		}

	?>

</html>