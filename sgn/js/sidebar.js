function fetchSidebarFriendsList() {
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/sidebar_friends_list_fetch.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("sgnChatContContent").innerHTML = this.responseText;
			if(fetchSidebarFriendsListIntervalFunction == null) {
				clearInterval(fetchSidebarChatIntervalFunction);
				fetchSidebarChatIntervalFunction = null;
				fetchSidebarFriendsListIntervalFunction = setInterval( function() { fetchSidebarFriendsList(); }, 500 );
				sidebarOnFriendsList = true;
			}
		}
	};
	xmlhttp.send();
}

function viewSidebarFriendsList() {
	$('#friendContBox').attr('style', '');
	$('#sgnChat').attr('style', 'display:none');
	clearInterval(fetchSidebarChatIntervalFunction);
	fetchSidebarChatIntervalFunction = null;
}

function fetchSidebarChat(friend_id) {
	var param = "friend_id=" + friend_id;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/sidebar_friend_chat_fetch.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("sgnChatContContent").innerHTML = this.responseText;
			if(fetchSidebarChatIntervalFunction == null) {
				clearInterval(fetchSidebarFriendsListIntervalFunction);
				fetchSidebarFriendsListIntervalFunction = null;
				fetchSidebarChatIntervalFunction = setInterval( function() { refreshSidebarChatMessages(friend_id); }, 500 );
				sidebarOnFriendsList = false;
			}
			// var objDiv = document.getElementById("sgnChat");
			// objDiv.scrollTop = objDiv.scrollHeight;
			// $("#sgnChat").scrollTop(document.getElementById("sgnChat").scrollHeight);
		}
	};
	xmlhttp.send(param);
	// alert(param);
}

function refreshSidebarChatMessages(friend_id) {
	var param = "friend_id=" + friend_id;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/sidebar_friend_chat_messages_refresh.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("messageContID").innerHTML = this.responseText;
		}
	};
	xmlhttp.send(param);
}

function viewSidebarChat() {
	$('#friendContBox').attr('style', 'display:none');
	$('#sgnChat').attr('style', '');
}

function sidebarSubmitNewMessage(chat_id) {
	var chat_message = $('#usermsg').val();
	var params = "chat_id=" + chat_id + "&chat_message=" + chat_message;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("POST", "php/sidebar_friend_chat_insert.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("chatTextCont").reset();
		}
	};
	xmlhttp.send(params);
}