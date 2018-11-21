<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
// if(!isset($_SESSION["current_user_id"])) {
	// header("Location: http://localhost/sgn/index.php");
	// exit();
// }
$_SESSION["current_user_id"] = "1";
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
	// Article posting setting
	
	$get_post_article_privilege_query = "SELECT posts_articles
										FROM users
										WHERE user_id = " . $_SESSION["current_user_id"] . ";";		
										
	$has_privilege = (($conn->query($get_post_article_privilege_query))->fetch_assoc())["posts_articles"];

	if($has_privilege) {
		echo "You have permission to post articles.";
	}
	else {
		echo "<form action = 'update_information.php' method = 'POST'>
			 <input type = 'submit' name='request_privilege' value='REQUEST ARTICLE POSTING PRIVILEGE'>
			 <ul>
			 </ul>
				
		  </form>";
	}
?>
   <body>
      
      <form action = "" method = "POST" enctype = "multipart/form-data">
         Upload Picture:<br><input type = "file" name = "image" /> <br>
		 <input type="radio" name="image_type" value="profile_picture"> Profile Picture <br>
		 <input type="radio" name="image_type" value="banner_picture"> Banner <br>
         <input type = "submit"/>
			
         <ul>
         </ul>
			
      </form>
	  <br><br><br><br><br>
       <form action = "update_information.php" method = "POST" >
         Update user information:<br>
		 New email : <input type = "text" name = "new_email" /> <br>
		 New username : <input type="text" name="new_username" > <br>
		 New password : <input type="password" name="new_password">  <br>
         New first name : <input type="text" name="new_first_name" > <br>
		 New last name: <input type="text" name="new_last_name" > <br>
		<input type='submit' value='Update'>
		 
      </form>
			
         <ul>
         </ul>
		 
		 
			
      </form> 
   </body>

</html>