<!DOCTYPE html>

<?php
	// Get access to the "$_SESSION" array
	session_start();	
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.html");
		exit();
	}
	
	// Check if the post text has text
	// If so, insert the post int the database
	if(!empty(trim($_POST["post_text"]))) {
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}

		echo  "<br>";
		echo "Connection successful";
		echo  "<br>";
		
		$conn->select_db("sgn_database");

		$parent_post_id_value = "0";
		
		if(isset($_POST["parent_post_id"])) {
			$parent_post_id_value = $_POST["parent_post_id"];
		}
		
		$post_text = $conn->real_escape_string($_POST["post_text"]);
		
		
		
		// TODO: Escape single quotes and other sensitive characters
		$insert_new_post = "INSERT INTO sgn_database.posts (parent_post_id, poster_id, wall_type, wall_owner_id, post_text, post_date, post_time, post_votes) 
							VALUES (" . $parent_post_id_value . ", " . $_SESSION["current_user_id"] . ", " . $parent_post_id_value . ", " . $_SESSION["page_id"] . ", '" . $post_text . "', CURRENT_DATE(), CURRENT_TIME(),0);";

		echo "<br><br>" . $post_text . "<br><br>";
		echo $insert_new_post;
		$result = $conn->query($insert_new_post);

		if($result === false) {
			echo "Post insertion query failed" . $conn->error;
			exit();
		}
		
		echo "<script>alert('Hello from new_post script failure')</script>";
		// // Redirect back to the page
		// if(ob_get_length()) {
			// ob_end_clean();
		// }

		// // TODO: Redirect to the page that has been posted
		// // Not just to the user's page
		// if($_SESSION["page_type"] === 0) {
			// header("Location: http://localhost/sgn/user_page.php?");
		// }
		// else if($_SESSION["page_type"] === 1) {
			// header("Location: http://localhost/sgn/group_page.php");
		// }
		// else if($_SESSION["page_type"] === 2) {
			// header("Location: http://localhost/sgn/event_page.php");
		// }
	}


?>