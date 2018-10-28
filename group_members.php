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
	
	$_SESSION["page_type"] = 1;
?>


	
<html>
	
	<?php 
	// Connect to the database
		$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		// Fetch the posts on the current wall
		$search_group_name =  "SELECT group_name
									FROM sgn_database.groups
									WHERE group_id = " . $_SESSION["page_id"] .";";
										
		
		$result = ($conn->query($search_group_name)->fetch_assoc());
		
		
	?>
	
	<?php
		if(isset($_POST["promote"])) {
			$promote_query = "UPDATE sgn_database.memberships
							  SET membership_role = 1
							  WHERE member_id = " . $_GET["member_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
							  // echo $promote_query;
			
			if($conn->query($promote_query) === false) {
				echo "Failed to promote member";
			}
		}
		if(isset($_POST["demote"])) {
			$demote_query = "UPDATE sgn_database.memberships
							  SET membership_role = 0
							  WHERE member_id = " . $_GET["member_id"]. " AND of_group_id = " . $_SESSION["page_id"] . ";";
							  
							  // echo $demote_query;
			
			if($conn->query($demote_query) === false) {
				echo "Failed to promote member";
			}
		}
		if(isset($_POST["expel"])) {
			$expel_query = "DELETE FROM sgn_database.memberships
							  WHERE member_id = " . $_GET["member_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
			// echo $expel_query;
			if($conn->query($expel_query) === false) {
				echo "Failed to expel member";
			}
		}
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
	<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <br>
	<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
	<br>
	<br>
	
	<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->
	
	<?php 
		echo "<u> " . $result["group_name"] . "</u>'s members <br> <br> <br> <br>";
		$search_member_role_query = "SELECT membership_role
									 FROM sgn_database.memberships
									 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_SESSION["page_id"] . ";";
		
		
		$result = $conn->query($search_member_role_query);
		
		// echo $_SESSION["current_user_id"] . "<br> <br> <br>";
		// echo $_GET["page_id"] . "<br> <br> <br>";
		
		
		if($result->num_rows == 1) {
			$current_user_tuple = $result->fetch_assoc();
			//echo $tuple["membership_role"] . "<br> <br> <br>";
			echo "Welcome ";
			if($current_user_tuple["membership_role"] == 2) {
				echo "Founder ";
			}
			else if($current_user_tuple["membership_role"] == 1) {
				echo "Admin ";
			}
			else if($current_user_tuple["membership_role"] == 0) {
				echo "Member ";
			}
			echo "<u>" . $_SESSION["current_username"] . "</u> <br> <br>";
		}
	?>
	
	<?php
		// Retrieve all the members of the group
		$group_members_query =  "SELECT username, membership_role, user_id
									FROM sgn_database.memberships JOIN sgn_database.users
									ON member_id = user_id
									WHERE of_group_id = " . $_SESSION["page_id"] . "
									ORDER BY username ASC";
		
		$result = $conn->query($group_members_query);
		
		
		
		// TODO: Check the logic here - Takes the first tuple of all the members
		if($result->num_rows > 0) {
			echo "<br> <br>";
			while($tuple = $result->fetch_assoc()) {
				if($tuple["membership_role"] == 2) {
					echo "Founder ";
				}
				else if($tuple["membership_role"] == 1) {
					echo "Admin ";
				}
				else if($tuple["membership_role"] == 0) {
					echo "Member ";
				}
				echo  $tuple["username"] . "<br>";
				
				if($current_user_tuple["membership_role"] >= 1 && $_SESSION["current_user_id"] != $tuple["user_id"] && $tuple["membership_role"] != 2) {
				
					if($tuple["membership_role"] == 0) {
						echo "<form action='group_members.php?page_id=" . $_SESSION["page_id"] . "&member_id=" . $tuple["user_id"] ."' method='post'>
							<input type='submit' name='promote' value='Promote to Admin'>
						</form>";
					}
					
					if($tuple["membership_role"] == 1) {
						echo "<form action='group_members.php?page_id=" . $_SESSION["page_id"] . "&member_id=" . $tuple["user_id"] . "' method='post'>
							<input type='submit' name='demote' value='Demote from Admin'>
						</form>";
					}
					echo "<form action='group_members.php?page_id=" . $_SESSION["page_id"] . "&member_id=" . $tuple["user_id"] . "' method='post'>
						<input type='submit' name='expel' value='Expel'>
					</form>";
				}
			
				echo "<br> <br>";	
			}
			
		}

		$conn->close();
	?>
	
	
	

</html>