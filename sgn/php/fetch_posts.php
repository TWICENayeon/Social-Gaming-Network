<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="../css/dash.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<link href="../jqueryUI/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<script src="../js/popper.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="../jqueryUI/jquery-ui.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>	
	<script src="../js/dash.js"></script>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
	
</head>


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
				//echo "<br> <br> " . $tuple["username"] . "<br>" . $tuple["post_date"] . "<br>" . $tuple["post_time"] . "<br>". $tuple["post_text"] . "<br>" . $vote_total .  "<br> <br>";
				
				
				echo "<div class='template-post'>					
					<div class='image-buttons-container'>						
						<div class='post-profile-image'></div>						
						<div class='post-profile-gap'></div>
						<div class='post-like-button'>													
							<i class='far fa-thumbs-up'></i>							
							2.5M
						</div>						
						<div class='post-comment-button' data-toggle='modal' data-target='#commentsModal'>							
							<i class='far fa-comments'></i>
							33
						</div>
						<!-- Comments Modal -->
						<div class='modal fade' id='commentsModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
						  <div class='modal-dialog' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title' id='exampleModalLabel'>Create Post</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
						      <div class='modal-body'>
						        <textarea class='postTextBox' placeholder='Write what's going on:' rows='6' cols='60'></textarea>
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
							" . $tuple["post_date"] . " - " . $tuple["post_time"] .  " </div>
						<div class='post-text'>" . $tuple["post_text"] . "
						</div>
					</div>					
				</div>";
				
				
				
			}
		}

		$conn->close();
	?>


</html>