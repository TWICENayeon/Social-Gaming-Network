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
	// // Determine picture type - profile picture or banner picture
	// $image_type = "";
	// if(isset($_POST['image_type'])) {
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
			
			$update_deselect_image_query = "UPDATE sgn_database.images
										SET currently_set = false
										WHERE owner_type = 1 AND owner_id = " . $_POST["groupID"] . " AND image_type = 0 AND currently_set = true;";
										
			// // echo $update_deselect_image_query;
			
			$conn->query($update_deselect_image_query);
			
			$check_image_in_dir = "SELECT image_name
									FROM images
									WHERE image_name = '" . $file_name . "' AND owner_id = " . $_POST["groupID"] . " AND image_type = 0 AND owner_type = 0;";
									
			echo ($conn->query($check_image_in_dir))->num_rows;
									
			if(($conn->query($check_image_in_dir))->num_rows == 0) {
				// echo "<br><br><br><br>";
				$insert_image_query = "INSERT INTO sgn_database.images
									VALUES (1, " . $_POST["groupID"] . ", 1, 0, '" . $file_name . "');";
				
				// // echo $insert_image_query . "<br><br>";
									
				$conn->query($insert_image_query);
				echo $insert_image_query;
			}
			else {
				$select_image_query = "UPDATE images
										SET currently_set = true
										WHERE owner_type = 1 AND image_type = 0 AND owner_id = " . $_POST["groupID"] . " AND image_name = '" . $file_name . "';";
						
				$conn->query($select_image_query);		


				echo "<script>alert('" . $select_image_query . "')</script>";	
					echo $select_image_query;
			}
			
		}
		
		
		// if($_POST['image_type'] == 'profile_picture') {
		  // $image_type = "0";
		// }
		// else if($_POST['image_type'] == 'banner_picture') {
		  // $image_type = "1";
		// }
		  
		  
		// // Deselect current profile/banner picture
	  
		if(isset($_POST['groupName']) && !empty($_POST['groupName'])){
			$update_group_name_query = "UPDATE groups
										SET group_name = '" . $_POST["groupName"] . "'
										WHERE group_id = " . $_POST["groupID"] . ";";
										
			echo $update_group_name_query;
										
			$conn->query($update_group_name_query);
		}	
		
		
							
		// echo "<script>alert('Hello from upload user profile picture')</script>";
		header('Location: http://localhost/sgn/dash.php');
	?>
	
	

</html>