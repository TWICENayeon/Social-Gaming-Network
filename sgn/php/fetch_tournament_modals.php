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




<div class="eventsModals">

 <?php
		// tournament-related modals for future events
		$search_past_future_events =  "(SELECT event_id, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
										FROM sgn_database.attendees JOIN sgn_database.events
										ON attendees.attended_event_id = events.event_id
										WHERE attendee_id = 1 AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
										ORDER BY date_time ASC)
										UNION
										(SELECT event_id,  CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
										FROM sgn_database.attendees JOIN sgn_database.events
										ON attendees.attended_event_id = events.event_id
										WHERE attendee_id = 1 AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
										ORDER BY date_time DESC
										LIMIT 5)";
								
		$result = $conn->query($search_past_future_events);
		
		if($result->num_rows > 0) {
			
				
			echo "<div class='tournamentModals'>";
			
				
				
			while($tuple = $result->fetch_assoc()) {
				$curr_event_id = $tuple["event_id"];
				$search_tournament = "SELECT * 
										FROM tournaments 
										WHERE host_event_id = " . $curr_event_id . ";";
										
				$has_tournament_result = $conn->query($search_tournament);
				
				// Tournament Content modal
				if($has_tournament_result->num_rows == 1) {
					// General tournament info
					$tournament_info = $has_tournament_result->fetch_assoc();
					
					$search_participant_count_event =  "SELECT COUNT(tournament_id) as contenderCount
											FROM sgn_database.tournament_participants
											WHERE tournament_id = " . $tournament_info["tournament_id"] .";";
											
					$participant_count_value = (($conn->query($search_participant_count_event))->fetch_assoc())["contenderCount"];	
					
					$search_contenders_info =  "SELECT user_id, username, ordering
										FROM sgn_database.tournament_participants INNER JOIN sgn_database.users
										ON tournament_participants.participant_id = users.user_id 
										WHERE tournament_id = " . $tournament_info["tournament_id"] .
										" ORDER BY ordering ASC;";
											
					$contenders_info_result = ($conn->query($search_contenders_info));
					
					// Number of participants
					
					echo "
					<div class='modal fade show' id='tournamentModal_" . $tournament_info["tournament_id"] . "' tabindex='-1' role='dialog'>
						<div class='modal-dialog modal-lg' role='document'>
						    <div class='modal-content'>
						      <div class='modal-header'>
						        <h5 class='modal-title'>Tournament Name</h5>
						        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						          <span aria-hidden='true'>&times;</span>
						        </button>
						      </div>
						      <div class='modal-body'>
						        <h1 class='tournamentTitle'>" . $tournament_info["tournament_name"] . "</h1>
						        <h2 class='tournamentDate'>" . $tournament_info["tournament_date"] . "</h2>
						        <h2 class='tournamentTime'>" . $tournament_info["tournament_time"] . "</h2>
						        <div class='participantsCont'>
						        	<div class='participantsTitle'>Number of Participants: <div class='numberParticipants'>" . $participant_count_value . "</div></div>
						        	<div class='currentParticipantsTitle'>Current Participants: </div>";
									while($contenders_info = $contenders_info_result->fetch_assoc()) {
										$contender_pic_query = "SELECT image_name 
																FROM images
																WHERE owner_type = 0 AND owner_id = " . $contenders_info["user_id"] . " AND currently_set = 1 AND image_type = 0";
										
										
										echo "<div class='contenderCont'>
														<div class='contenderNum'>" . $contenders_info["ordering"] . "</div>
														<div class='contenderImage' style='background-image: url(user_images/" . (($conn->query($contender_pic_query))->fetch_assoc())["image_name"] . ")'></div>
														<div class='contenderName'>" . $contenders_info["username"] . "</div>
													</div>";
										
									}
									
									
									// Check if tournament has already started and current user is creator
									$has_not_started_query = "SELECT *
														FROM sgn_database.tournaments
														WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND started = 0;";
									
									$user_group_status_query = "SELECT membership_role
											FROM sgn_database.memberships
											WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = 
											(	SELECT hosting_group_id
											FROM sgn_database.group_events
											WHERE hosted_event_id =
											(SELECT host_event_id
											FROM sgn_database.tournaments
											WHERE tournament_id = " . $tournament_info["tournament_id"] . "))";
											
									// echo "user group status query: " . $user_group_status_query . "<br><br><br><br>";
											
									$status_value = intval((($conn->query($user_group_status_query))->fetch_assoc())["membership_role"]);
									
									
									if(($conn->query($has_not_started_query))->num_rows == 1) {
										echo "<div class='tournamentStartDialog'>Note: Tournament has not started!</div>";
										if($status_value == "1") {
											$contenders_info_result = ($conn->query($search_contenders_info));
											if($contenders_info_result->num_rows != 0) {
												echo "<br><br>
													<div class='seedingFormCont'>
													<form class='seedingForm'>
														<div class='personSeed'>Select person to change their seeding: 
															<select name='peopleNames'>";
																
																while($contenders_info = $contenders_info_result->fetch_assoc()) {
																	
																	echo "<option>" . $contenders_info["username"] . "</option>";
																	
																}
															echo "</select>
														</div>
														<br>
														<div class='personSeedNum'>Enter number to change their seeding: 
															<input type='text'>
														</div>
														<input type='button' value='Change Seed!'>
													</form>
												</div>
												<br><br>
												<form class='streamLinkCont' id='streamName_" . $tournament_info["tournament_id"] . "'>
												<div class='streamLink'>Stream for Tournament (Name here) &rarr; <input type='text' id='streamNameForm_" . $tournament_info["tournament_id"] . "'></div>
												<input type='button' value='Add Stream!' onclick='addTournamentStream(" . $tournament_info["tournament_id"] . ")'>
											</form>";
											}
										}
									}
									else {
										echo "<div class='tournamentStartDialog'>Note: Tournament has begun!</div>";
									}
						        	
									// Check if tournament has a stream
									
									$check_stream = "SELECT twitch_stream
													FROM tournaments
													WHERE tournament_id = " . $tournament_info["tournament_id"] . ";";
									$stream_name = (($conn->query($check_stream))->fetch_assoc())["twitch_stream"];				
									// if(!empty($stream_name)) {
										 // echo "
										// <div class='streamBox'><div id='twitch-embed'></div></div>

											// <script type='text/javascript'>
											  // new Twitch.Embed('twitch-embed', {
												// width: 1166,
												// height: 552,
												// layout: 'video',
												// channel: 'TWICE_ny'
											  // });
											// </script>
											// <br>
											// <br>
											// <br>";
									// }
									
									
									if ($status_value == "1") {
										echo "
												<br><br>
												<div class='tournamentSignUpStartButtons'>
													<button type='btn btn-primary' class='tournamentStartButton'>Start Tournament</button>
												</div>";
									}
						        	
						        echo "</div>					        
						      </div>
						      <div class='modal-footer'>";
							$is_contender = "SELECT TRUE
												FROM tournament_participants
												WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND participant_id = " . $_SESSION["current_user_id"] . "";
							if(($conn->query($is_contender))->num_rows == 1) {
								echo "<button type='button' class='btn btn-primary' onclick='updateTournamentAttendance(" . $tournament_info["tournament_id"] . ",1, " . $curr_event_id . ")'>Leave</button>";
							}
							else {
								echo "<button type='button' class='btn btn-primary' onclick='updateTournamentAttendance(" . $tournament_info["tournament_id"] . ",0, " . $curr_event_id . ")'>Sign Up</button>";
							}
						        
						        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
						      </div>
						    </div>					  	
						</div>						
		  			</div>";
					
				}
				else {
					$search_member_role_query = "SELECT membership_role
										 FROM sgn_database.memberships
										 WHERE member_id = " . $_SESSION["current_user_id"] . " AND of_group_id = 
										 (	SELECT hosting_group_id
											FROM sgn_database.group_events
											WHERE hosted_event_id = " . $_SESSION["page_id"] . ");";
					// $search_member_role_query;
					
					$role_result = $conn->query($search_member_role_query);
					

					
					
					
					//echo "membership role: " . ($result->fetch_assoc())["membership_role"];
					
					// Option to create a new tournament if the user has the privilege to
					if($role_result->num_rows == 1) {
						$role_tuple = $role_result->fetch_assoc();
						//echo $tuple["membership_role"] . "<br> <br> <br>";
						if($role_tuple["membership_role"] > 0) {	
						// Create tournament modal 
						echo "<div class='createTournamentModal'>
								<div class='modal fade' id='createTournamentModal_" . $curr_event_id . "' tabindex='-1' role='dialog'>
									<div class='modal-dialog modal-lg' role='document'>
										<div class='modal-content'>
										  <div class='modal-header'>
											<h5 class='modal-title' style='color:black'>Create Tournament</h5>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
											  <span aria-hidden='true'>&times;</span>
											</button>
										  </div>
										  <div class='modal-body'>
											<form class='createTournamentForm' id='createTournamentForm_" . $curr_event_id . "'>						        
												<div class='createTournamentTitle' style='color:black'>Tournament Title: <input type='text' id='createTournamentTitle_" . $curr_event_id . "'></div>
												<div class='createTournamentDate' style='color:black'>Tournament Date (mm/dd/yy): <input type='date' id='createTournamentDate_" . $curr_event_id . "'></div>
												<div class='createTournamentTime' style='color:black'>Tournament Time: <input type='time' id='createTournamentTime_" . $curr_event_id . "'></div>
										  </div>
										  <div class='modal-footer'>
											<button type='button' class='btn btn-primary' onclick='createTournament(" . $curr_event_id . ")'>Create</button>
											</form>
											<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
										  </div>
										</div>					  	
									</div>						
								</div>
							</div>";

						}
					}
				}
			}
		}
		echo "
		  		</div>";
		
		
		// tournament-related modals for past events
		$search_past_user_events =  "SELECT event_id
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["page_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								LIMIT 5;";
								
		$result = $conn->query($search_past_user_events);
		
		
		$conn->close();
?>
</div>
</html>