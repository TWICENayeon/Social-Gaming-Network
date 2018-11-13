<!DOCTYPE html>

<?php
	// Gain access to session array
	session_start();
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.php");
		exit();
	}
	
	if(isset($_GET["page_id"])) {
		$_SESSION["page_id"] = $_GET["page_id"];
	}
	
	if(isset($_POST["page_id"])) {
		$_SESSION["page_id"] = $_POST["page_id"];
	}
	$_SESSION["page_type"] = 3;
?>

<head>
  <link rel="stylesheet" href="post_link.css">
</head>


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
	
	<?php 
		$debug = false;
		
		
		
		// Manage chat invite
		if(!empty($_POST['invited_username'])) {
			$search_valid_user = "SELECT user_id 
									  FROM sgn_database.users 
									  WHERE username = '" .  $_POST['invited_username'] . "';";
			
										  
			$tuple = ($conn->query($search_valid_user))->fetch_assoc();
			if(!empty($tuple["user_id"])) {
				echo $tuple["user_id"] . "<br><br>";
				//echo "invited user found";
				$search_in_chat = "SELECT chat_member_id 
											  FROM sgn_database.chat_group_members 
											  WHERE chat_member_id = " .  $tuple['user_id'] . " AND chat_id = " . $_POST["chat_group_id"] . ";";
											  
										  
				if(empty(($conn->query($search_in_chat))->fetch_assoc()["chat_member_id"])) {
					
					// Get chat name
					$search_in_chat = "SELECT chat_name 
											  FROM sgn_database.chat_groups 
											  WHERE chat_id = " . $_POST["chat_group_id"] . ";";
											  
					$esport_chat_name = (($conn->query($search_in_chat))->fetch_assoc())["chat_name"];
					
																	
					$insert_esport_chat_invitation_notification = "INSERT into sgn_database.notifications (notification_type, invitation_to_id, recipient_id, message, resolved_status, date_created, time_created)
															VALUES(1, " . $_POST["chat_group_id"] . "," . $tuple['user_id'] . ", 'COME JOIN ESPORT CHAT -" . $conn->real_escape_string($esport_chat_name) . "-' , 0, CURRENT_DATE(), CURRENT_TIME());";
					
					if ( ($conn->query($insert_esport_chat_invitation_notification)) === TRUE) {
							echo "Notification has been properly sent.";
					} 
					else {
						echo $insert_esport_chat_invitation_notification;
						echo "Error: " . $insert_esport_chat_invitation_notification . "<br>" . $conn->error;
					}
				}
				else {
					echo $search_in_chat;
					echo "Specified user is already in the chat";
					exit();
				}
			}
			else {
				echo "Specified username is invalid";
				exit();
			}
			
		}
		
		// Get esports data
		$fetch_esports_data =  "SELECT esport_name, esport_stream_name
									FROM sgn_database.esports
									WHERE esport_id = " . $_SESSION["page_id"] .";";
		
		$result = ($conn->query($fetch_esports_data)->fetch_assoc());
		
		
		if(isset($_POST["create_flag"])) {
			echo "Create flag prompt received <br> <br> <br> <br> <br> <br>";
			$add_chat_id = "INSERT into sgn_database.chat_groups (chat_name, esport_id)
							VALUE ( '" . $_SESSION["current_username"] . "''s " . $result["esport_name"] . " Chat Room', " . $_SESSION["page_id"] . " );";
							
			
			if(!$debug) {
			
				$conn->query($add_chat_id);
			
			}
			else {
							
				echo $add_chat_id;
			}
			
			$chat_id = $conn->insert_id;
			
			$add_chat_member_id = "INSERT into sgn_database.chat_group_members
										VALUE ( " . $chat_id . ", " . $_SESSION["current_user_id"] . " );";
										
			
			
			if(!$debug) {
			
				$conn->query($add_chat_member_id);
			
			}
			else {
				echo $add_chat_member_id;
			}
			
			
		}
		
		
	?>
	

	
	<?php 
		echo "<u> " . $result["esport_name"] . "</u>'s esports page <br> <br> <br> <br>";
		
	?>
	
	 <!-- Add a placeholder for the Twitch embed -->
    <div id="twitch-embed"></div>

    <!-- Load the Twitch embed script -->
    <script src="https://embed.twitch.tv/embed/v1.js"></script>

    <!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
    <script type="text/javascript">
      new Twitch.Embed("twitch-embed", {
        width: 854,
        height: 480,
		layout: "video",
        channel: <?php echo "\"" . $result["esport_stream_name"] . "\"" ?>
      });
    </script>
	<br>
	<br>
	<br>
	<?php
		// PROCESS ARTICLE SUBMISSION SECTION
		
		if(isset($_FILES['article'])){
			  $errors= array();
			  $file_name = $_FILES['article']['name'];
			  $file_size = $_FILES['article']['size'];
			  $file_tmp = $_FILES['article']['tmp_name'];
			  $file_type = $_FILES['article']['type'];
			  $file_component_array = explode('.',$_FILES['article']['name']);
			  $file_ext=strtolower(end($file_component_array));
			  
			  $expensions= array("txt","docx","html");
			  
			  if(in_array($file_ext,$expensions)=== false){
				 $errors[]="extension not allowed, please choose a TXT or DOCX file.";
			  }
			  
			  if($file_size > 2097152) {
				 $errors[]='File size must be excately 2 MB';
			  }
			  
			  if(empty($errors)==true) {
				 move_uploaded_file($file_tmp,"articles/".$file_name);
			  }else{
				 print_r($errors);
			  }
			  
			$insert_article = "INSERT INTO esport_articles
								VALUES (" . $_SESSION["page_id"] . ", '" . $file_name ."');";
			
			echo $insert_article;
			$conn->query($insert_article);
											
		}
					
		$get_post_article_privilege_query = "SELECT posts_articles
											FROM users
											WHERE user_id = " . $_SESSION["current_user_id"] . ";";							
		// echo $get_post_article_privilege_query	;
											
		$has_privilege = (($conn->query($get_post_article_privilege_query))->fetch_assoc())["posts_articles"];
	
		if($has_privilege) {
			echo "<form action = 'new_article.php' method = 'POST'>
				 Upload Article:<br>
				 Title:<input type = 'text' name = 'title' /> <br>
				 Body:<br><textarea name = 'body' rows='10' cols='30'> </textarea> <br>
				 <input type = 'submit'/>
				 <ul>
				 </ul>
					
			  </form>";
		}
		else {
			echo "<form action = '' method = 'POST' enctype = 'multipart/form-data'>
				 <input type = 'submit' name='request_privilege' value='REQUEST ARTICLE POSTING PRIVILEGE'>
				 <ul>
				 </ul>
					
			  </form>";
		}
	?>
	<br><br><br><br><br><br><br>
	<?php
		$get_esport_chat_id = "SELECT chat_groups.chat_id
								FROM sgn_database.chat_groups INNER JOIN sgn_database.chat_group_members
								ON chat_groups.chat_id = chat_group_members.chat_id
								WHERE chat_member_id = " . $_SESSION["current_user_id"] . " and esport_id = " . $_SESSION["page_id"] . ";";
								
	
		$esport_chat_id_value = (($conn->query($get_esport_chat_id))->fetch_assoc())["chat_id"];
		
		if(isset($esport_chat_id_value)) {
			echo "<form action='chat_room_page.php' method='post'>
						  <input type='hidden' name='chat_room_id' value=" . $esport_chat_id_value . ">
						  <input type='submit' value='Chat'>
				</form> <br><br><br>";
				
				
			echo "<br><br><br>
				<form action='esport_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
					Invite an user to esport chat: <input type='text' name = 'invited_username' > <br>
					<input type='hidden' name=chat_group_id value='" . $esport_chat_id_value . "'>
					<input type='submit' value='Invite'>
				</form>";
		}
		else {
	
			echo "<form action='esport_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
					<input type='hidden' name='create_flag' value='true'>
					Create a chatroom: <input type='submit' value='Chat'>
				</form> <br><br><br>";
		}
	
	?>
	<br><br><br><br>
	Articles: 
	<?php
		$get_articles_query = "SELECT article_id, article_title
								FROM esport_articles
								WHERE esport_id = " . $_SESSION["page_id"] . ";";
								
		$result = $conn->query($get_articles_query);
		
		while($tuple = $result->fetch_assoc()) {
			// echo "<br> <br> <a href='http://localhost/sgn/esport_article.php?page_id=" . $tuple["article_id"] . "'>" . $tuple["article_title"] . " </a> <br>";
			echo "<form method='post' action='esport_article.php' >
				  <input type='hidden' name='page_id' value='" . $tuple["article_id"]. "'>
				  <button type='submit' name='submit_param' value='submit_value' class='link-button'> <br> <br>"
					. $tuple["article_title"] . 
				  "<br></button>
				</form>";
			echo "<br><br>";
		}
	?>

</html>