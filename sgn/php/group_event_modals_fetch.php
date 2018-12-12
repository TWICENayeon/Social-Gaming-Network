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
		
		
		$fetch_admin_role_query = "SELECT membership_role
												FROM memberships
												WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = " . $curr_group_id . ";";
												
		$is_admin = (((($conn->query($fetch_admin_role_query))->fetch_assoc())["membership_role"]) == "1");
							
		echo "<div class='modal fade' id='groupEventModal_" . $curr_group_id . "' tabindex='-1' role='dialog'>
							<div class='modal-dialog modal-lg' role='document'>
								<div class='modal-content'>
								  <div class='modal-header'>
									<h5 class='modal-title'>" . $group_name . "'s Events</h5>
									<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
									  <span aria-hidden='true'>&times;</span>
									</button>
								  </div>
								  <div class='modal-body'>";
								if($is_admin) {
									echo "<div class='createEventHeader'>Create Event</div>
									<div class='createEventCont'>
										<form class='createEventForm' id='createEventForm_" . $curr_group_id . "'>						        
											<div class='createEventTitle'><span style='color:black'>Event Title: </span><input type='text' id='newEventTitle_" . $curr_group_id . "'></div>
											<div class='createEventDate'><span style='color:black'>Event Date:  </span><input type='date' id='newEventDate_" . $curr_group_id . "'></div>
											<div class='createEventTime'><span style='color:black'>Event Time:  </span><input type='time' id='newEventTime_" . $curr_group_id . "'></div>
											<div class='createEventTitle'><span style='color:black'>Event Description: <br> <textarea  id='newEventDescription_" . $curr_group_id . "' cols='40' rows='5' ></textarea></div>
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
							
	}


?>
</html>

