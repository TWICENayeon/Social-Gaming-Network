<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}
	
	// Connect to the database
	$conn = new mysqli("localhost", "root", "");

	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}
	
	$conn->select_db("sgn_database");
	
	$fetch_banner_picture_name_query = "SELECT image_name
											FROM images 
											WHERE owner_type = 0 AND owner_id = " . $_SESSION["current_user_id"] . " AND currently_set = true AND image_type = 1;" ;
											
	// echo $fetch_banner_picture_name_query;
	
	$banner_img_name = (($conn->query($fetch_banner_picture_name_query))->fetch_assoc())["image_name"];
	
	
	// echo "images/" . $banner_img_name;
	
	
	if(isset($banner_img_name)) {
		//echo "<img src='images/" . $banner_img_name . "' alt='icon' style='width:1000px;height:600px;'>";
		echo "url('user_images/" . $banner_img_name . "')";
	}
	else {
		echo "url('user_images/sgn_banner.png')";
	}

?>