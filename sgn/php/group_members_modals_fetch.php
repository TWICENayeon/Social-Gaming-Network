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
	
	
	$fetch_user_groups_query = "SELECT of_group_id
								FROM memberships
								WHERE member_id = " . $_SESSION["current_user_id"] . ";";
								
	$groups_ids_result = $conn->query($fetch_user_groups_query);
	
	
	while($group_id_tuple = $groups_ids_result->fetch_assoc()) {
		// Get group id
		$curr_group_id = $group_id_tuple["of_group_id"];
		
		// Get group name
		$group_name_query = "SELECT group_name
							FROM groups
							WHERE group_id = " . $curr_group_id . ";";
							
							
		$group_name = (($conn->query($group_name_query))->fetch_assoc())["group_name"];
		
		
		
		echo "
				<div class='modal fade' id='groupMembersModal_" . $curr_group_id . "' tabindex='-1' role='dialog'>
						<div class='modal-dialog modal-lg' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>" . $group_name . "'s Group Members</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
						      <div class='modal-body'>						      							        
						        <div class='listEventsCont' id='groupMembersBodyContent_" . $curr_group_id . "'>";
								
								$fetch_membership_role_query = "SELECT membership_role
																		FROM memberships
																		WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $curr_group_id . ";";
																		
								$is_admin = (((($conn->query($fetch_membership_role_query))->fetch_assoc())["membership_role"]) == "1");

								
									echo "<div class='groupEventsDialog'>Greetings" . ($is_admin ? " ADMIN " : " MEMBER " ) . $_SESSION["current_username"] . "!</div>";
									if($is_admin) {
										echo "
										  <div class='modal-body'>					        
												<div class='createGroupTitle'>Invite User to Group: <input type='text' id='invited_to_group_" . $curr_group_id . "'></div>
												<button type='button' class='btn btn-primary' onclick='inviteUserToGroup(" . $curr_group_id . ")'>Invite User to Group!</button>
										  </div>";
									}
									
									
									
									$fetch_admins_query = "SELECT member_id, username
															FROM memberships INNER JOIN users
															ON member_id = user_id
															WHERE of_group_id = " . $curr_group_id . " AND membership_role = 1
															ORDER BY username;";
															
									$admins_result = $conn->query($fetch_admins_query);
									
									if($admins_result->num_rows > 0) {
										echo "<div class='contenderContBox'>
											<div class='groupEventsTitle'>Admins</div>";
										
										while($admin_tuple = $admins_result->fetch_assoc()) {
																	
											$admin_name = $admin_tuple["username"];
											
											$fetch_admin_picture_name = "SELECT image_name
																	FROM images
																	WHERE owner_type = 0 AND owner_id = " . $admin_tuple["member_id"] . " AND currently_set = 1 AND image_type = 0;";
																	
											$admin_picture_name = ((($conn->query($fetch_admin_picture_name))->fetch_assoc())["image_name"]);
											
											echo "<div class='contenderCont'>							        		
												<div class='contenderImage' style='background-image: url(user_images/" .  (!empty($admin_picture_name) ? $admin_picture_name : "Profile-icon-9.png")  . ")'></div>
												<div class='contenderName'>" . $admin_name . "</div>";
												if($is_admin) {
													echo "<div class='groupPromoteButtons'>
														<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $curr_group_id . ", " . $admin_tuple["member_id"] . ", 0)'>Demote</button>
													</div>";
												}
												
											echo "</div>";
										}
									}
									// Get members
									$fetch_members_query = "SELECT member_id, username
															FROM memberships INNER JOIN users
															ON member_id = user_id
															WHERE of_group_id = " . $curr_group_id . " AND membership_role = 0
															ORDER BY username;";
															
									$members_result = $conn->query($fetch_members_query);
									if($members_result->num_rows > 0) {
										echo "</div>	
										<div class='contenderContBox'>
											<div class='groupEventsTitle'>Members</div>";
											while($member_tuple = $members_result->fetch_assoc()) {
												// Get member name
																		
												$member_name = $member_tuple["username"];
												
												$fetch_member_picture_name = "SELECT image_name
																		FROM images
																		WHERE owner_type = 0 AND owner_id = " . $member_tuple["member_id"] . " AND currently_set = 1 AND image_type = 0;";
																		
												$member_picture_name = ((($conn->query($fetch_member_picture_name))->fetch_assoc())["image_name"]);
												
												echo "<div class='contenderCont'>							        		
													<div class='contenderImage' style='background-image: url(user_images/" .  (!empty($member_picture_name) ? $member_picture_name : "Profile-icon-9.png") . ")'></div>
													<div class='contenderName'>" . $member_name . "</div>";
													if($is_admin) {
														echo "<div class='groupPromoteButtons'>
															<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $curr_group_id . ", " . $member_tuple["member_id"] . ", 1)'>Promote</button>
														</div>";
													}
												echo "</div>";
											}
									}
									
										echo "</div>";	
						        echo "</div>
						      </div>
						      <div class='modal-footer'>						        
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
						    </div>					  	
						</div>						
		  			</div>";
	}
	$conn->close();
?>
</html>