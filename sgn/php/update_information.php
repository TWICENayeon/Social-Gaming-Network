<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}


?>
<html>
Update Object Information page is under construction. <br><br><br><br><br><br><br>
<?php

	
	$conn = new mysqli("localhost", "root", "");
	

	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}

	$conn->select_db("sgn_database");
	
	
	if($_SESSION["page_type"] == 0) {
		
		
		if(isset($_POST["request_privilege"])) {
			$insert_request_query = "INSERT INTO requests 
										VALUES (" . $_SESSION["current_user_id"] . ", '" . $_SESSION["current_username"] . "');";
										
			// echo $insert_request_query;
			$conn->query($insert_request_query);
		}
		else {
			
			$update_user_information_query = "UPDATE users
												SET ";
			$first_set = false;
			if(!empty($_POST["new_email"])) {
				$update_user_information_query .= "email = '" . $_POST["new_email"] . "'";
				$first_set = true;
			}
			
			if(!empty($_POST["new_username"])) {
				
				if($first_set) {
					$update_user_information_query .= ", ";
				}
				
				$update_user_information_query .= "username = '" . $_POST["new_username"] . "'";
				$first_set = true;
			}
			if(!empty($_POST["new_password"])) {
				
				if($first_set) {
					$update_user_information_query .= ", ";
				}
				$update_user_information_query .= "password = '" . $_POST["new_password"] . "'";
				$first_set = true;
			}
			if(!empty($_POST["new_first_name"])) {
				if($first_set) {
					$update_user_information_query .= ", ";
				}
				$update_user_information_query .= "first_name = '" . $_POST["new_first_name"] . "'";
				$first_set = true;
			}
			if(!empty($_POST["new_last_name"])) {
				if($first_set) {
					$update_user_information_query .= ", ";
				}
				$update_user_information_query .= "last_name = '" . $_POST["new_last_name"] . "'";
			}
			$update_user_information_query .= " WHERE user_id = " . $_SESSION["current_user_id"] . ";"; 
			// echo $update_user_information_query;
			
			$conn->query($update_user_information_query);
			
			// Redirect back to the page
			if(ob_get_length()) {
				ob_end_clean();
			}
			
			header("Location: http://localhost/sgn/settings.php");
		}
	}
	else if($_SESSION["page_type"] == 1) {
		$update_group_information_query = "UPDATE groups
											SET ";
			$first_set = false;
			if(!empty($_POST["new_group_name"])) {
				$update_group_information_query .= "group_name = '" . $_POST["new_group_name"] . "'";
				$first_set = true;
			}
			
			if(!empty($_POST["new_group_description"])) {
				
				if($first_set) {
					$update_group_information_query .= ", ";
				}
				
				$update_group_information_query .= "group_description = '" . $_POST["new_group_description"] . "'";
				$first_set = true;
			}
			if(isset($_POST["privacy"])) {
				
				if($first_set) {
					$update_group_information_query .= ", ";
				}
				$update_group_information_query .= "group_privacy = " . (($_POST["privacy"] == "on") ? "true " : "false ");
				
			}
			$update_group_information_query .= " WHERE group_id = " . $_SESSION["page_id"] . ";"; 
			
			// echo $update_group_information_query;
			
			$conn->query($update_group_information_query);
			
			// Redirect back to the page
			if(ob_get_length()) {
				ob_end_clean();
			}
			
			header("Location: http://localhost/sgn/settings_group.php");
	}
	else if($_SESSION["page_type"] == 2) {
		$update_event_information_query = "UPDATE events
											SET ";
			$first_set = false;
			if(!empty($_POST["new_event_name"])) {
				$update_event_information_query .= "event_name = '" . $_POST["new_event_name"] . "'";
				$first_set = true;
			}
			
			if(!empty($_POST["new_event_description"])) {
				
				if($first_set) {
					$update_event_information_query .= ", ";
				}
				
				$update_event_information_query .= "event_description = '" . $_POST["new_event_description"] . "'";
				$first_set = true;
			}
			if(!empty($_POST["new_event_date"])) {
				
				if($first_set) {
					$update_event_information_query .= ", ";
				}
				
				$update_event_information_query .= "event_start_date = '" . $_POST["new_event_date"] . "'";
				$first_set = true;
			}
			if(!empty($_POST["new_event_time"])) {
				
				if($first_set) {
					$update_event_information_query .= ", ";
				}
				
				$update_event_information_query .= "event_start_time = '" . $_POST["new_event_time"] . "'";
				$first_set = true;
			}
			if(isset($_POST["privacy"])) {
				
				if($first_set) {
					$update_event_information_query .= ", ";
				}
				$update_event_information_query .= "event_privacy = " . (($_POST["privacy"] == "on") ? "true " : "false ");
				
			}
			$update_event_information_query .= " WHERE event_id = " . $_SESSION["page_id"] . ";"; 
			
			// echo $update_event_information_query;
			
			$conn->query($update_event_information_query);
			
			//Redirect back to the page
			if(ob_get_length()) {
				ob_end_clean();
			}
			
			header("Location: http://localhost/sgn/settings_event.php");
	}
	
		

?>
   

</html>