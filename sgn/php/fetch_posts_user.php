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
		$search_user_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time, user_id
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
				$fetch_children_posts_query = "SELECT post_id, username, post_text, post_date, post_time, post_votes, user_id
												FROM sgn_database.posts JOIN sgn_database.users
												ON posts.poster_id = users.user_id
												WHERE parent_post_id = " . $tuple["post_id"] . ";";
												
				// echo $fetch_children_posts_query . "<br><br><br><br>";
				
				$children_result = $conn->query($fetch_children_posts_query);
				
				$user_voted_main_query = "SELECT * 
											FROM post_votes
											WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . ";";
				
				
				$user_voted_value = $conn->query($user_voted_main_query)->num_rows == 1;
				
				if (!isset($vote_total)) {
					$vote_total = 0;
				}
				
				// Print Post
				//echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				$fetch_profile_picture_main = "SELECT image_name
												FROM images
												WHERE owner_type = 0 AND owner_id = " . $tuple["user_id"] . " AND currently_set = 1 AND image_type = 0;";
				
				$profile_picture_name_main = (($conn->query($fetch_profile_picture_main))->fetch_assoc())["image_name"];
												
				$has_liked_main_query = "SELECT *
								FROM post_votes
								WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $tuple["post_id"] . ";";
				
				$liked_main_value = ($conn->query($has_liked_main_query))->num_rows == 1;
				
				// Load profile picture
				echo "<div class='template-post'>					
					<div class='image-buttons-container'>			
						<div class='post-profile-image' data-toggle='modal' data-target='#dashProfileModal_" . $tuple["username"] . "' style='background-image: url(user_images/" . $profile_picture_name_main . ")'></div>	 				
						<div class='post-profile-gap'></div>
						<div class='post-like-button' onclick='likeAction(this, " . $tuple["post_id"] . ")'>													
							<i class='far fa-thumbs-up' id='thumbsUpIcon' " . ($liked_main_value ? " style='color:blue' " : "") ."></i>							
							<span id='vote_total'>" . $vote_total . " </span>
						</div>						
						<div class='post-comment-button' data-toggle='modal' data-target='#commentsModal_" . $post_counter . "'>							
							<i class='far fa-comments' id='commentsIcon'></i>
							<span id='num-replies-post_" . $tuple["post_id"] ."'>" . $children_result->num_rows . " </span>
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
							  <div class='modal-body'>
							  <div id='repliesModal_" . $tuple["post_id"] . "'>";
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
					        			<div class='commentPostUpvote'style='color:black' onclick='likeAction(this, " . $child_tuple["post_id"] . ")'>
										<i class='fa fa-hand-o-up' aria-hidden='false'  " . ($liked_reply_value ? " style='color:blue' " : "") ."></i>			
										<span id='vote_total'>" . $reply_vote_total . " </span>
										</div>
					        		</div>
					        	</div>";
					
				}
				echo "</div>
						<textarea class='postTextBox' id='replyTextBox_" . $tuple["post_id"] . "' placeholder='Write what's going on:' rows='6' cols='60'></textarea>
						      </div>
						      <div class='modal-footer'>
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						        <button type='button' class='btn btn-primary' onclick='createPost(" . $tuple["post_id"] . ")'>Post!</button>
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
					</div>					
				</div>";
				
				
				++$post_counter;
			}
			
			// Print out of profile modals for all the posters on the wall
			
			$all_posters_info_query = "SELECT DISTINCT(poster_id), username, email, first_name, last_name, creation_date, user_id
										FROM posts INNER JOIN users
										ON sgn_database.posts.poster_id = sgn_database.users.user_id
										WHERE wall_owner_id = " . $_SESSION["current_user_id"] . " AND wall_type = 0;";
										
			$poster_result = $conn->query($all_posters_info_query);
			
			while($user_info = $poster_result->fetch_assoc()) {
				$fetch_profile_picture_main = "SELECT image_name
												FROM images
												WHERE owner_type = 0 AND owner_id = " . $user_info["user_id"] . " AND currently_set = 1 AND image_type = 0;";
				
				echo "
				<div class='modal fade' id='dashProfileModal_" . $user_info["username"] ."' tabindex='-1' role='dialog'>
						  <div class='modal-dialog' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='profileModalUname'>Profile</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
						      <div class='modal-body'>
						        <h2 class='profileTitle' style='color:black'>" . $user_info["username"] . "</h2>
						        <div class='profileModalImage'  style='background-image: url(user_images/" . (($conn->query($fetch_profile_picture_main))->fetch_assoc())["image_name"] . ")'></div>
						        <div class='profileUserName' style='color:black'>Name:" . $user_info["first_name"] . "       " . $user_info["last_name"] . "</div>
						        <div class='profileEmail' style='color:black'>Email: " . $user_info["email"] . "</div>
						        <div class='profileDate' style='color:black'>Date joined: " . $user_info["creation_date"] . "</div>
						      </div>";
				if($user_info["user_id"] == $_SESSION["current_user_id"]) {
					echo "<form action='php/upload_user_profile_picture.php' method='POST' enctype='multipart/form-data'>
						        <div class='uploadImageSection' style='color:black'>Change profile picture: <input type='file' name='profilePicture'></div>
						      <div class='modal-footer'>
						        <button type='submit' class='btn btn-primary'>Save changes</button>
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
							  </form>";
				}
						    echo "</div>
						  </div>
						</div>";
			}
		}
		else {
			echo $_SESSION["page_id"] . "<br><br><br>";
			echo $search_user_wall_posts;
			echo "<!-- Dialog for No Posts to show -->
				<div class='noPostsDialog'><h2>No Posts to show! Create some posts with the plus button on the bottom left to get started!</h2></div>";
		}

		$conn->close();
	?>


</html>