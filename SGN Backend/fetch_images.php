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
User Profile Picture. <br><br><br><br><br><br><br>
<?php
	
	  
	$fetch_profile_picture_name_query = "SELECT image_name
											FROM images 
											WHERE owner_type = " . $_SESSION["page_type"] . " AND owner_id = " . $_SESSION["page_id"] . " AND currently_set = true AND image_type = 0;" ;
											
	// echo $fetch_profile_picture_name_query;
	
	$profile_img_name = (($conn->query($fetch_profile_picture_name_query))->fetch_assoc())["image_name"];
	// echo "images/" . $profile_img_name;
	if(isset($profile_img_name)) {
		echo "<img src='images/" . $profile_img_name . "' alt='icon' style='width:100px;height:120px;'>";
	}
	else {
		echo "No profile image set yet";
	}
?>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
User Banner Picture. <br><br><br><br><br><br><br>
<?php
	$fetch_banner_picture_name_query = "SELECT image_name
											FROM images 
											WHERE owner_type = " . $_SESSION["page_type"] . " AND owner_id = " . $_SESSION["page_id"] . " AND currently_set = true AND image_type = 1;" ;
											
	// echo $fetch_banner_picture_name_query;
	
	$banner_img_name = (($conn->query($fetch_banner_picture_name_query))->fetch_assoc())["image_name"];
	
	
	// echo "images/" . $banner_img_name;
	
	
	if(isset($banner_img_name)) {
		echo "<img src='images/" . $banner_img_name . "' alt='icon' style='width:1000px;height:600px;'>";
	}
	else {
		echo "No banner image set yet";
	}

?>


</html>