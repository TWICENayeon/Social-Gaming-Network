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


<?php
// Get number of unresolved notifications
	$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
												FROM notifications
												WHERE recipient_id = " . $_SESSION["current_user_id"] . " and resolved_status = false;";
	
	// echo $fetch_num_unresolved_notifications_query;
												
	$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];



?>

<html>
<?php
	// // Determine picture type - profile picture or banner picture
	// $image_type = "";
	// if(isset($_POST['image_type'])) {
		if(isset($_FILES['bannerImage'])){
			$errors= array();
			$file_name = $_FILES['bannerImage']['name'];
			$file_size = $_FILES['bannerImage']['size'];
			$file_tmp = $_FILES['bannerImage']['tmp_name'];
			$file_component_array = explode('.',$_FILES['bannerImage']['name']);
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
			
		}
		else {
			echo "Complete failure";
			header('Location: http://localhost/sgn/dash.php');
		}
		
		
		// if($_POST['image_type'] == 'profile_picture') {
		  // $image_type = "0";
		// }
		// else if($_POST['image_type'] == 'banner_picture') {
		  // $image_type = "1";
		// }
		  
		  
		// // Deselect current profile/banner picture
	  
		$update_deselect_image_query = "UPDATE sgn_database.images
										SET currently_set = false
										WHERE owner_type = 0 AND owner_id = " . $_SESSION["current_user_id"] . " AND image_type = 1 AND currently_set = true;";
										
		// // echo $update_deselect_image_query;
		
		$conn->query($update_deselect_image_query);
		
		// echo "<br><br><br><br>";
		$insert_image_query = "INSERT INTO sgn_database.images
							VALUES (0, " . $_SESSION["current_user_id"] . ", 1, 1, '" . $file_name . "');";
		
		// // echo $insert_image_query . "<br><br>";
							
		$conn->query($insert_image_query);
							
		// // echo $insert_image_query; 
		header('Location: http://localhost/sgn/dash.php');
	// }
	?>
	
	

</html>