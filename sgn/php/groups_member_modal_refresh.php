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
	



$group_id = $_POST["group_id"];
		
								$fetch_membership_role_query = "SELECT membership_role
																		FROM memberships
																		WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $group_id . ";";
																		
								$membership_role = (((($conn->query($fetch_membership_role_query))->fetch_assoc())["membership_role"]) == "1");

								
									echo "<div class='groupEventsDialog'>Greetings" . ($membership_role ? " ADMIN " : " MEMBER " ) . $_SESSION["current_username"] . "!</div>";
									
									if($membership_role) {
										echo "
										  <div class='modal-body'>					        
												<div class='createGroupTitle'>Invite User to Group: <input type='text' id='invited_to_group_" . $group_id . "'></div>
												<button type='button' class='btn btn-primary' onclick='inviteUserToGroup(" . $group_id . ")'>Invite User to Group!</button>
										  </div>";
									}
									
									// Fetch admins
									$fetch_admins_query = "SELECT member_id, username
															FROM memberships INNER JOIN users
															ON member_id = user_id
															WHERE of_group_id = " . $group_id . " AND membership_role = 1
															ORDER BY username;";
															
									$admins_result = $conn->query($fetch_admins_query);
									if(($admins_result->num_rows) > 0) {
										echo "<div class='contenderContBox'>
											<div class='groupEventsTitle'>Admins</div>";
										while($admin_tuple = $admins_result->fetch_assoc()) {
											// Get admin name
																	
											$admin_name = $admin_tuple["username"];
											
											$fetch_admin_picture_name = "SELECT image_name
																	FROM images
																	WHERE owner_type = 0 AND owner_id = " . $admin_tuple["member_id"] . " AND currently_set = 1 AND image_type = 0;";
																	
											$admin_picture_name = ((($conn->query($fetch_admin_picture_name))->fetch_assoc())["image_name"]);
											
											echo "<div class='contenderCont'>							        		
												<div class='contenderImage' style='background-image: url(user_images/" . $admin_picture_name . ")'></div>
												<div class='contenderName'>" . $admin_name . "</div>";
												if($membership_role) {
													echo "<div class='groupPromoteButtons'>
														<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $group_id . ", " . $admin_tuple["member_id"] . ", 0)'>Demote</button>
													</div>";
												}
												
											echo "</div>";
										}
									}
							        // Get members
									$fetch_members_query = "SELECT member_id, username
															FROM memberships INNER JOIN users
															ON member_id = user_id
															WHERE of_group_id = " . $group_id . " AND membership_role = 0
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
													<div class='contenderImage' style='background-image: url(user_images/" . $member_picture_name . ")'></div>
													<div class='contenderName'>" . $member_name . "</div>";
													if($membership_role) {
														echo "<div class='groupPromoteButtons'>
															<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $group_id . ", " . $member_tuple["member_id"] . ", 1)'>Promote</button>
														</div>";
													}
												echo "</div>";
											}
										echo "</div>
											";
									}