

function fetchPosts(wall_owner_id) {
		var param = "wall_owner_id=" + wall_owner_id;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("homePage").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_posts_user.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(param);
}


function fetchNumReplies(post_id) {
	var numRepliesSpan = "num-replies-post_" + post_id;
	var param = "post_id=" + post_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// alert(this.responseText);
			try {
				document.getElementById(numRepliesSpan).innerHTML = this.responseText;
			}
			catch(err) {
				alert(err.message);
			}
			// alert("Printing span innerHTML");
			// alert(document.getElementById(numRepliesSpan).innerHTML);
		}
	};
	xmlhttp.open("POST", "php/fetch_num_replies.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}


function fetchReplies(post_id) {
	// alert(post_id);
	var replyModalID = "repliesModal_" + post_id;
	var param = "parent_post_id=" + post_id;
	// alert(replyModalID);
	// alert(param);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// alert(this.responseText);
			try {
				document.getElementById(replyModalID).innerHTML = this.responseText;
				// alert(replyModalID);
				// alert(document.getElementById(replyModalID).innerHTML);
			}
			catch(err) {
				alert(err.message);
			}
			// alert("Printing div innerHTML");
			// alert(document.getElementById(replyModalID).innerHTML);
		}
	};
	xmlhttp.open("POST", "php/fetch_replies_user.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function fetchUserBannerImage() {
	//alert((document.getElementsByClassName("sgnBanner"))[0].style.backgroundImage);var xmlhttp = new XMLHttpRequest();
	
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                (document.getElementsByClassName("sgnBanner"))[0].style.backgroundImage = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_user_banner.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}

function uploadUserBannerImage() {
	$("#bannerForm").submit();
	$("#bannerForm").reset();
	fetchUserBannerImage();
}


function updateInformationUser() {
	//alert((document.getElementsByClassName("sgnBanner"))[0].style.backgroundImage);var xmlhttp = new XMLHttpRequest();
	
	// alert("Start update information user");
	//var textarea_text = $(".postTextBox").val();
	var params = '';
	var first_set = false;
	if($("#new_email_text").val()) {
		params += ('new_email=' + $("#new_email_text").val());
		first_set = true;
	}
	if($("#new_username_text").val()) {
		if(first_set) {
			params += '&';
		}
		params += ('new_username=' + $("#new_username_text").val());
		first_set = true;
	}
	if($("#new_password_text").val()) {
		if(first_set) {
			params += '&';
		}
		params += ('new_password=' + $("#new_password_text").val());
		first_set = true;
	}
	if($("#new_first_name_text").val()) {
		if(first_set) {
			params += '&';
		}
		params += ('new_first_name=' + $("#new_first_name_text").val());
		first_set = true;
	}
	if($("#new_last_name_text").val()) {
		if(first_set) {
			params += '&';
		}
		params += ('new_last_name=' + $("#new_last_name_text").val());
	}

	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/update_information_user.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			start();
			$("#updateUserForm").reset();
			
		}
	};
	xmlhttp.send(params);
	
}

function resolveNotif(notification_id, action) {
	// action == 1 is accept
	// action == 0 is decline on_id=" + notification_id + "&action=" + action;
	var params = "notification_id=" + notification_id + "&action=" + action;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			fetchNotificationModal();
			fetchGroupList();
		}
    };
    xmlhttp.open("POST","php/process_notification.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function fetchCurrentUsername() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
	  document.getElementById("profileName").innerHTML=this.responseText;
	}
  };
  xmlhttp.open("POST","php/fetch_current_username.php",true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

function fetchUserProfileModal() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
		document.getElementById("profileModalContent").innerHTML = this.responseText;
	}
  };
	xmlhttp.open("POST","php/fetch_user_profile.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function fetchSearchResults() {
	if($("#search-input").val() != "") {
		var xmlhttp = new XMLHttpRequest();
		var param = "search_term=" + $("#search-input").val();
		xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			document.getElementById("searchModalBody").innerHTML = this.responseText;
		}
	  };
		xmlhttp.open("GET","php/search_results.php?" + param,true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send();
	}
}

function showTab(tabNum, entityID) {
	tabName = "";
	if(tabNum == "0") {
		tabName = "#home";
		fetchPosts(entityID);
	}
	if(tabNum == "1") {
		tabName = "#groups";
		fetchSingleGroup(entityID);
	}
	if(tabNum == "2") {
		tabName = "#events";
		fetchSingleEvent(entityID);
	}
	
	$('a[href="' + tabName + '"]').tab('show');
}


function fetchNotificationNumber() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
	  document.getElementById("notification_number").innerHTML=this.responseText;
	}
  };
  xmlhttp.open("POST","php/fetch_num_notifications.php",true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

function fetchNotificationModal() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
	if (this.readyState==4 && this.status==200) {
	  document.getElementById("notifsModalContent").innerHTML=this.responseText;
	}
  };
  xmlhttp.open("POST","php/my_notifications.php",true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

function addFriend(friended_id) {
	var param = "friended_id=" + friended_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			// buttonElement.className = "btn btn-secondary";
			// buttonElement.onclick = "function onclick(event) {}";
			// buttonElement.innerHTML = "Request Sent";
			fetchPosts(friended_id);
		}
	  };
	  xmlhttp.open("POST","php/friend_request_notification.php",true);
	  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  xmlhttp.send(param);
	// alert("Adding new friend");
}
function removeFriend(friended_id) {
	var param = "friended_id=" + friended_id;
	// alert(param);
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			fetchPosts(friended_id);
		}
	  };
	  xmlhttp.open("POST","php/remove_friend.php",true);
	  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  xmlhttp.send(param);
}