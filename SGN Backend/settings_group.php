<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

if($_SESSION["page_type"] != 1) {
	header("Location: http://localhost/sgn/user_page.php?page_id=" . $_SESSION["current_user_id"]);
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




	
	

<!-- Banner Start -->
<a href="http://localhost/sgn/user_page.php?page_id=<?php echo $_SESSION["current_user_id"]; ?>"> SGN </a> <br>
<form action="search_results.php" method="get">
	<input type="text" name = "search_term" placeholder="Search. . ." >
	<input type="submit" value="Search">
</form>
<br>
<a href="http://localhost/sgn/my_groups.php"> My Groups </a> <br>
<a href="http://localhost/sgn/my_events.php"> My Events </a> <br>
<a href="http://localhost/sgn/my_friends.php"> My Friends </a> <br>
<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <?php if(intval($num_unresolved_string) > 0) {echo "[" . $num_unresolved_string . "]";}?> <br>
<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
<a href="http://localhost/sgn/settings.php"> User settings </a> <br>

<br>
<br>

<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
<html>
User's settings page is under construction. <br><br><br><br><br><br><br>
<?php

	
	  
	  // Determine picture type - profile picture or banner picture
	  $image_type = "";
	  if(isset($_POST['image_type'])) {
		   if(isset($_FILES['image'])){
			  $errors= array();
			  $file_name = $_FILES['image']['name'];
			  $file_size = $_FILES['image']['size'];
			  $file_tmp = $_FILES['image']['tmp_name'];
			  $file_type = $_FILES['image']['type'];
			  $file_component_array = explode('.',$_FILES['image']['name']);
			  $file_ext=strtolower(end($file_component_array));
			  
			  $expensions= array("jpeg","jpg","png");
			  
			  if(in_array($file_ext,$expensions)=== false){
				 $errors[]="extension not allowed, please choose a JPEG or PNG file.";
			  }
			  
			  if($file_size > 2097152) {
				 $errors[]='File size must be excately 2 MB';
			  }
			  
			  if(empty($errors)==true) {
				 move_uploaded_file($file_tmp,"images/".$file_name);
			  }else{
				 print_r($errors);
			  }
		  if($_POST['image_type'] == 'profile_picture') {
			  $image_type = "0";
		  }
		  else if($_POST['image_type'] == 'banner_picture') {
			  $image_type = "1";
		  }
		  
		  
		  // Deselect current profile/banner picture
		  
		  $update_deselect_image_query = "UPDATE sgn_database.images
											SET currently_set = false
											WHERE owner_type = 1 AND owner_id = " . $_SESSION["page_id"] . " AND image_type = " . $image_type . " AND currently_set = true;";
											
			// echo $update_deselect_image_query;
			
			$conn->query($update_deselect_image_query);
			
			echo "<br><br><br><br>";
		  $insert_image_query = "INSERT INTO sgn_database.images
								VALUES (1, " . $_SESSION["page_id"] . ", 1," . $image_type . ", '" . $file_name . "');";
			
			// echo $insert_image_query . "<br><br>";
								
			$conn->query($insert_image_query);
								
			// echo $insert_image_query; 
	  }
		else {
			echo "Did not select picture type";
		}
   }
?>
   <body>
      
      <form action = "" method = "POST" enctype = "multipart/form-data">
         Upload Picture:<br><input type = "file" name = "image" /> <br>
		 <input type="radio" name="image_type" value="profile_picture"> Group Picture <br>
		 <input type="radio" name="image_type" value="banner_picture"> Banner <br>
         <input type = "submit"/>
			
         <ul>
         </ul>
			
      </form>
	  
	  <br><br><br><br><br><br><br><br><br>
	  
	  
	<?php
		$check_group_privacy_query = "SELECT group_privacy
										FROM groups
										WHERE group_id = " . $_SESSION["page_id"] . ";";
										
		// echo $check_group_privacy_query;
										
		$privacy_value = (($conn->query($check_group_privacy_query))->fetch_assoc())["group_privacy"];
	
	?>
   
   <form action = "update_information.php" method = "POST" >
         Update Group information:<br>
		 New group name : <input type = "text" name = "new_group_name" /> <br>
		 New group description : <input type="text" name="new_group_description" > <br>
		 New privacy setting : <br>
		 <input type="radio" name="privacy" value="on" <?php if($privacy_value) {echo "checked='checked'";} ?>> On  <br>
		 <input type="radio" name="privacy" value="off" <?php if(!$privacy_value) {echo "checked='checked'";} ?>> Off <br>
		<input type='submit' value='Update'>
		 
      </form>
	  
	 </body>

</html>