<!DOCTYPE html>

<?php
	// Get access to the "$_SESSION" array
	session_start();	
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.php");
		exit();
	}
	
	echo "I am here!";
	// Check if the post text has text
	// If so, insert the post int the database
	
	$conn = new mysqli("localhost", "root", "");

	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}

	echo  "<br>";
	echo "Connection successful";
	echo  "<br>";

	$conn->select_db("sgn_database");
	
	if(isset($_POST["remove_upvote"]) || isset($_POST["remove_downvote"])) {
		$delete_vote_query = "DELETE FROM post_votes
								WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $_POST["post_id"] . ";";
		
		echo $delete_vote_query;
		
		$conn->query($delete_vote_query);
	}
	else {
		$value = 0;
		if(isset($_POST["upvote"])) {
			$value = 1;
		}
		else if(isset($_POST["downvote"])) {
			$value = -1;
		}
		else {
			echo "Could not find type of option for vote";
			exit();
		}
		
		$find_post_query = "SELECT *
							FROM post_votes
							WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $_POST["post_id"] . ";";
							
		echo $find_post_query;
							
		$result = $conn->query($find_post_query);
		
		if($result->num_rows == 1) {
			$update_vote_query = "UPDATE post_votes
									SET value = " . $value . "
									WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $_POST["post_id"] . ";";
									
			$conn->query($update_vote_query);
		}
		else if($result->num_rows == 0) {
			$insert_vote_query = "INSERT into post_votes
									VALUES (" . $_SESSION["current_user_id"] . ", " . $_POST["post_id"] . ", " . $value . ");";
									
			
			$conn->query($insert_vote_query);
		}
		else {
			echo "Found more than one tuples for specific vote";
			exit();
		}
	}
	//Redirect back to the page
	if(ob_get_length()) {
		ob_end_clean();
	}

	// TODO: Redirect to the page that has been posted
	// Not just to the user's page
	if($_SESSION["page_type"] === 0) {
		header("Location: http://localhost/sgn/user_page.php?page_id=" . $_SESSION["page_id"]);
	}
	else if($_SESSION["page_type"] === 1) {
		header("Location: http://localhost/sgn/group_page.php?page_id=" . $_SESSION["page_id"]);
	}
	else if($_SESSION["page_type"] === 2) {
		header("Location: http://localhost/sgn/event_page.php?page_id=" . $_SESSION["page_id"]);
	}


?>