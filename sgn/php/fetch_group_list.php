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

	$conn = new mysqli("localhost", "root", "");

		
		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
	$conn->select_db("sgn_database");
	
	
	echo "					<div class='tabWelcome'>Your Groups</div>
					<button type='button' class='btn btn-primary' id='createGroupButton' data-toggle='modal' data-target='#createGroupModal'>Create Group</button>
					<br><br>
					
					<!-- Create Group Modal -->		  	
					<div class='modal fade' id='createGroupModal' tabindex='-1' role='dialog'>
						<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Create Group</h5>
								<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							<form class='createGroupForm' action='php/group_create.php' method='POST' enctype='multipart/form-data'>	
							  <div class='modal-body'>					        
									<div class='createGroupTitle'>Group Name: <input type='text' name='groupName'></div>
									<div class='createGroupPicture'>Upload photo: <input id='uploadGroupPictureButton' type='file' name='groupPicture'></div>	
							  </div>
							  <div class='modal-footer'>
								<button type='submit' class='btn btn-primary'>Create!</button>
								<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							  </div>	
							</form>
							</div>					  	
						</div>						
					</div>	
					";

		
		$search_user_groups =  "SELECT *
									FROM sgn_database.memberships JOIN sgn_database.groups
									ON memberships.of_group_id = groups.group_id
									WHERE member_id = " . $_SESSION["current_user_id"] . "
									ORDER BY group_name;";
		
		$result = $conn->query($search_user_groups);
		
		
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				
				$group_profile_picture_query = "SELECT image_name
												FROM images
												WHERE owner_type = 1 AND owner_id = " . $tuple["group_id"] . " AND currently_set = 1 AND image_type = 0;";

				$group_profile_picture_name = (($conn->query($group_profile_picture_query))->fetch_assoc())["image_name"];
				
				
				$fetch_membership_role_query = "SELECT membership_role
												FROM memberships
												WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $tuple["group_id"] . ";";
												
				$is_admin = ((($conn->query($fetch_membership_role_query))->fetch_assoc())["membership_role"]) == "1";
				
				echo "<div class='templateGroup'>
						<div class='groupHeaderCont'>
							<div class='groupTitle'>" . $tuple["group_name"] . ($is_admin ? "★" : "") . "</div>
							<div class='group-image' style='background-image: url(user_images/" . (!empty($group_profile_picture_name) ? $group_profile_picture_name : "generic_group_star.png") . "'></div>
						</div>
						<br>
						<div class='groupButtons'>";
						if($is_admin) {
							echo "<button type='button' class='btn btn-primary' id='groupPictureButton' data-toggle='modal' data-target='#groupPictureModal_" . $tuple["group_id"] . "'>Change Name/Picture</button>
							";	
						}								
						echo	"
							<button type='button' class='btn btn-primary' id='groupEventsButton' data-toggle='modal' data-target='#groupEventModal_" . $tuple["group_id"] . "'>Events</button>
							<button type='button' class='btn btn-primary' id='groupMembersButton' data-toggle='modal' data-target='#groupMembersModal_" . $tuple["group_id"] . "'>See Members</button>
							<button type='button' class='btn btn-primary' id='groupLeaveButton' data-toggle='modal' data-target='#groupLeaveModal_" . $tuple["group_id"] . "'>Leave Group</button>
						</div>
					</div>";
				
				// Group info update modal
				echo "<div class='modal fade' id='groupPictureModal_" . $tuple["group_id"] . "' tabindex='-1' role='dialog'>
						<div class='modal-dialog modal-lg' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>Change Name/Picture for " . $tuple["group_name"] . "</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
							  <form class='createGroupForm' action='php/group_info_update.php' method='POST' enctype='multipart/form-data'>	
						      <div class='modal-body'>					        
						        	<div class='createGroupTitle'>New Group Name: <input type='text' name='groupName'></div>
						        	<div class='createGroupPicture'>Upload New Group Picture: <input id='uploadGroupPictureButton' type='file' name='groupPicture'></div>
									 <input type='hidden' name='groupID' value='" . $tuple["group_id"] . "'>
						      </div>
						      <div class='modal-footer'>
						        <button type='submit' class='btn btn-primary'>Update!</button>
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
							  </form>
						    </div>					  	
						</div>
					</div>";
					
				echo "<div class='modal fade' id='groupLeaveModal_" . $tuple["group_id"] . "' tabindex='-1' role='dialog'>
					  <div class='modal-dialog' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>Leave Group</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					        <h2 style='color:black'> Warning </h2>
					        <p style='color:black'>Are you sure you want to leave the group:  </p><div class='groupName'>" . $tuple["group_name"] . "</div>
					        <div class='group-image'  style='background-image: url(user_images/" . (!empty($group_profile_picture_name) ? $group_profile_picture_name : "generic_group_star-9.png") . "'></div>	
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-primary' data-dismiss='modal' onclick='leaveGroup(" . $tuple["group_id"] . ")'>Yes</button>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
					      </div>
					    </div>
					  </div>
					</div>";
			}
		}
		else {
			echo "<div class='groupsNoGroupDialog'>No groups to show, create one or join one!</div>";
		}
		
?>