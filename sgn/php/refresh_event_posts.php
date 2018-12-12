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
		
		
		echo "	<div class='modalEventInfoCont'>";
									
				$search_event_wall_posts =  "SELECT post_id, username, user_id, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_POST["event_id"] . " AND wall_type = 2
									ORDER BY post_id DESC;";
								   
				$event_post_result = $conn->query($search_event_wall_posts);
				
				if($event_post_result->num_rows > 0) {
					while($event_post_tuple = $event_post_result->fetch_assoc()) {
						
						
						$fetch_profile_picture_reply = "SELECT image_name
													FROM images
													WHERE owner_type = 0 AND owner_id = " . $event_post_tuple["user_id"] . " AND currently_set = 1 AND image_type = 0;";
													
													
						$profile_picture_name_reply = (($conn->query($fetch_profile_picture_reply))->fetch_assoc())["image_name"];
						
					
						
						$has_liked_reply_query = "SELECT *
											FROM post_votes
											WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $event_post_tuple["post_id"] . ";";	

						$liked_reply_value = ($conn->query($has_liked_reply_query))->num_rows == 1;
						
						$fetch_reply_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
												FROM sgn_database.post_votes
												WHERE voted_id = " . $event_post_tuple["post_id"] . ";";
												
						$reply_vote_total = (($conn->query($fetch_reply_votes_query))->fetch_assoc())["total"];

						
						if(!isset($reply_vote_total)) {
							$reply_vote_total = "0";
						}
										// Fetch posts related to the event
						echo " <div class='eventPostCont'>
												<div class='eventPostProfileImage'  style='background-image: url(user_images/" . $profile_picture_name_reply . ")'></div>
												<div class='eventPostGap'></div>
												<div class='eventPostName' style='color:black'>" . $event_post_tuple["username"] . "</div>
												<div class='eventPostDate' style='color:black'>" . $event_post_tuple["post_date"] . "</div>
												<div class='eventPostTime' style='color:black'>" . $event_post_tuple["post_time"] . "</div>
												<div class='eventPostComment' style='color:black'>" . $event_post_tuple["post_text"] . "</div>
										<div class='commentPostVoteButtons'>
											<div class='commentPostUpvote'style='color:black' onclick='likeAction(this, " . $event_post_tuple["post_id"] . ", 2)'>
											<i class='fa fa-hand-o-up' aria-hidden='false'  " . ($liked_reply_value ? " style='color:blue' " : "style='color:black'") ."></i>			
											<span id='vote_total'>" . $reply_vote_total . " </span>
											</div>
												</div>
											</div>	";			 
					}	
				}
				else {
					echo "<!-- should disappear if there are no posts -->
					<div class='modalEventStartedWarning' style='color:black'>No posts to show</div>";
				}
				echo "</div>";
		
		
		$conn->close();
?>
</html>