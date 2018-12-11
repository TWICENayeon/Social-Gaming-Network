function fetchGroupStuff() {
	fetchGroupList();
	fetchGroupMembersModals();
	fetchGroupEventsModals();
}

function fetchGroupList() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("groupList").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/fetch_group_list.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function changeGroupInfo() {
	alert('hello hello hello');
}

function createGroup() {
	alert("Creating group");
	alert($(".createGroupTitle").val());
	alert($(".createGroupPicture").val());
}

function leaveGroup(group_id) {
	var param = "group_id=" + group_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			fetchGroupList();
		}
	};
	xmlhttp.open("POST", "php/group_process_leave.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

// fetches all the membership modals for all the groups
// Should only have one main member modal and have 
// specific things load into that instead
function fetchGroupMembersModals() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("groupMembersModals").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/group_members_modals_fetch.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}


function refreshGroupMemberModal(group_id) {
	var param = "group_id=" + group_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("groupMembersBodyContent_" + group_id).innerHTML = this.responseText;
			
		}
	};
	xmlhttp.open("POST", "php/groups_member_modal_refresh.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function processNewMemberRole(group_id, member_id, new_role) {
	var params = "group_id=" + group_id + "&member_id=" + member_id + "&new_role=" + new_role;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			refreshGroupMemberModal(group_id);
		}
	};
	xmlhttp.open("POST", "php/groups_new_role_process.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
	
}


function fetchGroupEventsModals() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("groupEventModals").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/group_event_modals_fetch.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send();
}

function refreshGroupEventModal(group_id) {
	var param = "group_id=" + group_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("listEventsCont_" + group_id).innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/groups_event_modal_refresh.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function processAttendance(event_id, attendance, group_id) {
	var params = "event_id=" + event_id + "&attendance=" + attendance;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			refreshGroupEventModal(group_id);
		}
	};
	xmlhttp.open("POST", "php/event_process_attendance.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function createNewEvent(group_id) {
	var newEventName = $("#newEventTitle_" + group_id).val();
	var newEventDate = $("#newEventDate_" + group_id).val();
	var newEventTime = $("#newEventTime_" + group_id).val();
	var newEventDescription = $("#newEventDescription_" + group_id).val();
	var params = "group_id=" + group_id + "&new_event_name=" + newEventName + "&new_event_date=" + newEventDate + "&new_event_time=" + newEventTime + "&new_event_description=" + newEventDescription;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			alert(this.responseText);
			refreshGroupEventModal(group_id);
		}
	};
	xmlhttp.open("POST", "php/group_new_event.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}

function fetchSingleGroup(group_id) {
	var param = "group_id=" + group_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("groupList").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("POST", "php/fetch_group_single.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function joinGroup(group_id) {
	var param = "group_id=" + group_id;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			alert(this.responseText);
			fetchSingleGroup(group_id);
		}
	};
	xmlhttp.open("POST", "php/group_join.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(param);
}

function inviteUserToGroup(group_id) {
	var invited_username = $("#invited_to_group_" + group_id).val();
	var params = "group_id=" + group_id + "&invited_username=" + invited_username;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			refreshGroupMemberModal(group_id);
		}
	};
	xmlhttp.open("POST", "php/invite_to_group.php", true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}