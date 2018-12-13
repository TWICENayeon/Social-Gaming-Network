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

<div class="eventPostsModals">


<!-- Print out all of the current user's upcoming events --> 	

 <?php
		// Create post modals for future events
		$search_future_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
								ORDER BY date_time ASC;";
								
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
	
				echo "<div class='modal fade' id='eventPostsModal_" . $tuple["event_id"] .  "' tabindex='-1' role='dialog' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Event Posts</h5>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							  <div class='modal-body' id='eventPostsBody_" . $tuple["event_id"] .  "'>
								<div class='modalEventInfoCont'>";
									
				$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time, user_id
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $tuple["event_id"] . " AND wall_type = 2
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
												<div class='eventPostProfileImage'  style='background-image: url(user_images/" . (!empty($profile_picture_name_reply) ? $profile_picture_name_reply : "Profile-icon-9.png") . ")'></div>
												<div class='eventPostGap'></div>
												<div class='eventPostName' style='color:black'>" . $event_post_tuple["username"] . "</div>
												<div class='eventPostDate' style='color:black'>" . $event_post_tuple["post_date"] . "</div>
												<div class='eventPostTime' style='color:black'>" . $event_post_tuple["post_time"] . "</div>
												<div class='eventPostComment' style='color:black'>" . $event_post_tuple["post_text"] . "</div>
										<div class='commentPostVoteButtons'>
											<div class='commentPostUpvote'style='color:black' onclick='likeAction(this, " . $event_post_tuple["post_id"] . ", 2)'>
											<i class='fa fa-hand-o-up' aria-hidden='false' " . ($liked_reply_value ? " style='color:blue' " : "style='color:black'") ."></i>			
											<span id='vote_total'>" . $reply_vote_total . "</span>
											</div>
												</div>
											</div>	";			        	

						
					}	
				}
				else {
					echo "<!-- should disappear if there are no posts -->
					<div class='modalEventStartedWarning' style='color:black'>No posts to show</div>";
				}
				echo "</div>
					<textarea class='postTextBox' id='eventReplyTextBox_" . $tuple["event_id"] . "' placeholder='Write something:' rows='6' cols='60'></textarea>
				  </div>
				  <div class='modal-footer'>					      						        
					<button type='button' class='btn btn-primary' id='eventReplyButton' onclick='createEventPost(" . $tuple["event_id"] . ")'>Post</button>
					<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				  </div>
				</div>
			  </div>
			</div>";
			}
		}
 
 
		// Create post modals for past events
		$search_past_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								ORDER BY date_time DESC
								LIMIT 5;";
								
		// echo $search_past_user_events;
								
		$result = $conn->query($search_past_user_events);
		
		// echo $search_future_user_events;
		
		
				echo "<!-- Work prior -->";
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
				echo "<!-- Work before -->";
				echo "<div class='modal fade' id='eventPostsModal_" . $tuple["event_id"]  .  "' tabindex='-1' role='dialog' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Event Posts</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							  <div class='modal-body'>
								<div class='modalEventInfoCont'>";
									
				$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $tuple["event_id"] . " AND wall_type = 2" .
								   " ORDER BY post_id DESC;";
								   
				$event_post_result = $conn->query($search_event_wall_posts);
				
				if($event_post_result->num_rows > 0) {
					while($event_post_tuple = $event_post_result->fetch_assoc()) {
									   
										// Fetch posts related to the event
						echo " <div class='eventPostCont'>
												<div class='eventPostProfileImage'></div>
												<div class='eventPostGap'></div>
												<div class='eventPostName' style='color:black'>" . $event_post_tuple["username"] . "</div>
												<div class='eventPostDate' style='color:black'>" . $event_post_tuple["post_date"] . "</div>
												<div class='eventPostTime' style='color:black'>" . $event_post_tuple["post_time"] . "</div>
												<div class='eventPostComment' style='color:black'>" . $event_post_tuple["post_text"] . "</div>
												<div class='eventPostVoteButtons'>		        			
													<div class='eventPostUpvote'><i class='fa fa-hand-o-up' aria-hidden='true'></i></div>
													<div class='eventPostDownvote'><i class='fa fa-hand-o-down' aria-hidden='true'></i></div>
													<button type='button' class='btn btn-primary' id='eventReplyButton'>Post</button>
												</div>
											</div>	";			        	

						
					}	
				}
				else {
					echo "<!-- should disappear if there are no posts -->
					<div class='modalEventStartedWarning' style='color:black'>No posts to show</div>";
					
				}
				echo "</div>
				  </div>
				  <div class='modal-footer'>					      						        
					<!-- <button type='button' class='btn btn-primary' id='eventReplyButton'>Post</button> -->
					<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				  </div>
				</div>
			  </div>
			</div>";
			}
		}
		
		
		$conn->close();
?>
</div>

</html>