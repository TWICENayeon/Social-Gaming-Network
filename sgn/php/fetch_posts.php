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
		// Print all of the posts onto the page
		
		
		// Fetch the parent posts on the current wall
		$search_user_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $_SESSION["page_id"] . " AND wall_type = 0 AND parent_post_id = 0" .
								   " ORDER BY post_id DESC;";
								   
		
		
		$result = $conn->query($search_user_wall_posts);
		
		// echo $search_user_wall_posts . "<br><br><br>";
		
		// echo "Number of parent posts: " . $result->num_rows . "<br><br><br>";
		
		
		// For each parent post
		if($result->num_rows > 0) {
			$post_counter = 0;
			while($tuple = $result->fetch_assoc()) {
				
				$fetch_post_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $tuple["post_id"] . ";";
											
											
				$vote_total = (($conn->query($fetch_post_votes_query))->fetch_assoc())["total"];
				
				
				// Fetch the children posts for each parent post	  
				$fetch_children_posts_query = "SELECT post_id, username, post_text, post_date, post_time, post_votes
												FROM sgn_database.posts JOIN sgn_database.users
												ON posts.poster_id = users.user_id
												WHERE parent_post_id = " . $tuple["post_id"] . ";";
												
				// echo $fetch_children_posts_query . "<br><br><br><br>";
				
				$children_result = $conn->query($fetch_children_posts_query);
				
				
				if (!isset($vote_total)) {
					$vote_total = 0;
				}
				
				// Print Post
				//echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				
				echo "<div class='template-post'>					
					<div class='image-buttons-container'>						
						<div class='post-profile-image'></div>						
						<div class='post-profile-gap'></div>
						<div class='post-like-button'>													
							<i class='far fa-thumbs-up' id='thumbsUpIcon'></i>							
							2.5M
						</div>						
						<div class='post-comment-button' data-toggle='modal' data-target='#commentsModal_" . $post_counter . "'>							
							<i class='far fa-comments' id='commentsIcon'></i>
							33
						</div>
						<!-- Comments Modal -->
						<div class='modal fade' id='commentsModal_" . $post_counter . "' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title' id='exampleModalLabel'>Comments</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
							  <div class='modal-body'>";
				// Print replies to reply modal
				while($child_tuple = $children_result->fetch_assoc()) {
					echo 		"<div class='commentCont'>
					        		<div class='commentProfileImage'></div>
					        		<div class='commentPostGap'></div>
					        		<div class='commentPostName' style='color:black'>" . $child_tuple["username"] . "</div>
					        		<div class='commentPostDate' style='color:black'>" . $child_tuple["post_date"] . "</div>
					        		<div class='commentPostTime' style='color:black'>" . $child_tuple["post_time"] . "</div>
					        		<div class='commentText' style='color:black'>". $child_tuple["post_text"] . "</div>
					        		<div class='commentPostVoteButtons'>
					        			<div class='commentPostUpvote'><i class='fa fa-hand-o-up' aria-hidden='true'></i></div>
					        			<div class='commentPostDownvote'><i class='fa fa-hand-o-down' aria-hidden='true'></i></div>
					        		</div>
					        	</div>";
					
				}
				echo "<textarea class='postTextBox' placeholder='Write what's going on:' rows='6' cols='60'></textarea>
						      </div>
						      <div class='modal-footer'>
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						        <button type='button' class='btn btn-primary'>Post!</button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>						
					<div class='post-text-container'>						
						<div class='post-date-time'>
							<span class='profile-name'>" . $tuple["username"] . "</span>
							" . $tuple["post_date"] . " - " . $tuple["post_time"] . "</div>
						<div class='post-text'>". $tuple["post_text"] . " 
						</div>
						<div class='post-picture'></div>
					</div>					
				</div>";
				
				
				++$post_counter;
			}
		}
		else {
			echo "<!-- Dialog for No Posts to show -->
				<div class='noPostsDialog'><h2>No Posts to show! Create some posts with the plus button on the bottom left to get started!</h2></div>";
		}

		$conn->close();
	?>


</html>