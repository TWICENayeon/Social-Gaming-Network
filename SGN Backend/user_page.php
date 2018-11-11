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
	if(isset($_GET["page_id"])) {
		$_SESSION["page_id"] = $_GET["page_id"];
	}
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
									WHERE user_id = " . $_SESSION["page_id"] .";";
		
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
	<a href="http://localhost/sgn/settings.php"> User settings </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	<?php
		
		if($_SESSION["current_user_id"] == $_SESSION["page_id"]) {
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
				
				$search_friend =  "SELECT friendship_id, active
									FROM sgn_database.friendships
									WHERE ((friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_SESSION["page_id"] . ") OR 
									(friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_SESSION["page_id"] . "));";
				
				$result = $conn->query($search_friend);
				
				if($result->num_rows == 0) {
					
					// Add new chat group for the new friendship pair
					
					$new_friend_chat_query =  "INSERT INTO sgn_database.chat_groups (esport_id) 
											  VALUES (0);";										// 0 means it is a friend chat 
				
					$result = $conn->query($new_friend_chat_query);
					
					if($result === false) {
						echo("Failed to insert new friendship chat pair");
						exit();
					}
					
					$chat_id = $conn->insert_id;
					
					// Make current user as a member to new chat group
					
					$new_chat_member_one = "INSERT INTO sgn_database.chat_group_members 
											VALUES (" . $chat_id . ", " . $_SESSION["current_user_id"] . ")";
											
					
				
					$result = $conn->query($new_chat_member_one);
					
					if($result === false) {
						echo("Failed to insert new chat friend 1");
						exit();
					}
					
					
					// Make new friend as a member to new chat group
					
					$new_chat_member_two = "INSERT INTO sgn_database.chat_group_members 
											VALUES (" . $chat_id . ", " . $_SESSION["page_id"] . ")";
											
					
				
					$result = $conn->query($new_chat_member_two);
					
					if($result === false) {
						echo("Failed to insert new chat friend 2");
						exit();
					}
					
					// add frienship
					$new_friendship_query =  "INSERT INTO sgn_database.friendships (friend_id_1, friend_id_2, friendship_start_date, chat_id, active)
											  VALUES (" . $_SESSION["current_user_id"] . ", " . $_SESSION["page_id"] . ", CURRENT_DATE(), " . $chat_id . ", 1);";
				
					$result = $conn->query($new_friendship_query);
					
					if($result === false) {
						echo $new_friendship_query;
						echo("<br> <br> <br> Failed to insert new friendship!!");
						exit();
					}
				}
				else {
					$refriend_query =  "UPDATE sgn_database.friendships
									SET active = true
									WHERE ((friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_SESSION["page_id"] . ") OR 
									(friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_SESSION["page_id"] . "));";
			
				$result = $conn->query($refriend_query);
				
				if($result === false) {
					echo $refriend_query;
					echo("Failed to update friendship active status to false");
					exit();
				}
				}
			}
			else if(!empty($_POST["unfriend"])) {
				$unfriend_query =  "UPDATE sgn_database.friendships
									SET active = false
									WHERE ((friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_SESSION["page_id"] . ") OR 
									(friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_SESSION["page_id"] . "));";
			
				$result = $conn->query($unfriend_query);
				
				if($result === false) {
					echo $unfriend_query;
					echo("Failed to update friendship active status to false");
					exit();
				}
			}
		
			$search_friend =  "SELECT friend_id_2 AS friend_id
								FROM sgn_database.friendships 
								WHERE friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_SESSION["page_id"] . " AND active = true
								UNION
								SELECT friend_id_1 AS friend_id
								FROM sgn_database.friendships
								WHERE friend_id_2 = " . $_SESSION["current_user_id"] . " AND friend_id_1 = " . $_SESSION["page_id"] . " AND active = true;";
			
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
		
		

	?>
	<?php	
		// Print all of the posts onto the page
		
		
		// Fetch the parent posts on the current wall
		$search_user_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_GET["page_id"] . " AND wall_type = 0 AND parent_post_id = 0" .
								   " ORDER BY post_id DESC;";
		
		$result = $conn->query($search_user_wall_posts);
		
		// echo $search_user_wall_posts . "<br><br><br>";
		
		// echo "Number of parent posts: " . $result->num_rows . "<br><br><br>";
		
		
		// For each parent post
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// Get vote count
				
				// if(!isset($tuple["post_id"])) {
					// break;
				// }
				
				$fetch_post_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $tuple["post_id"] . ";";
											
				// echo $fetch_post_votes_query . "<br><br><br>";
											
				$vote_total = (($conn->query($fetch_post_votes_query))->fetch_assoc())["total"];
				
				
				if (!isset($vote_total)) {
					$vote_total = 0;
				}
				// Print Post
				echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				
				// Check upvote
				
				$fetch_upvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . " AND value = 1;";
										
				$upvote_result = $conn->query($fetch_upvote_query);
				
				$has_upvoted = false;
				
				// echo $fetch_upvote_query . "<br><br>";
				
				if($upvote_result->num_rows == 1) {
					$has_upvoted = true;
				}
				$fetch_downvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . " AND value = -1;";
										
				$downvote_result = $conn->query($fetch_downvote_query);
				
				$has_downvoted = false;
				// echo $fetch_downvote_query . "<br><br>";
				
				if($downvote_result->num_rows == 1) {
					$has_downvoted = true;
				}
				
				
				// Reply, Upvote, and Downvote Form
				echo "<form action='new_post.php' method='post'>
						<input type='text' name = 'post_text' placeholder='Reply Here. . .' >
						<input type='hidden' name = 'parent_post_id' value='" . $tuple["post_id"] . "'>
						<input type='submit' value='Reply'> 
					</form><br>";
				
				echo "<form action='process_vote.php' method='post'>
					<input type='hidden' name = 'post_id' value='" . $tuple["post_id"] . "'>";
					if($has_upvoted) {
						echo "<input type='submit' name='remove_upvote' value='Remove Upvote'>";
					}
					else {
						echo "<input type='submit' name='upvote' value='Upvote'>";
					}
					if($has_downvoted) {
						echo "<input type='submit' name='remove_downvote' value='Remove Downvote'>";
					}
					else {
						echo "<input type='submit' name='downvote' value='Downvote'>";
					}
				echo "</form> <br><br>";
					  
				// Fetch the children posts for each parent post	  
				$fetch_children_posts_query = "SELECT post_id, username, post_text, post_date, post_time, post_votes
												FROM sgn_database.posts JOIN sgn_database.users
												ON posts.poster_id = users.user_id
												WHERE parent_post_id = " . $tuple["post_id"] . ";";
												
				// echo $fetch_children_posts_query . "<br><br><br><br>";
				
				$children_result = $conn->query($fetch_children_posts_query);
				
				// Print Parent Post's children posts
				
				while($child_tuple = $children_result->fetch_assoc()) {
					$fetch_post_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $child_tuple["post_id"] . ";";
											
					$vote_total = (($conn->query($fetch_post_votes_query))->fetch_assoc())["total"];
					
					if (!isset($vote_total)) {
						$vote_total = 0;
					}
					
					
					// Print child
					echo "<br> <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["username"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["post_date"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $child_tuple["post_time"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $child_tuple["post_text"] . "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  . $vote_total . " <br> <br>";
					$fetch_upvote_query = "SELECT value 
										FROM sgn_database.post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $child_tuple["post_id"] . " AND value = 1;";
										
					$upvote_result = $conn->query($fetch_upvote_query);
					
					// echo $fetch_upvote_query . "<br><br>";
					$has_upvoted = false;
					
					if($upvote_result->num_rows == 1) {
						$has_upvoted = true;
					}
					$fetch_downvote_query = "SELECT value 
											FROM sgn_database.post_votes
											WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $child_tuple["post_id"] . " AND value = -1;";
											
					$downvote_result = $conn->query($fetch_downvote_query);
					
					$has_downvoted = false;
					
					// echo $fetch_downvote_query . "<br><br>";
					if($downvote_result->num_rows == 1) {
						$has_downvoted = true;
					}
					
					// Upvote and Downvote Form
							
					echo "<form action='process_vote.php' method='post'>
							<input type='hidden' name = 'post_id' value='" . $child_tuple["post_id"] . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						if($has_upvoted) {
							echo "<input type='submit' name='remove_upvote' value='Remove Upvote'>";
						}
						else {
							echo "<input type='submit' name='upvote' value='Upvote'>";
						}
						if($has_downvoted) {
							echo "<input type='submit' name='remove_downvote' value='Remove Downvote'>";
						}
						else {
							echo "<input type='submit' name='downvote' value='Downvote'>";
						}
					echo "</form>  <br>";
				}
				
				
			}
		}

		$conn->close();
	?>
</html>