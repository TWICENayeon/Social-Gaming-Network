<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.html");
	exit();
}
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


<html>
<?php
	// Insert new group
	$new_group_query = "INSERT INTO groups (group_name, group_description, group_creation_date, group_privacy)
					VALUES ('" . $_POST["groupName"] . "', '', CURRENT_DATE(), '0');";
					
	$conn->query($new_group_query);
	
	// Get id of group
	$new_group_id = $conn->insert_id;
	
	// Insert self as new member
	$new_member_query = "INSERT INTO memberships
							VALUES (" . $_SESSION["current_user_id"] . ", " . $new_group_id . ", 1, CURRENT_DATE(), CURRENT_TIME())";
							
	$conn->query($new_member_query);
	
	
					



	// Set group profile picture
		if(isset($_FILES['groupPicture']) && !empty($_FILES['groupPicture']['name'])){
			$errors= array();
			$file_name = $_FILES['groupPicture']['name'];
			$file_size = $_FILES['groupPicture']['size'];
			$file_tmp = $_FILES['groupPicture']['tmp_name'];
			$file_component_array = explode('.',$_FILES['groupPicture']['name']);
			$file_ext=strtolower(end($file_component_array));
			  
			$expensions= array("jpeg","jpg","png", "gif");
			  
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="extension not allowed, please choose a JPEG or PNG file.";
			}
			  
			if($file_size > 2097152) {
				$errors[]='File size must be excately 2 MB';
			}
			  
			if(empty($errors)==true) {
				move_uploaded_file($file_tmp,"../user_images/".$file_name);
			}else{
				print_r($errors);
			}	
			
			$new_group_picture = "INSERT INTO images
								VALUES (1, " . $new_group_id . ", 1, 0, '" . $file_name . "');";
								
			$conn->query($new_group_picture);
			
		}
		
		
							
		// echo "<script>alert('Hello from upload user profile picture')</script>";
		header('Location: http://localhost/sgn/dash.php');
	?>
	
	

</html>