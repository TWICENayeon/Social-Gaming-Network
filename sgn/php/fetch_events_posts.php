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
								WHERE attendee_id = " . $_SESSION["page_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
								ORDER BY date_time ASC;";
								
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		$future_counter = 0;
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br><a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br> <br>";
				// echo "<form method='post' action='event_page.php' >
				  // <input type='hidden' name='page_id' value='" . $tuple["event_id"]. "'>
				  // <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					// . $tuple["event_name"] . 
				  // "<br></button>
				// </form>";
				
	
				echo "<div class='modal fade' id='eventPostsModal_" . (string)$future_counter .  "' tabindex='-1' role='dialog' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Event Posts</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							  <div class='modal-body'>
								<div class='modalEventInfoCont'>
									<div class='eventPostCont'>
										<div class='eventPostProfileImage'></div>
										<div class='eventPostGap' style='color:black'></div>
										<div class='eventPostName' style='color:black'>" . $tuple["event_name"] . "</div>
										<div class='eventPostDate' style='color:black'>" . $tuple["event_start_date"] . "</div>
										<div class='eventPostTime' style='color:black'>" . $tuple["event_start_time"] . "</div>
										<div class='eventPostComment'>" . $tuple["event_description"] . "</div>
										<div class='eventPostVoteButtons'>					        			
											<div class='eventPostUpvote' style='color:black'>10M<i class='fa fa-hand-o-up' id='handUp' aria-hidden='true'></i></div>
											<div class='eventPostDownvote' style='color:black'>15K<i class='fa fa-hand-o-down' id='handDown' aria-hidden='true'></i></div>
											<button type='button' class='btn btn-primary' id='eventReplyButton'>Post</button>
										</div>
									</div>";
									
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
				++$future_counter;
			}
		}
 
 
		// Create post modals for past events
		$search_past_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["page_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								ORDER BY date_time DESC
								LIMIT 5;";
								
		// echo $search_past_user_events;
								
		$result = $conn->query($search_past_user_events);
		
		// echo $search_future_user_events;
		
		
				echo "<!-- Work prior -->";
		$past_counter = 0;
		
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
				echo "<div class='modal fade' id='pastEventPostsModal_" . (string)$past_counter .  "' tabindex='-1' role='dialog' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Event Posts</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							  <div class='modal-body'>
								<div class='modalEventInfoCont'>
									<div class='eventPostCont'>
										<div class='eventPostProfileImage'></div>
										<div class='eventPostGap'></div>
										<div class='eventPostName' style='color:black'>" . $tuple["event_name"] . "</div>
										<div class='eventPostDate' style='color:black'>" . $tuple["event_start_date"] . "</div>
										<div class='eventPostTime' style='color:black'>" . $tuple["event_start_time"] . "</div>
										<div class='eventPostComment' style='color:black'>" . $tuple["event_description"] . "</div>
										<div class='eventPostVoteButtons'>					        			
											<div class='eventPostUpvote' style='color:black'>10M<i class='fa fa-hand-o-up' id='handUp' aria-hidden='true'></i></div>
											<div class='eventPostDownvote' style='color:black'>15K<i class='fa fa-hand-o-down' id='handDown' aria-hidden='true'></i></div>
											<button type='button' class='btn btn-primary' id='eventReplyButton'>Post</button>
										</div>
									</div>";
									
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
				++$past_counter;
			}
		}
		
		
		$conn->close();
?>
</div>

</html>