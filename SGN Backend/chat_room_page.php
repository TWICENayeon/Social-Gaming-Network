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
	
	$_SESSION["page_id"] = $_POST["chat_room_id"];
	$_SESSION["page_type"] = 5;		// Chat page 
?>



<html>
	
	<body onload=refreshMessages()>

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
	<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	
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
		$chat_room_id = $_POST["chat_room_id"];
	
		$debug = false;
	
		
		$fetch_chat_room_name_query = "SELECT chat_name
									FROM sgn_database.chat_groups
									WHERE chat_id = " . $chat_room_id . ";";
		
		$chat_room_name = (($conn->query($fetch_chat_room_name_query))->fetch_assoc())["chat_name"];
		
		echo "[[[" . $chat_room_name . "]]]<br><br><br><br>";
		
		echo "Chat Members <br><br><br>";
		
		
		$fetch_chat_members_username_query = "SELECT username 
												FROM `chat_group_members` INNER JOIN users 
												ON chat_member_id = user_id 
												WHERE chat_id = " . $chat_room_id . ";";
												
		$chat_members_username_result = $conn->query($fetch_chat_members_username_query);
		
		while($username_tuple = $chat_members_username_result->fetch_assoc()) {
			echo $username_tuple["username"] . "<br>";
		}
		// // Check if this chat is for an esport
		// $check_esport_chat_query = "SELECT esport_id 
									// FROM chat_groups
									// WHERE chat_id = " . $_SESSION["page_id"] . ";";
									
		// if((($conn->query($check_esport_chat_query))->fetch_assoc())["esport_id"]) {
			// echo "<br><br><br>
			// <form action='chat_room_page.php?page_id=" . $_SESSION["page_id"] . "' method='post'>
				// Invite an user: <input type='text' name = 'invited_username' > <br>
				// <input type='submit' value='Invite'>
			// </form>";
		// }
		
		// $get_chat_messages_query = "SELECT chat_writer_id, chat_write_date, chat_write_time, chat_message
											// FROM sgn_database.chat_group_messages
											// WHERE chat_id = " . $chat_room_id . ";";
											
		// if(!$debug) {
			// $messages_result = $conn->query($get_chat_messages_query);
			// while($row = $messages_result->fetch_assoc()) {
					// $get_username_query = "SELECT username
											// FROM sgn_database.users
											// WHERE user_id = " . $row["chat_writer_id"] . ";";
					// $username = (($conn->query($get_username_query))->fetch_assoc())["username"];
					// echo "<u>" . $username . "</u><br>";
					// echo $row["chat_write_date"] . "  " . $row["chat_write_time"] . "<br><br>";
					// echo $row["chat_message"] . "<br><br><br>";
			// }
		// }
		
		// $get_current_username_query = "SELECT username
										// FROM sgn_database.users
										// WHERE user_id = " . $_SESSION["current_user_id"] . ";";
										
		// $current_username = (($conn->query($get_current_username_query))->fetch_assoc())["username"];
		
		// if(isset($_POST["friend_id"])) {
			// $get_chat_id_query = "SELECT chat_id, active
								// FROM sgn_database.friendships
								// WHERE (friend_id_1 = " . $_POST["friend_id"] . " AND friend_id_2 = " . $_SESSION["current_user_id"] .  " ) OR  
								// (friend_id_1 = " . $_SESSION["current_user_id"] . " AND friend_id_2 = " . $_POST["friend_id"] . ");";
								
			// $chat_id_tuple = ($conn->query($get_chat_id_query))->fetch_assoc();
			
			
			// if(!$chat_id_tuple["active"]) {
				// $_SESSION["page_id"] = $_POST["friend_id"];
				// header("Location: http://localhost/sgn/user_page.php?page_id=" . $_POST["friend_id"]);
			// }
			// else {
				// $_SESSION["page_id"] = $chat_id_tuple["chat_id"];
				
				// $get_friend_username_query = "SELECT username
										// FROM sgn_database.users
										// WHERE user_id = " . $_POST["friend_id"] . ";";
										
				// $friend_username = (($conn->query($get_friend_username_query))->fetch_assoc())["username"];
				
				// // echo "<br><br> Friend username query: " . $get_friend_username_query . "<br><br>";
				// // echo "<br><br> Friend username get: " . $friend_username . "<br><br>";
				
				// $get_chat_messages_query = "SELECT chat_writer_id, chat_write_date, chat_write_time, chat_message
											// FROM sgn_database.chat_group_messages
											// WHERE chat_id = " . $chat_id_tuple["chat_id"] . ";";
				
				// // echo $get_chat_messages_query;
							
				// $messages_result = $conn->query($get_chat_messages_query);
				
				
				// while($row = $messages_result->fetch_assoc()) {
					// if($row["chat_writer_id"] == $_SESSION["current_user_id"]) {
						// echo "<u>" . $current_username . "</u>:<br>";
						
						// // echo $_SESSION["current_user_id"];
						
						// // echo "<br><br>";
						
						// // echo $row["chat_writer_id"];
						
						// // echo "<br><br>";
					// }
					// else {
						
						// echo "<u>" . $friend_username . "</u>:<br>";
						
						// // echo $get_friend_username_query . "<br>";
						
						// // echo $_POST["friend_id"] . "<br>";
					// }
					// echo $row["chat_write_date"] . "  " . $row["chat_write_time"] . "<br><br>";
					// echo $row["chat_message"] . "<br><br><br>";
				// }
			// }
		// }
		
	?>
	
	<div id="chatMessages"></div>
	<!-- Implement message refresh -->
	<!-- TODO REMINDER: Implement sending messages with AJAX so that the page does not need to be refreshed 	 -->
	<script src="https://code.jquery.com/jquery-2.2.4.js" ></script>
	
	<form id = "insertform" action="chat_room_insert_message.php" title="" method="post">
	  Message:<br>
	  <input type="text" id="new_message" name="new_message" value="">
	  <br>
	  <input type="hidden" id="chat_id" name="chat_id" value=<?php echo $_SESSION["page_id"] ?>>
	  <input type="hidden" id="writer_id" name="writer_id" value=<?php echo $_SESSION["current_user_id"] ?>>
	  <input type="submit" value="Submit">
	</form> 
	
	
	<script type='text/javascript'>
		/* attach a submit handler to the form */
		$("#insertform").submit(function(event) {

		  /* stop form from submitting normally */
		  event.preventDefault();

		  /* get the action attribute from the <form action=""> element */
		  var $form = $( this ),
			  url = $form.attr( 'action' );
		  /* Send the data using post with element id new_message, chat_id, writer_id*/
		  var posting = $.post( url, { new_message: $('#new_message').val(), chat_id: $('#chat_id').val(), writer_id: $('#writer_id').val() } );			
		$( '#insertform' ).each(function(){
			this.reset();
		})
		});
	</script>
	
	<script>
		function 
	
	</script>
	
	<script>
		function refreshMessages() {
			setInterval(function() {
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("chatMessages").innerHTML=this.responseText;
			}
		  }
		  xmlhttp.open("GET","chat_room_show_messages.php?chat_room_id="+<?php echo $_SESSION["page_id"] ?>,true);
		  xmlhttp.send();
		}, 500);
			// setInterval(function() {alert("REFRESH!");}, 1000);
		}
	</script>
	
	</body>
</html>