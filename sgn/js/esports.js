
var fetchStreamChatIntervalFunction = null;
var fetchStreamFriendsListIntervalFunction = null;

function fetchEsportsModals() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mainEsportsModals").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/esports_modals_fetch.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}

function loadFreeStream() {
	var freeStreamName = $("#freeStreamName").val();
	var param = "freeStreamName=" + freeStreamName;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("freeStreamVideo").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/free_stream_load.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function fetchStreamFriendsList(index) {
	var xmlhttp = new XMLHttpRequest();
	var param = "index=" + index;
	
	xmlhttp.open("POST", "php/stream_friends_list_fetch.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			streamChatName = "";
			if(index == 0) {
				streamChatName = "freeStreamChat";
			}
			else if(index == 1) {
				streamChatName = "lolStreamChat";
			}
			else if(index == 2) {
				streamChatName = "csgoStreamChat";
			}
			else if(index == 3) {
				streamChatName = "owStreamChat";
			}
			else if(index == 4) {
				streamChatName = "hotsStreamChat";
			}
			else if(index == 5) {
				streamChatName = "sc2StreamChat";
			}
			document.getElementById(streamChatName).innerHTML = this.responseText;
			if(fetchStreamFriendsListIntervalFunction == null) {
				clearInterval(fetchStreamChatIntervalFunction);
				fetchStreamChatIntervalFunction = null;
				// fetchStreamFriendsListIntervalFunction = setInterval( function() { fetchStreamFriendsList(index); }, 500 );
			}
		}
	};
	xmlhttp.send(param);
}


function fetchStreamChat(friend_id, index) {
	var param = "friend_id=" + friend_id + "&index=" + index;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/stream_friend_chat_fetch.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			streamChatPrefix = "";
			if(index == 0) {
				streamChatPrefix = "free";
			}
			else if(index == 1) {
				streamChatPrefix = "lol";
			}
			else if(index == 2) {
				streamChatPrefix = "csgo";
			}
			else if(index == 3) {
				streamChatPrefix = "ow";
			}
			else if(index == 4) {
				streamChatPrefix = "hots";
			}
			else if(index == 5) {
				streamChatPrefix = "sc2";
			}
			document.getElementById(streamChatPrefix + "StreamChat").innerHTML = this.responseText;
			if(fetchStreamChatIntervalFunction == null) {
				clearInterval(fetchStreamFriendsListIntervalFunction);
				fetchStreamFriendsListIntervalFunction = null;
				// fetchStreamChatIntervalFunction = setInterval( function() { refreshStreamChatMessages(friend_id, index); }, 500 );
			}
			// alert(document.getElementById("sgnChat").scrollHeight);
			// alert($("#sgnChat").scrollTop());
			// var objDiv = document.getElementById("sgnChat");
			// objDiv.scrollTop = objDiv.scrollHeight;
			// $("#sgnChat").scrollTop(document.getElementById("sgnChat").scrollHeight);
		}
	};
	xmlhttp.send(param);
}

function refreshStreamChatMessages(friend_id, index) {
	var param = "friend_id=" + friend_id;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/stream_friend_chat_messages_refresh.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			streamChatPrefix = "";
			if(index == 0) {
				streamChatPrefix = "free";
			}
			else if(index == 1) {
				streamChatPrefix = "lol";
			}
			else if(index == 2) {
				streamChatPrefix = "csgo";
			}
			else if(index == 3) {
				streamChatPrefix = "ow";
			}
			else if(index == 4) {
				streamChatPrefix = "hots";
			}
			else if(index == 5) {
				streamChatPrefix = "sc2";
			}
			
			document.getElementById(streamChatPrefix + "MessageBoxCont").innerHTML = this.responseText;
		}
	};
	xmlhttp.send(param);
}

function viewStreamChat() {
	$('#friendContBox').attr('style', 'display:none');
	$('#sgnChat').attr('style', '');
}

function streamSubmitNewMessage(chat_id, index) {
	alert(chat_id);
	alert(index);
	streamChatPrefix = "";
	if(index == 0) {
		streamChatPrefix = "free";
	}
	else if(index == 1) {
		streamChatPrefix = "lol";
	}
	else if(index == 2) {
		streamChatPrefix = "csgo";
	}
	else if(index == 3) {
		streamChatPrefix = "ow";
	}
	else if(index == 4) {
		streamChatPrefix = "hots";
	}
	else if(index == 5) {
		streamChatPrefix = "sc2";
	}
	var chat_message = $('#' + streamChatPrefix + 'usermsg').val();
	var params = "chat_id=" + chat_id + "&chat_message=" + chat_message;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "php/sidebar_friend_chat_insert.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			alert(this.responseText);
			document.getElementById(streamChatPrefix + "chatTextCont").reset();
		}
	};
	xmlhttp.send(params);
	alert("request sent");
}
