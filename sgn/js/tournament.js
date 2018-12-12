function fetchTournamentsModal() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tournaments_modal").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_tournament_modals.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}


function fetchTournamentInfo(tournament_id) {
	var xmlhttp = new XMLHttpRequest();
	var param = "tournament_id=" + tournament_id;
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("tournamentModal_" + tournament_id).innerHTML = this.responseText; // Why is this the notif modal???
		}
	};
	xmlhttp.open("POST", "php/fetch_tournament_info.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}


function createTournament(event_id) {
	var createTournamentTitleField = "#createTournamentTitle_" + event_id;
	var title_text = $(createTournamentTitleField).val();
	
	var createTournamentDateField = "#createTournamentDate_" + event_id;
	var date_text = $(createTournamentDateField).val();
	
	var createTournamentTimeField = "#createTournamentTime_" + event_id;
	var time_text = $(createTournamentTimeField).val();
	
	var params = "event_id=" + event_id + "&tournament_name=" + title_text + "&tournament_date=" + date_text + "&tournament_time=" + time_text;
	// alert(params);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			try {
				// alert(this.responseText);
				fetchEvents();
				// fetchTournamentsModal();
			}
			catch(err) {
				alert(err.message);
			}
			$('a[href="#events"]').tab('show');
			// alert("Printing span innerHTML");
			// alert(document.getElementById(numRepliesSpan).innerHTML);
		}
	};
	xmlhttp.open("POST", "php/new_tournament.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}


function updateTournamentAttendance(tournament_id, action, event_id) {
	var xmlhttp = new XMLHttpRequest();
	var params = "tournament_id=" + tournament_id + "&actionType=" + action;
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		// alert(this.responseText);
	  fetchTournamentInfo(tournament_id);
	  // alert("Set show before");
	  var tournamentModalID = "tournamentModal_" + event_id;
	  // alert(tournamentModalID);
	  document.getElementById("tournamentModal_" + event_id).className = "modal fade show";
	  // alert(document.getElementById("tournamentModal_" + event_id).className);
	  // alert("Set show after");
	  // alert(document.getElementById("tournamentModal_" + event_id).className);
	}
  };
	xmlhttp.open("POST","php/tournament_update_attendance.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function addTournamentStream(tournament_id) {
	var streamName = $("#streamNameForm_" + tournament_id).val();
	var xmlhttp = new XMLHttpRequest();
	var params = "stream_name=" + streamName + "&tournament_id=" + tournament_id;
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		// alert(this.responseText);
		// alert(this.responseText);
	  fetchTournamentInfo(tournament_id);
	}
  };
	xmlhttp.open("POST","php/tournament_update_stream.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function changeTournamentOrdering(tournament_id) {
	var user_id = $("#peopleNames_" + tournament_id).val();
	var order = $("#newSeedInput_" + tournament_id).val();
	var xmlhttp = new XMLHttpRequest();
	var params = "user_id=" + user_id + "&order=" + order + "&tournament_id=" + tournament_id;
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		// alert(this.responseText);
		// alert(this.responseText);
	  fetchTournamentInfo(tournament_id);
	}
  };
	xmlhttp.open("POST","php/update_tournament_ordering.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function startTournament(tournament_id) {
	var xmlhttp = new XMLHttpRequest();
	var param = "tournament_id=" + tournament_id;
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		fetchTournamentInfo(tournament_id);
	}
  };
	xmlhttp.open("POST","php/tournament_start.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function submitWinner(tournament_id, round, relative_match_num) {
	var winnerSelectorID = "#winnerSelector_" + tournament_id + "_" + round + "_" + relative_match_num;
	var xmlhttp = new XMLHttpRequest();
	var params = "tournament_id=" + tournament_id + "&old_round_num=" + round + "&old_match_num=" + relative_match_num + "&winner_id=" + $(winnerSelectorID).val();
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		fetchTournamentInfo(tournament_id);
	}
  };
	xmlhttp.open("POST","php/update_tournament_score.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}