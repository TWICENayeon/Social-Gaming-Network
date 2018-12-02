<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	echo "<script>alert('Hello from update_information_user script failure')</script>";
	exit();
}


?>
<script> 
<?php
	
	$conn = new mysqli("localhost", "root", "");
	

	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}

	$conn->select_db("sgn_database");
	
	
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
		// if(ob_get_length()) {
			// ob_end_clean();
		// }
		
		// header("Location: http://localhost/sgn/settings.php");
	}
	

?> 	