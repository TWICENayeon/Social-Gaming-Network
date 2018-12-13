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
		
		echo "<div class='tabWelcome'>Upcoming Events</div>";
		
		$search_future_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date > CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time > CURRENT_TIME))
								ORDER BY date_time ASC;";
		
		$result = $conn->query($search_future_user_events);
		
		// echo $search_future_user_events;
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				$fetch_group_name_query = "SELECT group_name
											FROM groups
											WHERE group_id = (SELECT hosting_group_id FROM group_events WHERE hosted_event_id = " . $tuple["event_id"] . ");";
																	
											
				$hosting_group_name = (($conn->query($fetch_group_name_query))->fetch_assoc())["group_name"];
				
				echo "		<div class='templateEvent'>
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
									<button type='button' class='btn btn-primary' id='eventButton' data-toggle='modal' data-target='#futureEventModal_" . $tuple["event_id"] .  "'>View</button>
									";
				
				$check_existing_tournament_query = "SELECT tournament_id
													FROM tournaments
													WHERE host_event_id = " . $tuple["event_id"] . ";";
													
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
											WHERE hosted_event_id = " . $tuple["event_id"] . ");";
					// $search_member_role_query;
					
					$role_result = $conn->query($search_member_role_query);
					

					
					
					//echo "membership role: " . ($result->fetch_assoc())["membership_role"];
					
					// Option to create a new tournament if the user has the privilege to
					if($role_result->num_rows == 1) {
						$role_tuple = $role_result->fetch_assoc();
						//echo $tuple["membership_role"] . "<br> <br> <br>";
						if($role_tuple["membership_role"] > 0) {					
							echo "<button type='button' class='btn btn-primary' id='createTournamentButton' data-toggle='modal' data-target='#createTournamentModal_" . $tuple["event_id"] . "'>Create Tournament</button>
							";

						}
					}
				}				  
				echo				"<button type='button' class='btn btn-primary' id='eventPosts' data-toggle='modal' data-target='#eventPostsModal_"  . $tuple["event_id"] ."'>Posts</button>	
								</div>
							</div>";	
			}
		}
		else {
			// echo $search_future_user_events;
			echo "<br>You have no future events";
			
		}
		?>
		
		<?php
		echo "<div class='futureEventTitle'>Past Events</div>";
		
		
		$search_past_user_events =  "SELECT event_id, event_name, event_description, event_start_date, event_start_time, event_privacy, CONVERT(CONCAT( CONVERT(event_start_date, CHARACTER) , ' ', CONVERT(event_start_time, CHARACTER)), DATETIME) AS date_time
								FROM sgn_database.attendees JOIN sgn_database.events
								ON attendees.attended_event_id = events.event_id
								WHERE attendee_id = " . $_SESSION["current_user_id"] . " AND (event_start_date < CURRENT_DATE() OR (event_start_date = CURRENT_DATE() AND event_start_time < CURRENT_TIME))
								ORDER BY date_time DESC
								LIMIT 5;";
		
		$result = $conn->query($search_past_user_events);
		
		// echo $search_past_user_events;
		
		
		
		if($result->num_rows > 0) {
			while($tuple = $result->fetch_assoc()) {
				$fetch_group_name_query = "SELECT group_name
											FROM groups
											WHERE group_id = (SELECT hosting_group_id FROM group_events WHERE hosted_event_id = " . $tuple["event_id"] . ");";
											
				$hosting_group_name = (($conn->query($fetch_group_name_query))->fetch_assoc())["group_name"];
				
				echo "<div class='pastEventCont'>
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
									<button type='button' class='btn btn-primary' id='eventButton' data-toggle='modal' data-target='#pastEventModal_"  . $tuple["event_id"] .    "'>View</button>
									";
				$check_existing_tournament_query = "SELECT tournament_id
													FROM tournaments
													WHERE host_event_id = " . $tuple["event_id"] . ";";
				
				if(($conn->query($check_existing_tournament_query))->num_rows == 1) {
				
					$tournament_id = (($conn->query($check_existing_tournament_query))->fetch_assoc())["tournament_id"];
		
					echo "<button type='button' class='btn btn-primary' id='tournamentButton' data-toggle='modal' data-target='#tournamentModal_" . $tournament_id . "'>Tournament</button>
					";
				}
								echo	"<button type='button' class='btn btn-primary' id='eventPosts' data-toggle='modal' data-target='#eventPostsModal_"  . $tuple["event_id"] .    "'>Posts</button>			  
								</div>
							</div>
						</div>";		
			}
		}
		else {
			// echo $_SESSION["current_user_id"];
			echo "You have no past events";
		}
		
		$conn->close();
?>

</html>