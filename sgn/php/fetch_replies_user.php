<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

// $_SESSION["page_id"] = $_POST["page_id"];
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

<?php	
	$fetch_replies_query = "SELECT post_id, username, post_text, post_date, post_time, post_votes, user_id
												FROM sgn_database.posts JOIN sgn_database.users
												ON posts.poster_id = users.user_id
												WHERE parent_post_id = " . $_POST["parent_post_id"] . ";";
							
	$children_result = $conn->query($fetch_replies_query);
	// Print replies to reply modal
	while($child_tuple = $children_result->fetch_assoc()) { // Load profile picture
		$fetch_profile_picture_reply = "SELECT image_name
									FROM images
									WHERE owner_type = 0 AND owner_id = " . $child_tuple["user_id"] . " AND currently_set = 1 AND image_type = 0;";
									
									
		$profile_picture_name_reply = (($conn->query($fetch_profile_picture_reply))->fetch_assoc())["image_name"];
									
		$has_liked_reply_query = "SELECT *
							FROM post_votes
							WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $child_tuple["post_id"] . ";";	

		$liked_reply_value = ($conn->query($has_liked_reply_query))->num_rows == 1;
		
		$fetch_reply_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
								FROM sgn_database.post_votes
								WHERE voted_id = " . $child_tuple["post_id"] . ";";
								
		$reply_vote_total = (($conn->query($fetch_reply_votes_query))->fetch_assoc())["total"];
		
		if(!isset($reply_vote_total)) {
			$reply_vote_total = '0';
		}
									
		echo 		"<div class='commentCont'>
						<div class='commentProfileImage' style='background-image: url(user_images/" . $profile_picture_name_reply . ")'></div>
						<div class='commentPostGap'></div>
						<div class='commentPostName' style='color:black'>" . $child_tuple["username"] . "</div>
						<div class='commentPostDate' style='color:black'>" . $child_tuple["post_date"] . "</div>
						<div class='commentPostTime' style='color:black'>" . $child_tuple["post_time"] . "</div>
						<div class='commentText' style='color:black'>". $child_tuple["post_text"] . "</div>
						<div class='commentPostVoteButtons'>
							<div class='commentPostUpvote'style='color:black' onclick='likeAction(this, " . $child_tuple["post_id"] . ", 0)'>
							<i class='fa fa-hand-o-up' aria-hidden='false'  " . ($liked_reply_value ? " style='color:blue' " : "") ."></i>			
							<span id='vote_total'>" . $reply_vote_total . " </span>
							</div>
						</div>
					</div>";
		
	}

	$conn->close();
	?>


</html>