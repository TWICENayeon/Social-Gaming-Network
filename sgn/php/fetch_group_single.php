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

		
		$search_single_group_query =  "SELECT *
									FROM sgn_database.memberships JOIN sgn_database.groups
									ON memberships.of_group_id = groups.group_id
									WHERE group_id = " . $_POST["group_id"] . ";";
		
		$tuple = ($conn->query($search_single_group_query))->fetch_assoc();
		
		
		
		$group_profile_picture_query = "SELECT image_name
										FROM images
										WHERE owner_type = 1 AND owner_id = " . $tuple["group_id"] . " AND currently_set = 1 AND image_type = 0;";

		$group_profile_picture_name = (($conn->query($group_profile_picture_query))->fetch_assoc())["image_name"];
		
		$group_membership_query = "SELECT * 
									FROM memberships
									WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $_POST["group_id"] . ";";
									
		$is_member = (($conn->query($group_membership_query))->num_rows) == 1;
		
		
		$fetch_admin_role_query = "SELECT membership_role
													FROM memberships
													WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $tuple["group_id"] . ";";
													
		$is_admin = ((($conn->query($fetch_admin_role_query))->fetch_assoc())["membership_role"]) == "1";
		
		echo "<div class='templateGroup'>
				<div class='groupHeaderCont'>
					<div class='groupTitle'>" . $tuple["group_name"] . "</div>
					<div class='group-image' style='background-image: url(user_images/" . $group_profile_picture_name . "'></div>
				</div>
				<br>
				<div class='groupButtons'>";
				if($is_member) {
					
					if($is_admin) {
						echo "<button type='button' class='btn btn-primary' id='groupPictureButton' data-toggle='modal' data-target='#groupPictureModal_" . $tuple["group_id"] . "'>Change Name/Picture</button>
						";	
					}	
				}	
				else {
					echo "<button type='button' class='btn btn-primary' id='groupJoinButton' data-toggle='modal' data-target='#groupJoinModal_" . $tuple["group_id"] . "'>Join</button>
					";
				}
				echo	"
					<button type='button' class='btn btn-primary' id='groupEventsButton' data-toggle='modal' data-target='#groupEventModal_" . $tuple["group_id"] . "'>Events</button>
					<button type='button' class='btn btn-primary' id='groupMembersButton' data-toggle='modal' data-target='#groupMembersModal_" . $tuple["group_id"] . "'>See Members</button>
					";
				if($is_member) {
					echo "<button type='button' class='btn btn-primary' id='groupLeaveButton' data-toggle='modal' data-target='#groupLeaveModal_" . $tuple["group_id"] . "'>Leave Group</button>
					";
				}
				echo "</div>
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
			
	if($is_member) {
			
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
					<div class='group-image'  style='background-image: url(user_images/" . $group_profile_picture_name . "'></div>	
				  </div>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='leaveGroup(" . $tuple["group_id"] . ")'>Yes</button>
					<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
				  </div>
				</div>
			  </div>
			</div>";
	}
	else {
		echo "<div class='modal fade' id='groupJoinModal_" . $tuple["group_id"] . "' tabindex='-1' role='dialog'>
				<div class='modal-dialog' role='document'>
					<div class='modal-content'>
					  <div class='modal-header'>
						<h5 class='modal-title'>Join Group</h5>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						  <span aria-hidden='true'>&times;</span>
						</button>
					  </div>
					  <div class='modal-body'>
						<h2 style='color:black'> Note </h2>
						<p style='color:black'>Would you like to join </p><div class='groupName'>" . $tuple["group_name"] . "</div>
						<div class='group-image' style='background-image: url(user_images/" . $group_profile_picture_name . "'></div>	
					  </div>
					  <div class='modal-footer'>
						<button type='button' class='btn btn-primary' data-dismiss='modal' onclick='joinGroup(" . $tuple["group_id"] . ")'>Yes</button>
						<button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
					  </div>
					</div>
				  </div>
				</div>";
	}
	
	$curr_group_id = $tuple["group_id"];
	
	echo "<div class='modal fade' id='groupEventModal_" . $tuple["group_id"] . "' tabindex='-1' role='dialog'>
							<div class='modal-dialog modal-lg' role='document'>
								<div class='modal-content'>
								  <div class='modal-header'>
									<h5 class='modal-title'>" . $tuple["group_name"] . "'s Events</h5>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									  <span aria-hidden='true'>&times;</span>
									</button>
								  </div>
								  <div class='modal-body'>";
								if($is_admin) {
									echo "<div class='createEventHeader'>Create Event</div>
									<div class='createEventCont'>
										<form class='createEventForm'>						        
											<div class='createEventTitle'><span style='color:black'>Event Title: </span><input type='text' id='newEventTitle_" . $curr_group_id . "'></div>
											<div class='createEventDate'><span style='color:black'>Event Date (mm/dd/yy):  </span><input type='date' id='newEventDate_" . $curr_group_id . "'></div>
											<div class='createEventTime'><span style='color:black'>Event Time:  </span><input type='time' id='newEventTime_" . $curr_group_id . "'></div>
											<button type='button' class='btn btn-primary' onclick='createNewEvent(" . $curr_group_id . ")'>Create</button>
										</form>
									</div>";
								}
								$fetch_group_future_events_query = "SELECT event_id, event_name, event_start_date, event_start_time
																	FROM events INNER JOIN group_events
																	ON event_id = hosted_event_id
																	WHERE hosting_group_id = " . $curr_group_id . " AND 
																	(event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME()));";
																	
								$group_future_events_result = $conn->query($fetch_group_future_events_query);
									echo "
									<br>
									<div class='listEventsCont' id='listEventsCont_" . $curr_group_id . "'>";
									if($group_future_events_result->num_rows == 0) {
										echo "<div class='groupEventsDialog'>No upcoming events just yet!</div>";
									}
									else {
										
										echo "<div class='groupEventsTitle'>Upcoming Events</div>
										";
										while($future_event_tuple = $group_future_events_result->fetch_assoc()) {
											echo "<div class='eventContBox'>							        		
												<div class='listEventName'>" . $future_event_tuple["event_name"] . "</div>
												<div class='listEventDate'>" . $future_event_tuple["event_start_date"] . "</div>
												<div class='listEventTime'>" . $future_event_tuple["event_start_time"] . "</div>
												<div class='listEventButtons'>";
												
													$fetch_current_user_attendance = "SELECT attendee_id
																						FROM attendees
																						WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND attended_event_id = " . $future_event_tuple["event_id"] . ";";
																			
													$is_attending_result = $conn->query($fetch_current_user_attendance);
												
													if(($is_attending_result->num_rows) == 0) {
														echo "<button type='button' class='btn btn-primary' onclick='processAttendance(" . $future_event_tuple["event_id"] . ", 1, " . $curr_group_id . ")'>Join</button>";
													}
													else {
														echo "<button type='button' class='btn btn-primary' onclick='processAttendance(" . $future_event_tuple["event_id"] . ", 0, " . $curr_group_id . ")'>Leave</button>";
													}
												echo "</div>
											</div>";
										}
											
									}
										
										
									echo "</div>
								  </div>
								  <div class='modal-footer'>						        
									<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
								  </div>
								</div>					  	
							</div>						
						</div>";
						
	echo "
				<div class='modal fade' id='groupMembersModal_" . $curr_group_id . "' tabindex='-1' role='dialog'>
						<div class='modal-dialog modal-lg' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>" . $tuple["group_name"] . "'s Group Members</h5>
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

								if($is_member) {
									echo "<div class='groupEventsDialog'>Greetings" . ($is_admin ? " ADMIN " : " MEMBER " ) . $_SESSION["current_username"] . "!</div>";
								}
									if($is_admin) {
										echo "<form class='InviteUserToGroupFor' >	
										  <div class='modal-body'>					        
												<div class='createGroupTitle'>Invite User to Group: <input type='text' name='groupName'></div>
												<button type='submit' class='btn btn-primary'>Create!</button>
										  </div>
										</form>";
									}
									echo "<div class='contenderContBox'>
										<div class='groupEventsTitle'>Admins</div>";
										
										$fetch_admins_query = "SELECT member_id
																FROM memberships
																WHERE of_group_id = " . $curr_group_id . " AND membership_role = 1;";
																
										$admins_result = $conn->query($fetch_admins_query);
										while($admin_tuple = $admins_result->fetch_assoc()) {
											
											$fetch_admin_name = "SELECT username
																	FROM users
																	WHERE user_id = " . $admin_tuple["member_id"] . ";";
																	
											$admin_name = ((($conn->query($fetch_admin_name))->fetch_assoc())["username"]);
											
											$fetch_admin_picture_name = "SELECT image_name
																	FROM images
																	WHERE owner_type = 0 AND owner_id = " . $admin_tuple["member_id"] . " AND currently_set = 1 AND image_type = 0;";
																	
											$admin_picture_name = ((($conn->query($fetch_admin_picture_name))->fetch_assoc())["image_name"]);
											
											echo "<div class='contenderCont'>							        		
												<div class='contenderImage' style='background-image: url(user_images/" . $admin_picture_name . ")'></div>
												<div class='contenderName'>" . $admin_name . "</div>";
												if($is_admin) {
													echo "<div class='groupPromoteButtons'>
														<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $curr_group_id . ", " . $admin_tuple["member_id"] . ", 0)'>Demote</button>
													</div>";
												}
												
											echo "</div>";
										}
									// Get members
									$fetch_members_query = "SELECT member_id
															FROM memberships
															WHERE of_group_id = " . $curr_group_id . " AND membership_role = 0;";
															
									$members_result = $conn->query($fetch_members_query);
									if($members_result->num_rows > 0) {
										echo "</div>	
										<div class='contenderContBox'>
											<div class='groupEventsTitle'>Members</div>";
											while($member_tuple = $members_result->fetch_assoc()) {
												// Get member name
												$fetch_member_name = "SELECT username
																		FROM users
																		WHERE user_id = " . $member_tuple["member_id"] . ";";
																		
												$member_name = ((($conn->query($fetch_member_name))->fetch_assoc())["username"]);
												
												$fetch_member_picture_name = "SELECT image_name
																		FROM images
																		WHERE owner_type = 0 AND owner_id = " . $member_tuple["member_id"] . " AND currently_set = 1 AND image_type = 0;";
																		
												$member_picture_name = ((($conn->query($fetch_member_picture_name))->fetch_assoc())["image_name"]);
												
												echo "<div class='contenderCont'>							        		
													<div class='contenderImage' style='background-image: url(user_images/" . $member_picture_name . ")'></div>
													<div class='contenderName'>" . $member_name . "</div>";
													if($is_admin) {
														echo "<div class='groupPromoteButtons'>
															<button type='button' class='btn btn-primary' onclick='processNewMemberRole(" . $curr_group_id . ", " . $member_tuple["member_id"] . ", 1)'>Promote</button>
														</div>";
													}
												echo "</div>";
											}
									}
									
										echo "</div>
											";
						        echo "</div>
						      </div>
						      <div class='modal-footer'>						        
						        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
						    </div>					  	
						</div>						
		  			</div>";
		
?>