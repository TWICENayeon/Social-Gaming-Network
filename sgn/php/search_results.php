<!DOCTYPE html>
<?php
// Allows access to the session array
session_start();

// Check if there is a user signed in_array
// If not, redirect to index page
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}
?>
<html>
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
		
		
		$search_users =  "SELECT username, user_id
						  FROM sgn_database.users
						  WHERE username LIKE '%" . $_GET["search_term"]. "%';";
		
		$users_result = $conn->query($search_users);
		
		
		
?>
<?php
		
		$search_groups =  "SELECT group_id, group_name
						  FROM sgn_database.groups
						  WHERE group_name LIKE '%" . $_GET["search_term"]. "%' AND group_privacy = 0
						  UNION
						  SELECT group_id, group_name
						  FROM sgn_database.groups JOIN sgn_database.memberships
						  ON groups.group_id = memberships.of_group_id
						  WHERE group_name LIKE '%" . $_GET["search_term"]. "%' AND group_privacy = 1 AND member_id = " . $_SESSION["current_user_id"] . ";";
		
		$groups_result = $conn->query($search_groups);
		
		
		
		
		// $conn->close();
		
		
		// if($result->num_rows > 0) {
			// while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br> <a href='http://localhost/sgn/group_page.php?page_id=" . $tuple["group_id"] . "'>" . $tuple["group_name"] . " </a> <br> <br>";
			// }
		// }
		
?>
<?php
	// $conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		//TODO: Show only events that are public or private to current user's group
		
		$search_events =  "SELECT event_id, event_name, event_start_date, event_start_time
							FROM sgn_database.group_events  JOIN sgn_database.events JOIN sgn_database.memberships
							ON `group_events`.`hosted_event_id` = `events`.`event_id` AND `group_events`.`hosting_group_id` = `memberships`.`of_group_id`
							WHERE  member_id = " . $_SESSION["current_user_id"] . " AND event_privacy = 1 AND event_name LIKE '%" . $_GET["search_term"]. "%'" .
							" UNION
							SELECT event_id, event_name, event_start_date, event_start_time
							FROM  sgn_database.events
							WHERE  event_privacy = 0 AND event_name LIKE '%" . $_GET["search_term"]. "%' 
							ORDER BY event_start_date, event_start_time ASC;";
		
		$events_result = $conn->query($search_events);
		
		
		// if($result->num_rows > 0) {
			// while($tuple = $result->fetch_assoc()) {
				// echo "<br> <br> <a href='http://localhost/sgn/event_page.php?page_id=" . $tuple["event_id"] . "'>" . $tuple["event_name"] . " </a> <br>" . $tuple["event_start_date"] . "<br>" . $tuple["event_start_time"] . "<br>";
			// }
		// }
		
		
	echo "<div class='keywordSearchDialog'><h1 style='text-align:center'>Search Results for : </h1><span class='searchKeywords'><h2 style='color:purple; text-align:center'>" . $_GET["search_term"] . "</h2></span></div>";
	if($users_result->num_rows == 0 && $groups_result->num_rows == 0 && $events_result->num_rows == 0) {
		echo "<div class='noMatchDialog'>Nothing here, search for something else!</div>";
		
	}
	else {
		echo "<div class='searchResultsCont'> <button onclick='showTab()'>Search Button</button";
			
		if($users_result->num_rows > 0) {
					    echo"  	<div class='userSearchResults'>
					        		<h2 style='color:black'>Users</h2>
					        		<div class='usersSearchCont'>";
		
			while($user_tuple = $users_result->fetch_assoc()) {
				
				$fetch_user_pic_query = "SELECT image_name 
										FROM images
										WHERE owner_type = 0 AND owner_id = " . $user_tuple["user_id"] . " AND currently_set = 1 AND image_type = 0";
				
				echo "
											<div class='userSearchBoxCont' data-dismiss='modal'  href='#home' onclick='showTab(0, " . $user_tuple["user_id"] . ")'>						        		
												<div class='contenderImage' style='background-image: url(user_images/" . (($conn->query($fetch_group_pic_query))->fetch_assoc())["image_name"] . ")'></div>
												<div class='contenderName'>" . $user_tuple["username"] . "</div>
											</div>";
			}
		}
		
		echo "
							        </div>
						        </div>";
		if($groups_result->num_rows > 0) {
						echo"     <div class='groupSearchResults'>
						        	<h2 style='color:black'>Groups</h2>
						        	<div class='groupsSearchCont'>";
									
			while($group_tuple = $groups_result->fetch_assoc()) {
				
				
				$fetch_group_pic_query = "SELECT image_name 
										FROM images
										WHERE owner_type = 1 AND owner_id = " . $group_tuple["group_id"] . " AND currently_set = 1 AND image_type = 0";
										
				echo "
											<div class='groupSearchBoxCont'  data-dismiss='modal'  href='#groups'  onclick='showTab(1, " . $group_tuple["group_id"] . ")'>
												<div class='contenderImage'  style='background-image: url(user_images/" . (($conn->query($fetch_group_pic_query))->fetch_assoc())["image_name"] . ")'></div>						        									        		
												<div class='contenderName'>" . $group_tuple["group_name"] . "</div>
											</div>";					
			}
		
		}
		
		echo "
						        	</div>
						        </div>";
								
		if($events_result->num_rows > 0) {
			echo		        "<div class='eventSearchResults'>
						        	<h2 style='color:black'>Events</h2>
						        	<div class='eventsSearchCont'>";
									
									
			while($event_tuple = $events_result->fetch_assoc()) {
				echo "
											<div class='eventSearchBoxCont'  data-dismiss='modal'  href='#events' onclick='showTab(2, " . $event_tuple["event_id"] . ")'>					        									        		
												<div class='contenderName'>" . $event_tuple["event_name"] . "</div>
											</div>";
			}
			
		}
		
		echo "</div>
						        </div>
					        </div>";
								
	}
?>
</html>