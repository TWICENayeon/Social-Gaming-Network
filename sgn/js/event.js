function fetchEvents() {
	fetchEventList();
	fetchEventModals();
	fetchEventPosts();
	fetchTournamentsModal();
}

function fetchEventList() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("events_list").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_events_list.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}

function fetchSingleEvent(event_id) {
		var param = "event_id=" + event_id;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("events_list").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_events_single.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(param);
}

function fetchEventModals() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("events_modal").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_events_modals.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}
	
function fetchEventPosts() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("events_post").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_events_posts.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}


// user post and user replies 
function createEventPost(event_id) {
	var replyTextBox = "#eventReplyTextBox_" + event_id;
	// .innerHTML = this.responseText;
	textarea_text = $(replyTextBox).val();
	
	var params = 'post_text=' + textarea_text + "&event_id=" + event_id;
	
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/new_event_post.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			refreshEventPostModal(event_id);
		}
	};
	xmlhttp.send(params);
	
}

function refreshEventPostModal(event_id) {
	var param = "event_id=" + event_id;
	
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/refresh_event_posts.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("eventPostsBody_" + event_id).innerHTML = this.responseText;
		}
	};
	xmlhttp.send(param);
}