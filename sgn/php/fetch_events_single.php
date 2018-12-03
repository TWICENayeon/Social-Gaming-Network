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




	
	

<!-- Print out all of the current user's upcoming events --> 	

 <?php
 
		$event_id = $_POST["event_id"];
		
		$fetch_event_info_query = "SELECT *
									FROM events
									WHERE event_id = " . $event_id . ";";
									
		$tuple = ($conn->query($fetch_event_info_query))->fetch_assoc();
		

		$fetch_group_name_query = "SELECT group_name
									FROM groups
									WHERE group_id = (SELECT hosting_group_id FROM group_events WHERE hosted_event_id = " . $tuple["event_id"] . ");";
									
		$hosting_group_name = (($conn->query($fetch_group_name_query))->fetch_assoc())["group_name"];
		
		
		// Print out event box in the webpage
				echo "
							<div class='templateEvent'>
								<div class='eventHeaderCont'>		  					
									<div class='eventTitle'>" . $tuple["event_name"] . "</div>
									<div class='eventShortDesc'>Hosted by: ". $hosting_group_name . "</div>	
									<div class='eventShortDesc'>" . $tuple["event_description"] . "</div>		  							  
								</div>
								<div class='eventDateTimePrivCont'>
									<div class='eventDate'>" . $tuple["event_start_date"] . "</div>
									<div class='eventTime'>" . $tuple["event_start_time"] . "</div>	
								</div>
								<div class='eventViewPostsButtons'>
									<button type='button' class='btn btn-primary' id='eventButton' data-toggle='modal' data-target='#eventModal_" . $event_id .  "'>View</button>
									";
				
				$check_existing_tournament_query = "SELECT tournament_id
													FROM tournaments
													WHERE host_event_id = " . $event_id . ";";
													
				$existing_tournament_result = ($conn->query($check_existing_tournament_query));
				
				if($existing_tournament_result->num_rows == 1) {
					$tournament_id = (($existing_tournament_result)->fetch_assoc())["tournament_id"];
					echo "<button type='button' class='btn btn-primary' id='tournamentButton' data-toggle='modal' data-target='#tournamentModal_" . $tournament_id . "'>Tournament</button>
					";
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
							echo "<button type='button' class='btn btn-primary' id='createTournamentButton' data-toggle='modal' data-target='#createTournamentModal_" . $event_id . "'>Create Tournament</button>
							";

						}
					}
				}
									
									
											  
				echo				"<button type='button' class='btn btn-primary' id='eventPosts' data-toggle='modal' data-target='#eventPostsModal_"  . $event_id ."'>Posts</button>	
								</div>
							</div>";	
						
		// Print event modal
		
		echo "<div class='modal fade' id='eventModal_"  . $event_id .   "' tabindex='-1' role='dialog' aria-hidden='true'>
					  <div class='modal-dialog' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>" . $tuple["event_name"] . "</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					        <div class='modalEventInfoCont'>
					        	<!-- should disappear if the event hasnt started -->
									<div class='eventShortDesc' style='color:black'>Hosted by: ". $hosting_group_name . "</div>	
					        	<h1 id='modalEventDescTitle' style='color:black'>Description</h1>					        	
					        	<div class='modalEventDesc' style='color:black'>" . $tuple["event_description"] . "</div>
					        	<h1 id='modalEventDateTime' style='color:black'>Date/Time</h1>
					        	<div class='eventDate' style='color:black'>" . $tuple["event_start_date"] . "</div>
		  						<div class='eventTime' style='color:black'>" . $tuple["event_start_time"] . "</div>
					        </div>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-primary' id='eventLeaveButton'>Leave</button>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
					      </div>
					    </div>
					  </div>
					</div>";
					
					
		// Print tournament Modal
		
		
				$search_tournament = "SELECT * 
										FROM tournaments 
										WHERE host_event_id = " . $event_id . ";";
										
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
						        <h5 class='modal-title'>" . $tournament_info["tournament_name"] . "</h5>
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
															<select name='peopleNames' id='peopleNames_" . $tournament_info["tournament_id"] . "'>";
																
																while($contenders_info = $contenders_info_result->fetch_assoc()) {
																	
																	echo "<option value='" . $contenders_info["user_id"] ."'>" . $contenders_info["username"] . "</option>";
																	
																}
															echo "</select>
														</div>
														<br>
														<div class='personSeedNum'>Enter number to change their seeding: 
															<input type='text' id='newSeedInput_" . $tournament_info["tournament_id"] . "' placeholder='1 - " . $participant_count_value . "' >
														</div>
														<input type='button' value='Change Seed!' onclick='changeTournamentOrdering(" . $tournament_info["tournament_id"] . ")'>
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
									if(!empty($stream_name)) {
										 echo "
											<div class='streamBox'><iframe
												src='https://player.twitch.tv/?channel=" . strtolower($stream_name) . "'
												height='552'
												width='1166'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>";
									}
									
									
									if(($conn->query($has_not_started_query))->num_rows == 1) {
										if ($status_value == "1") {
											echo "
													<br><br>
													<div class='tournamentSignUpStartButtons'>
														<button type='btn btn-primary' class='tournamentStartButton' onclick='startTournament(" . $tournament_info["tournament_id"] . ")'>Start Tournament</button>
													</div>";
										}
									}
									// Copy to info start
									else {
										echo "<div class='matchProgression' id='matchProgression_" . $tournament_info["tournament_id"] . "'>";
										
										$max_round_num_query = "SELECT MAX(round) as highest
																FROM tournament_matches
																WHERE tournament_id = " . $tournament_info["tournament_id"] . ";";
																
										$max_round_num_value = intval((($conn->query($max_round_num_query))->fetch_assoc())["highest"]);
										
										for($round_counter = 1; $round_counter <= $max_round_num_value; ++$round_counter) {
											$round_matches_query = "SELECT *
																	FROM tournament_matches
																	WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND round = " . $round_counter . ";";
																	
											$round_matches_result = $conn->query($round_matches_query);
											
											if($round_matches_result->num_rows > 0) {
												echo "<div class='matchCont'>
														<div class='roundNum'>Round " . $round_counter . "</div>";
												// Print matches
												while($match_info = $round_matches_result->fetch_assoc()) {
													echo "
							        		<div class='matchContBox'>
							        			<div class='matchTitle'>Match " . $match_info["relative_match_id"] . "</div>
							        			<div class='matchParticipants'>";
												
													
													
													if(!empty($match_info["participant_1_id"])) {
														
														// Get order 
														$first_contender_order_query = "SELECT ordering
																					FROM tournament_participants
																					WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND participant_id = " . $match_info["participant_1_id"] . ";";
														
														
														$first_contender_order_value = (($conn->query($first_contender_order_query))->fetch_assoc())["ordering"];
														
														// Get image
														$first_contender_profile_pic_query = "SELECT image_name
																					FROM images
																					WHERE owner_type = 0 AND currently_set = 1 AND image_type = 0 AND owner_id = " . $match_info["participant_1_id"] . ";";
																					
														$first_contender_profile_pic_value = (($conn->query($first_contender_profile_pic_query))->fetch_assoc())["image_name"];
														
														// get username
														$first_contender_username_query = "SELECT username
																					FROM users
																					WHERE user_id = " . $match_info["participant_1_id"] . ";";
																					
														$first_contender_username_value = (($conn->query($first_contender_username_query))->fetch_assoc())["username"];
														
														echo "<div class='contenderCont'>
										        		<div class='contenderNum'>" . $first_contender_order_value . "</div>
										        		<div class='contenderImage'  style='background-image: url(user_images/" . $first_contender_profile_pic_value . ")'></div>
										        		<div class='contenderName'>" . $first_contender_username_value . "</div>
										        	</div>";
													}
													echo "<span style='color:black'>v.s.						        			 </span>";
													
													
													
													if(!empty($match_info["participant_2_id"])) {
														
														// Get order 
														$second_contender_order_query = "SELECT ordering
																					FROM tournament_participants
																					WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND participant_id = " . $match_info["participant_2_id"] . ";";
																					
														$second_contender_order_value = (($conn->query($second_contender_order_query))->fetch_assoc())["ordering"];
														
														// Get image
														$second_contender_profile_pic_query = "SELECT image_name
																					FROM images
																					WHERE owner_type = 0 AND currently_set = 1 AND image_type = 0 AND owner_id = " . $match_info["participant_2_id"] . ";";
																					
														$second_contender_profile_pic_value = (($conn->query($second_contender_profile_pic_query))->fetch_assoc())["image_name"];
														
														
														// get username
														$second_contender_username_query = "SELECT username
																					FROM users
																					WHERE user_id = " . $match_info["participant_2_id"] . ";";
																					
														$second_contender_username_value = (($conn->query($second_contender_username_query))->fetch_assoc())["username"];
														
														echo "<div class='contenderCont'>
										        		<div class='contenderNum'>" . $second_contender_order_value . "</div>
										        		<div class='contenderImage'  style='background-image: url(user_images/" . $second_contender_profile_pic_value . ")'></div>
										        		<div class='contenderName'>" . $second_contender_username_value . "</div>
										        	</div>";
													}
										        	echo "<br>";
													// If match hasn't finished
										        	if($match_info["winner"] == "0") {
														// Display choose-winner form if both contenders are present
														if(!empty($match_info["participant_1_id"]) && !empty($match_info["participant_2_id"])) {
															echo "<div class='pickMatchWinner'><h3>Choose the match winner:</h3></div>
															<div class='matchWinnerPicker'>
																<form>
																	<select name='pickerBox' id='winnerSelector_" . $tournament_info["tournament_id"] . "_" . $match_info["round"] . "_" . $match_info["relative_match_id"] . "'>
																		<option> </option>
																		<option value='" . $match_info["participant_1_id"] . "'>" . $first_contender_username_value . "</option>
																		<option value='" . $match_info["participant_2_id"] . "'>" . $second_contender_username_value . "</option>
																	</select>
																	<input type='button' value='Wins!' onclick='submitWinner(" . $tournament_info["tournament_id"] . ", " . $match_info["round"] . ", " . $match_info["relative_match_id"] . ")'>
																</form>
															</div>"; 
														}
													}
													// Else match is finished, then print victor information
													else {
														$winner_is_first_cont = $match_info["winner"] == $match_info["participant_1_id"];
														echo "
															<div class='matchCompleteDialog'><h2>Match Complete<h2></div>
															<div class='winnerDialog'>Winner of Match 1:</div>
															<div class='contenderCont'>
																<div class='contenderNum'>" .  ($winner_is_first_cont ? $first_contender_order_value : $second_contender_order_value) . "</div>
																<div class='contenderImage'  style='background-image: url(user_images/" . ($winner_is_first_cont ? $first_contender_profile_pic_value : $second_contender_profile_pic_value) . ")'></div>
																<div class='contenderName'>" .  ($winner_is_first_cont ? $first_contender_username_value : $second_contender_username_value) . "</div>
															</div>";
													}
													echo "</div>
												</div>";
												}
												
												
												echo "</div>";
											}
										}
										
										// Print tournament winner if applicable
										$tournament_winner_query = "SELECT participant_1_id
																	FROM tournament_matches
																	WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND round = 0 AND relative_match_id = 0;";
																	
										$tournament_winner_result = $conn->query($tournament_winner_query);
										
										if($tournament_winner_result->num_rows == 1) {
											$winner_id = ($tournament_winner_result->fetch_assoc())["participant_1_id"];
											
											
											// Get order 
											$winner_order_query = "SELECT ordering
																		FROM tournament_participants
																		WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND participant_id = " . $winner_id . ";";
																		
																		
											$winner_order_value = (($conn->query($winner_order_query))->fetch_assoc())["ordering"];
											
											// Get image
											$winner_profile_pic_query = "SELECT image_name
																		FROM images
																		WHERE owner_type = 0 AND currently_set = 1 AND image_type = 0 AND owner_id = " . $winner_id . ";";
																		
											$winner_profile_pic_value = (($conn->query($winner_profile_pic_query))->fetch_assoc())["image_name"];
											
											
											// get username
											$winner_username_query = "SELECT username
																		FROM users
																		WHERE user_id = " . $winner_id . ";";
																		
											$winner_username_value = (($conn->query($winner_username_query))->fetch_assoc())["username"];
													
													
											echo "
													<div class='tournamentWinner'>Tournament Winner: 
														<div class='contenderCont'>
															<div class='contenderNum'>" . $winner_order_value . "</div>
										        		<div class='contenderImage'  style='background-image: url(user_images/" . $winner_profile_pic_value . ")'></div>
															<div class='contenderName'>" . $winner_username_value . "</div>
														</div>
													</div>";
										}
										echo "</div>";
										
									}
									// Copy to info end
						        	
						        echo "</div>					        
						      </div>
						      <div class='modal-footer'>";
							if(($conn->query($has_not_started_query))->num_rows == 1) {
								$is_contender = "SELECT TRUE
													FROM tournament_participants
													WHERE tournament_id = " . $tournament_info["tournament_id"] . " AND participant_id = " . $_SESSION["current_user_id"] . "";
								if(($conn->query($is_contender))->num_rows == 1) {
									echo "<button type='button' class='btn btn-primary' onclick='updateTournamentAttendance(" . $tournament_info["tournament_id"] . ",1, " . $event_id . ")'>Leave</button>";
								}
								else {
									echo "<button type='button' class='btn btn-primary' onclick='updateTournamentAttendance(" . $tournament_info["tournament_id"] . ",0, " . $event_id . ")'>Sign Up</button>";
								}
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
								<div class='modal fade' id='createTournamentModal_" . $event_id . "' tabindex='-1' role='dialog'>
									<div class='modal-dialog modal-lg' role='document'>
										<div class='modal-content'>
										  <div class='modal-header'>
											<h5 class='modal-title' style='color:black'>Create Tournament</h5>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
											  <span aria-hidden='true'>&times;</span>
											</button>
										  </div>
										  <div class='modal-body'>
											<form class='createTournamentForm' id='createTournamentForm_" . $event_id . "'>						        
												<div class='createTournamentTitle' style='color:black'>Tournament Title: <input type='text' id='createTournamentTitle_" . $event_id . "'></div>
												<div class='createTournamentDate' style='color:black'>Tournament Date (mm/dd/yy): <input type='date' id='createTournamentDate_" . $event_id . "'></div>
												<div class='createTournamentTime' style='color:black'>Tournament Time: <input type='time' id='createTournamentTime_" . $event_id . "'></div>
										  </div>
										  <div class='modal-footer'>
											<button type='button' class='btn btn-primary' onclick='createTournament(" . $event_id . ")'>Create</button>
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
				
			// Create Posts modal
				
	
				echo "<div class='modal fade' id='eventPostsModal_" . $event_id .  "' tabindex='-1' role='dialog' aria-hidden='true'>
						  <div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content'>
							  <div class='modal-header'>
								<h5 class='modal-title'>Event Posts</h5>
								  <span aria-hidden='true'>&times;</span>
								</button>
							  </div>
							  <div class='modal-body' id='eventPostsBody_" . $event_id .  "'>
								<div class='modalEventInfoCont'>";
									
				$search_event_wall_posts =  "SELECT post_id, username, post_text, post_date, post_time, user_id
									FROM sgn_database.posts JOIN sgn_database.users
									ON posts.poster_id = users.user_id
									WHERE wall_owner_id = " . $event_id . " AND wall_type = 2
									ORDER BY post_id DESC;";
								   
				$event_post_result = $conn->query($search_event_wall_posts);
				
				if($event_post_result->num_rows > 0) {
					while($event_post_tuple = $event_post_result->fetch_assoc()) {
						
					$fetch_profile_picture_reply = "SELECT image_name
												FROM images
												WHERE owner_type = 0 AND owner_id = " . $event_post_tuple["user_id"] . " AND currently_set = 1 AND image_type = 0;";
												
												
					$profile_picture_name_reply = (($conn->query($fetch_profile_picture_reply))->fetch_assoc())["image_name"];
					
					
					$has_liked_reply_query = "SELECT *
										FROM post_votes
										WHERE voter_id = " . $_SESSION["current_user_id"] . " AND voted_id = " . $event_post_tuple["post_id"] . ";";	

					$liked_reply_value = ($conn->query($has_liked_reply_query))->num_rows == 1;
					
					$fetch_reply_votes_query = "SELECT SUM(sgn_database.post_votes.value) AS total
											FROM sgn_database.post_votes
											WHERE voted_id = " . $event_post_tuple["post_id"] . ";";
											
					$reply_vote_total = (($conn->query($fetch_reply_votes_query))->fetch_assoc())["total"];
					
					if(!isset($reply_vote_total)) {
						$reply_vote_total = "0";
					}
									   
										// Fetch posts related to the event
						echo " <div class='eventPostCont'>
												<div class='eventPostProfileImage'  style='background-image: url(user_images/" . $profile_picture_name_reply . ")'></div>
												<div class='eventPostGap'></div>
												<div class='eventPostName' style='color:black'>" . $event_post_tuple["username"] . "</div>
												<div class='eventPostDate' style='color:black'>" . $event_post_tuple["post_date"] . "</div>
												<div class='eventPostTime' style='color:black'>" . $event_post_tuple["post_time"] . "</div>
												<div class='eventPostComment' style='color:black'>" . $event_post_tuple["post_text"] . "</div>
										<div class='commentPostVoteButtons'>
											<div class='commentPostUpvote'style='color:black' onclick='likeAction(this, " . $event_post_tuple["post_id"] . ", 2)'>
											<i class='fa fa-hand-o-up' aria-hidden='false' " . ($liked_reply_value ? " style='color:blue' " : "style='color:black'") ."></i>			
											<span id='vote_total'>" . $reply_vote_total . "</span>
											</div>
												</div>
											</div>	";			        	

						
					}	
				}
				else {
					echo "<!-- should disappear if there are no posts -->
					<div class='modalEventStartedWarning' style='color:black'>No posts to show</div>";
				}
				echo "</div>
					<textarea class='postTextBox' id='eventReplyTextBox_" . $event_id . "' placeholder='Write something:' rows='6' cols='60'></textarea>
				  </div>
				  <div class='modal-footer'>					      						        
					<button type='button' class='btn btn-primary' id='eventReplyButton' onclick='createEventPost(" . $event_id . ")'>Post</button>
					<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
				  </div>
				</div>
			  </div>
			</div>";
		
		$conn->close();
		?>
		

</html>