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
	
	$debug = true;
	
	
	// Redirect back to the group page
	if(ob_get_length()) {
		ob_end_clean();
	}

	header("Location: http://localhost/sgn/my_groups.php");
	}


?>