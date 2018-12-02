<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();


// $_SESSION["page_id"] = $_POST["page_id"];
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
	$user_info_query = "SELECT *
						FROM users
						WHERE user_id = " . $_SESSION["current_user_id"] . ";";
						
	$user_info = ($conn->query($user_info_query))->fetch_assoc();
	
	
	$fetch_profile_picture_main = "SELECT image_name
									FROM images
									WHERE owner_type = 0 AND owner_id = " . $_SESSION["current_user_id"] . " AND currently_set = 1 AND image_type = 0;";

	echo "<div class='modal-header'>
						        <h5 class='profileModalUname'>Profile</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
						      <div class='modal-body'>
						        <h2 class='profileTitle' style='color:black'>" . $user_info["username"] . "</h2>
						        <div class='profileModalImage'  style='background-image: url(user_images/" . (($conn->query($fetch_profile_picture_main))->fetch_assoc())["image_name"] . ")'></div>
						        <div class='profileUserName' style='color:black'>Name:" . $user_info["first_name"] . "       " . $user_info["last_name"] . "</div>
						        <div class='profileEmail' style='color:black'>Email: " . $user_info["email"] . "</div>
						        <div class='profileDate' style='color:black'>Date joined: " . $user_info["creation_date"] . "</div>
						      </div>
							  <form action='php/upload_user_profile_picture.php' method='POST' enctype='multipart/form-data'>
						        <div class='uploadImageSection' style='color:black'>Change profile picture: <input type='file' name='profilePicture'></div>
						      <div class='modal-footer'>
						        <button type='submit' class='btn btn-primary'>Save changes</button>
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
							  </form>";


	
	
	// echo $result;

	$conn->close();
	?>


</html>