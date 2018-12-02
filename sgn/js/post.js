
// user post and user replies 
function createPost(parent_post_id, wall_owner_id) {
	var textarea_text = "";
	if(parent_post_id == "0") {
		textarea_text = $(".postTextBox").val();
	}
	else {
		var replyTextBox = "#replyTextBox_" + parent_post_id;
		// .innerHTML = this.responseText;
		textarea_text = $(replyTextBox).val();
	}
	var params = 'post_text=' + textarea_text;
	
	$("#replyTextBox_" + parent_post_id).val("");
	
	if(parent_post_id != "0") {
		params += ('&parent_post_id=' + parent_post_id);
	}
	params += ('&wall_owner_id=' + wall_owner_id);
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/new_user_post.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if(parent_post_id == "0") {
				fetchPosts(wall_owner_id);
				$(".postTextBox").val('');
			}
			else {
				fetchReplies(parent_post_id);
				fetchNumReplies(parent_post_id);
			}
		}
	};
	xmlhttp.send(params);
	
	
}




function createReply(post_id) {
	fetchReplies(post_id);
	fetchNumReplies(post_id);
}


function likeAction(element, post_id, wall_type) {
	// alert(wall_type);
	var current_count = parseInt(element.children[1].innerHTML);
	// alert(current_count);
	// alert("after");
	// alert("Before");
	// alert(element.children[1].id);
	// alert(post_id);
	// alert("After");
	var xmlhttp = new XMLHttpRequest();
	var params = "post_id=" + post_id;
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			// alert("Received");
			// alert(this.responseText);
			if(this.responseText == "Increase") {
				// alert("A");
				element.children[0].style.color = "blue";
				element.children[1].innerHTML = ++current_count;
			}
			else if(this.responseText == "Decrease Post") {
				// alert("Decrease");
				if(wall_type == "0") {
				// alert("B");
					element.children[0].style.color = "white";
				}
				else if(wall_type == "2") {
				// alert("C");
					element.children[0].style.color = "black";
				}
				element.children[1].innerHTML = --current_count;
			}
			else if(this.responseText == "Decrease Reply") {
				// alert("D");
				// alert("Decrease");
				element.children[0].style.color = "black";
				element.children[1].innerHTML = --current_count;
			}
		}
	};
	xmlhttp.open("POST", "php/process_vote.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}