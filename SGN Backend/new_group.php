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
	
	
	// Check if the post text has text
	// If so, insert the post int the database
	if(!empty($_POST["new_group_name"])) {
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}

		echo  "<br>";
		echo "Connection successful";
		echo  "<br>";

		
		// TODO: Escape single quotes and other sensitive characters
		if(isset($_POST["new_group_privacy"])) 
		{ 
			$new_group_privacy = 1;
		} else {
			$new_group_privacy = 0;
		}
		$insert_new_group_query = "INSERT INTO sgn_database.groups (group_name, group_description, group_creation_date, group_privacy) 
								   VALUES ('" . $_POST["new_group_name"] . "', '" . $_POST["new_group_description"] . "', CURRENT_DATE(), " . $new_group_privacy . ");";


		echo $insert_new_group_query;
		$result = $conn->query($insert_new_group_query);
		
		if($result === false) {
			echo "Group insertion query failed";
			exit();
		}
		
		
		$insert_new_member_query = "INSERT INTO sgn_database.memberships
								    VALUES (" . $_SESSION["current_user_id"] . ", " . $conn->insert_id . ", 2, CURRENT_DATE(), CURRENT_TIME());";
									
		echo $insert_new_member_query;
		$result = $conn->query($insert_new_member_query);

		if($result === false) {
			echo "Membership insertion query failed";
			exit();
		}

	// Redirect back to the group page
	if(ob_get_length()) {
		ob_end_clean();
	}

	header("Location: http://localhost/sgn/my_groups.php");
	}


?>