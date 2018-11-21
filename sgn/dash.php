<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="css/dash.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<link rel="stylesheet" href="css/fontawesome/css/font-awesome.min.css">
	<link href="jqueryUI/jquery-ui.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
	<script src="js/popper.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="jqueryUI/jquery-ui.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>	
	<script src="js/dash.js"></script>
	<title>Social Gaming Network - Dashboard</title>
	
</head>
<script>
function fetchPosts() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("posts").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_posts_user.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}

function fetchEvents() {
		fetchEventList();
		fetchEventModals();
		fetchEventPosts();
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

function createPost(parent_post_id) {
	var textarea_text = "";
	if(parent_post_id == "0") {
		textarea_text = $(".postTextBox").val();
	}
	else {
		var replyTextBox = "#replyTextBox_" + parent_post_id;
		// .innerHTML = this.responseText;
		textarea_text = $(replyTextBox).val();
		alert(textarea_text);
	}
	var params = 'post_text=' + textarea_text;
	
	if(parent_post_id != "0") {
		params += ('&parent_post_id=' + parent_post_id);
	}
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "php/new_user_post.php", true);
	
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if(parent_post_id == "0") {
				fetchPosts();
				$(".postTextBox").val('');
			}
			else {
				alert(this.responseText);
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

function likeAction(element, post_id) {
	// alert("liked");
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
				// alert("Increase");
				element.children[0].style.color = "blue";
				element.children[1].innerHTML = ++current_count;
			}
			else if(this.responseText == "Decrease Post") {
				// alert("Decrease");
				element.children[0].style.color = "white";
				element.children[1].innerHTML = --current_count;
			}
			else if(this.responseText == "Decrease Reply") {
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

function updateInformationUser() {
	//alert((document.getElementsByClassName("sgnBanner"))[0].style.backgroundImage);var xmlhttp = new XMLHttpRequest();
	
	alert("Start update information user");
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
</script>

<script>

function start() {
	// alert("Starting");
	fetchPosts();
	// fetchEvents();
	// alert("Banner");
	fetchUserBannerImage();
	fetchNotificationNumber();
	fetchCurrentUsername();
	setInterval(fetchNotificationNumber, 1500);
	// alert("Done");
}

// Bind, works better than trigger
function tabClick() {
	var $link = $(this);
	if($link.attr("id") == "home-tab") {
		fetchPosts();
	}
	if($link.attr("id") == "esports-tab") {
		alert("Esport");
	}
	if($link.attr("id") == "groups-tab") {
		alert("group");
	}
	if($link.attr("id") == "events-tab") {
		fetchEvents();
	}
}
</script>

<!-- Start begin-->
<body onload="start();">
<!-- Start end-->
	<div class="loader"></div>
	<!-- Banner upload start -->
	<div class="sgnBanner">
		<div class="imageIcon" data-toggle="modal" data-target="#uploadBannerModal"><i class="fa fa-camera" id="cameraIcon" aria-hidden="true"></i></div>
		<!-- Upload Banner Modal -->
		<div class="modal fade" id="uploadBannerModal" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" style='color:black'>Upload Banner Image</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
			  <form id="bannerForm" action="php/upload_user_banner.php" method="post" enctype="multipart/form-data">
		      <div class="modal-body">
		        <p style='color:black'>Select an image to upload for your custom banner: </p>		        
				<input type="file" name="bannerImage" form="bannerForm" style='color:black'>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" onclick="uploadUserBannerImage()">Save changes</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
			  </form>
		    </div>
		  </div>
		</div>
	</div>
	<!-- Banner upload end -->
	<div class="sgnTabs">				
					<ul class="nav nav-tabs mr-auto flex-col flex-sm-row" id="dashTabs" role="tablist">
					  <li class="nav-item main-tabs">
					    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" onclick="fetchPosts()">SGN</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="esports-tab" data-toggle="tab" href="#esports" role="tab" aria-controls="esports" aria-selected="false">Esports</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups" aria-selected="false">Groups</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false" onclick="fetchEvents()">Events</a>
					  </li>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Search</a>
					  </li> -->
					  <li class="nav-item searchTab">
					  	<form class="searchBar">
		      				<input type="text" class="form-control" placeholder="Search.." name="search" data-toggle="modal" data-target="searchModal">
		      				<button id="searchSubmitBtn" type="submit" data-toggle="modal" data-target="searchModal"><i class="fa fa-search"></i></button>    				
		      				<!-- <button type="submit">Submit</button> -->

		   				 </form>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tournaments</a>
					  </li>-->
					  </li>
					  <li class="flex-sm-fill"></li>
					  <li class="nav-item main-tabs tab-icons">
						<!-- notification number update start -->
					    <a class="nav-link" id="notifs-tab" data-toggle="tab" href="#notifs" role="tab" aria-controls="notifs" aria-selected="false"><i class="fas fa-bullhorn"></i> <span id="notification_number">2</span></a>
						<!-- notification number update end -->
					    <a class="nav-link" id="settings-tab" data-toggle="modal" data-target="#settingsModal" href="#settings" role="tab" aria-controls="settings" aria-selected="false"><i class="fas fa-cog"></i></a>
					  </li>
					  <!-- <li class="nav-item main-tabs">
					    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="notifs" aria-selected="false"><i class="fas fa-bullhorn"></i> 4</a>
					  </li> -->					 
					  <li class="nav-item dropdown" id="profileLi" data-toggle="dropdown">					  	
					  	<a class="nav-link" id="profile-tab" data-toggle="dropdown-toggle"><img src="img/Profile-icon-9.png"></a>
					  	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
					  	  <a class="dropdown-item" id="profileName">TWICE_Nayeon</a>
				          <a class="dropdown-item" data-toggle="modal" data-target="#profileModal">Profile</a>
				          <a class="dropdown-item" href="#">Account</a>
				          <!-- <div class="dropdown-item"><a id="logoutDD" href="index.html">Logout</a></div> -->
				          <a class="dropdown-item" id="logoutDD" href="index.html">Logout</a>
				        </div>				        
					  </li>
					  <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
					  	<a class="dropdown" id="logoutDD" href="index.html">Logout</a>
					  </div>  -->				 
					</ul>
					<!-- Dropdown Profile Modal -->
					<div class="modal fade" id="profileModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Profile</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Modal body text goes here.</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary">Save changes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- Search Modal -->
					<!-- <div class="modal fade" id="searchModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Profile</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Modal body text goes here.</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary">Save changes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div> -->
					<!-- Settings Modal -->
					<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
						<!-- update information user start -->
						<form id="updateUserForm">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Settings</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="updateUserInfoCont">
					        	<div class="emailForm">New Email: <br><input type="text" id="new_email_text"></div>
					        	<div class="emailForm">New Username: <br> <input type="text" id="new_username_text"></div>
					        	<div class="emailForm">New Password: <br> <input type="text" id="new_password_text"></div>
					        	<div class="emailForm">New First Name: <br> <input type="text" id="new_first_name_text"></div>
					        	<div class="emailForm">New Last Name: <br> <input type="text" id="new_last_name_text"></div>
					        </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" onclick="updateInformationUser()">Save changes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
						</form>
						<!-- update information user end -->
					  </div>
					</div>					

			</div>
	<div class="contentCont" id="mainCont">
		<div class="tab-content" id="myTabContent">
			<!-- Dashboard Tab -->
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				<div class="createPostButtonCont" id="postButtonCont">
					<i class="far fa-plus-square" data-toggle="modal" data-target="#createPostModal"></i>
				</div>				
				<!-- Create Post Modal -->
				<div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Create Post</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <textarea class="postTextBox" placeholder="What's currently going on:" rows="6" cols="60"></textarea>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<!-- Create a post start -->
				        <button type="button" class="btn btn-primary" onclick="createPost(0)">Post!</button>
						<!-- Create a post end -->
				      </div>
				    </div>
				  </div>
				</div>
				<div class="tabWelcome">Dashboard</div>
				<!-- Fetch posts start -->
				<div id="posts"> </div>
				<!-- Fetch posts end -->
				<!-- Dialog for No Posts to show -->
				
				
				

				<div class="template-post">					
					<div class="image-buttons-container">						
						<div class='post-profile-image' data-toggle='modal' data-target='#dashProfileModal'></div>						
						<div class="post-profile-gap"></div>
						<div class="post-like-button">													
							<i class="far fa-thumbs-up" id="thumbsUpIcon"></i>							
							2.5M
						</div>						
						<div class="post-comment-button" data-toggle="modal" data-target="#commentsModal">							
							<i class="far fa-comments" id="commentsIcon"></i>
							33
						</div>
						<!-- User/Profile Modal -->
						
						<!-- Comments Modal -->
						<div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	<div class="commentCont">
					        		<div class="commentProfileImage"></div>
					        		<div class="commentPostGap"></div>
					        		<div class="commentPostName">Yoshi</div>
					        		<div class="commentPostDate">10/10/18</div>
					        		<div class="commentPostTime">4:20 PM</div>
					        		<div class="commentText">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="commentPostVoteButtons">
					        			<div class="commentPostUpvote">10 <i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="commentPostDownvote">2 <i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        		</div>
					        	</div>
						        <textarea class="postTextBox" placeholder="Write what's going on:" rows="6" cols="60"></textarea>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary">Post!</button>
						      </div>
						    </div>
						  </div>
						</div>
					</div>						
					<div class="post-text-container">						
						<div class="post-date-time">
							<span class="profile-name">Yoshi</span>
							Today - 9:17 PM </div>
						<div class="post-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. 
						</div>
						<div class="post-picture"></div>
					</div>					
				</div>
				
				<div class="modal fade" id="dashProfileModal" tabindex="-1" role="dialog">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="profileModalUname">Profile</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <h2 class="profileTitle">Raios</h2>
						        <div class="profileModalImage"></div>
						        <div class="profileUserName">Name: Justin Ha</div>
						        <div class="profileEmail">Email: justinsucks@yahoo.com</div>
						        <div class="uploadImageSection">Change profile picture: <input type="file" name="bannerFile"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary">Save changes</button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>
<!-- 				<div class="template-post">
					<div class="image-buttons-container">
						<div class="post-profile-image"></div>						
						<div class="post-profile-gap"></div>
						<div class="post-like-button">													
							<i class="far fa-thumbs-up" id="thumbsUpIcon" onclick="thumbsUpFunc()"></i>							
							1
						</div>						
						<div class="post-comment-button" data-toggle="modal" data-target="#commentsModal">							
							<i class="far fa-comments" id="commentsIcon"></i>
							2
						</div>
					</div>						
					<div class="post-text-container">
						<div class="post-date-time">
							<span class="profile-name">Rathalos09</span>
							Today - 10:15 PM </div>
						<div class="post-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, 
						</div>
					</div>					
				</div> -->
				<!-- Search Results hidden by default unless searched -->
				<div class="searchResults" id="searchContent">
					<h1 class="searchTitle">Search Results for: </h1><h2 class="searchQuery">Something typed in search bar</h2>
					<div class="searchResultsBox"></div>
				</div>
			</div>	
			<!-- Esports Tab -->
		  	<div class="tab-pane fade" id="esports" role="tabpanel" aria-labelledby="esports-tab">
		  		<div class="tabWelcome">Esports</div>
		  		<!-- Esports Viewing Container -->
		  		<div class="esportsCont">
			  		<div class="esportsTemplate">
			  			<div class="esportsTitle">List of Esports Games</div>
			  			<div class="esportsList">
			  				League of Legends<br><a data-toggle="modal" data-target="#leagueStreamModal"><img class="leagueIcon" src="img/lol-icon.png"></a><br>Counter-Strike: Global Offensive<br><a data-toggle="modal" data-target="#csgoStreamModal"><img class="csgoIcon" src="img/csgo-icon.png"></a><br>Overwatch<br><a data-toggle="modal" data-target="#owStreamModal"><img class="owIcon" src="img/ow-icon.png"></a><br>Heroes of the Storm<br><a data-toggle="modal" data-target="#hotsStreamModal"><img class="hotsIcon" src="img/hots-icon.png"></a><br>Starcraft II<br><a data-toggle="modal" data-target="#sc2StreamModal"><img class="sc2Icon" src="img/sc2-icon.png"><br></a>
			  			</div>
			  			<!-- Esports Modals -->			  			
			  			<div class="esportsModals">
			  				<!-- League Modal -->
							<div class="modal fade" id="leagueStreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content modal-1200">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">League of Legends Stream</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body" id="esportModalBody">
							        <div class="streamCont">
							        	<div class="streamVideo"></div>
							        </div>
							        <div class="streamChatCont">
							        	<div class="streamChat"></div>
							        </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>
							<!-- CS Modal -->
							<div class="modal fade" id="csgoStreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content modal-1200">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Counter-Strike: Global Offensive Stream</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body" id="esportModalBody">
							        <div class="streamCont">
							        	<div class="streamVideo"></div>
							        </div>
							        <div class="streamChatCont">
							        	<div class="streamChat"></div>
							        </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>
							<!-- OW Modal -->
							<div class="modal fade" id="owStreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content modal-1200">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Overwatch Stream</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body" id="esportModalBody">
							        <div class="streamCont">
							        	<div class="streamVideo"></div>
							        </div>
							        <div class="streamChatCont">
							        	<div class="streamChat"></div>
							        </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>
							<!-- HOTS Modal -->
							<div class="modal fade" id="hotsStreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content modal-1200">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Heroes of the Storm Stream</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body" id="esportModalBody">
							        <div class="streamCont">
							        	<div class="streamVideo"></div>
							        </div>
							        <div class="streamChatCont">
							        	<div class="streamChat"></div>
							        </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>
							<!-- SC2 Modal -->
							<div class="modal fade" id="sc2StreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg" role="document">
							    <div class="modal-content modal-1200">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Starcraft II Stream</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <div class="modal-body" id="esportModalBody">
							        <div class="streamCont">
							        	<div class="streamVideo"></div>
							        </div>
							        <div class="streamChatCont">
							        	<div class="streamChat"></div>
							        </div>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>							
						</div>
			  		</div>

			  	</div>
			  	<!-- Esports News Container -->
			  	<div class="esportsNewsCont">
			  		<div class="esportsTitle">Esports News</div>
			  		<div class="esportsNewsTemplatePost">
			  			
			  		</div>
			  	</div>		  		
		  	</div>
		  	<!-- Groups Tab -->
		  	<div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
		  		<div class="tabWelcome">Groups</div>
		  		List of groups and maybe other content
		  	</div>
			<!-- Events Tab -->
			
		  	<div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
		  		<div class="tabWelcome">Events</div>
				<!-- Fetch Events Start -->
				<!-- The div in which events list is loaded -->
				<div id="events_list"> </div>
				
				<div id="events_modal"> </div>
				
				<div id="events_post"> </div>
			<!-- Fetch Events End -->
		  		<div class="eventCont">
		  			<div class="templateEvent">
		  				<div class="eventHeaderCont">		  					
			  				<div class="eventTitle">Kyle's D&D Meetup</div>
			  				<div class="eventShortDesc">Just hanging out for today, meet at 6pm for quests.</div>		  							  
			  			</div>
			  			<div class="eventDateTimePrivCont">
			  				<div class="eventDate">November 3, 2018</div>
		  					<div class="eventTime">6:00 PM</div>		  				
		  					<div class="eventPrivacy">Public</div>
			  			</div>
			  			<div class="eventViewPostsButtons">
			  				<button type="button" class="btn btn-primary" id="eventButton" data-toggle="modal" data-target="#futureEventModal">View</button>
			  				<button type="button" class="btn btn-primary" id="tournamentButton" data-toggle="modal" data-target="#tournamentModal">Tournament</button>
			  				<button type="button" class="btn btn-primary" id="eventPosts" data-toggle="modal" data-target="#eventPostsModal">Posts</button>			  
			  			</div>
		  			</div>
		  		</div>
		  		<div class="futureEventTitle">Past Events</div>
		  		<div class="futureEventCont">
		  			<div class="templateEvent">
		  				<div class="eventHeaderCont">		  					
			  				<div class="eventTitle">Kyle's D&D Meetup</div>
			  				<div class="eventShortDesc">Just hanging out for today, meet at 6pm for quests.</div>		  							  
			  			</div>
			  			<div class="eventDateTimePrivCont">
			  				<div class="eventDate">November 3, 2018</div>
		  					<div class="eventTime">6:00 PM</div>		  				
		  					<div class="eventPrivacy">Public</div>
			  			</div>
			  			<div class="eventViewPostsButtons">
			  				<button type="button" class="btn btn-primary" id="eventButton" data-toggle="modal" data-target="#futureEventModal">View</button>
			  				<button type="button" class="btn btn-primary" id="tournamentButton" data-toggle="modal" data-target="#tournamentModal">Tournament</button>
			  				<button type="button" class="btn btn-primary" id="eventPosts" data-toggle="modal" data-target="#eventPostsModal">Posts</button>			  
			  			</div>
		  			</div>
		  		</div>
		  		<div class="eventsModals">
		  			<!-- Event Modal -->
		  			<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Kyle's D&D Meetup</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="modalEventInfoCont">
					        	<!-- should disappear if the event hasnt started -->
					        	<div class="modalEventStartedWarning">Note: Event has already started!</div>
					        	<h1 id="modalEventDescTitle">Description</h1>					        	
					        	<div class="modalEventDesc">Just hanging out for today, meet at 6pm for quests.</div>
					        	<h1 id="modalEventDateTime">Date/Time</h1>
					        	<div class="eventDate">November 3, 2018</div>
		  						<div class="eventTime">6:00 PM</div>
					        </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" id="eventSignUpButton">Sign Up</button>
					        <button type="button" class="btn btn-primary" id="eventLeaveButton">Leave</button>					        
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
					<div class="modal fade" id="futureEventModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Kyle's D&D Meetup</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="modalEventInfoCont">
					        	<!-- should disappear if the event hasnt started -->
					        	<div class="modalEventStartedWarning">Note: Event has already started!</div>
					        	<h1 id="modalEventDescTitle">Description</h1>					        	
					        	<div class="modalEventDesc">Just hanging out for today, meet at 6pm for quests.</div>
					        	<h1 id="modalEventDateTime">Date/Time</h1>
					        	<div class="eventDate">November 3, 2018</div>
		  						<div class="eventTime">6:00 PM</div>		  						
					        </div>
					      </div>
					      <div class="modal-footer">					      	
					        <button type="button" class="btn btn-primary" id="eventSignUpButton">Sign Up</button>
					        <button type="button" class="btn btn-primary" id="eventLeaveButton">Leave</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>  
		  		</div>
		  		<!-- Tournament Modals -->
		  		<div class="tournamentModals">
					<div class="modal fade" id="tournamentModal" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title">Tournament Name</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <h1 class="tournamentTitle">Kyle's D&D Meetup</h1>
						        <h2 class="tournamentDate">12/07/18</h2>
						        <h2 class="tournamentTime">6:00 PM</h2>
						        <div class="participantsCont">
						        	<div class="participantsTitle">Number of Participants: <div class="numberParticipants">5</div></div>
						        	<div class="currentParticipantsTitle">Current Participants: </div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">1</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Yoshi</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">2</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Yoshi's alter ego</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">3</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Cock Munch</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">4</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Big Dick Energy</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">5</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Paul's Fantasy</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">6</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">My wet wee wee</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">7</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Dog Shit</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">8</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">PaulDSSB</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">9</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Cockhead92</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">10</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">ExpandDong</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">11</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">BlazeChar</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">12</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Kobold.Kim</div>
						        	</div>
						        	<div class="contenderCont">
						        		<div class="contenderNum">13</div>
						        		<div class="contenderImage"></div>
						        		<div class="contenderName">Trash</div>
						        	</div>
						        </div>					        
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary">Save changes</button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>					  	
						</div>						
		  			</div>
		  		</div>
		  		<!-- Event Posts Modals -->
		  		<div class="eventPostsModals">
					<div class="modal fade" id="eventPostsModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Event Posts</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <div class="modalEventInfoCont">
					        	<!-- should disappear if there are no posts -->
					        	<div class="modalEventStartedWarning">No posts to show</div>
					        	<div class="eventPostCont">
					        		<div class="eventPostProfileImage"></div>
					        		<div class="eventPostGap"></div>
					        		<div class="eventPostName">Yoshi</div>
					        		<div class="eventPostDate">10/10/18</div>
					        		<div class="eventPostTime">4:20 PM</div>
					        		<div class="eventPostComment">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="eventPostVoteButtons">					        			
					        			<div class="eventPostUpvote">10M<i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote">15K<i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        			<button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button>
					        		</div>
					        	</div>
					        	<div class="eventPostCont">
					        		<div class="eventPostProfileImage"></div>
					        		<div class="eventPostGap"></div>
					        		<div class="eventPostName">Yoshi</div>
					        		<div class="eventPostDate">10/10/18</div>
					        		<div class="eventPostTime">4:20 PM</div>
					        		<div class="eventPostComment">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="eventPostVoteButtons">					        			
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        			<button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button>
					        		</div>
					        	</div>
					        	<div class="eventPostCont">
					        		<div class="eventPostProfileImage"></div>
					        		<div class="eventPostGap"></div>
					        		<div class="eventPostName">Yoshi</div>
					        		<div class="eventPostDate">10/10/18</div>
					        		<div class="eventPostTime">4:20 PM</div>
					        		<div class="eventPostComment">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="eventPostVoteButtons">					        			
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        			<button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button>
					        		</div>
					        	</div>
					        	<div class="eventPostCont">
					        		<div class="eventPostProfileImage"></div>
					        		<div class="eventPostGap"></div>
					        		<div class="eventPostName">Yoshi</div>
					        		<div class="eventPostDate">10/10/18</div>
					        		<div class="eventPostTime">4:20 PM</div>
					        		<div class="eventPostComment">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="eventPostVoteButtons">					        			
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        			<button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button>
					        		</div>
					        	</div>
					        	<div class="eventPostCont">
					        		<div class="eventPostProfileImage"></div>
					        		<div class="eventPostGap"></div>
					        		<div class="eventPostName">Yoshi</div>
					        		<div class="eventPostDate">10/10/18</div>
					        		<div class="eventPostTime">4:20 PM</div>
					        		<div class="eventPostComment">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</div>
					        		<div class="eventPostVoteButtons">					        			
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" id="handUp" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" id="handDown" aria-hidden="true"></i></div>
					        			<button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button>
					        		</div>
					        	</div>					        	
					        </div>
					      </div>
					      <div class="modal-footer">					      						        
					        <!-- <button type="button" class="btn btn-primary" id="eventReplyButton">Reply</button> -->
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>		  			
		  		</div>		  		
		  	 </div>
		</div>
		<!-- <div class="afterHidden"></div> -->
		<div class="sgnChatCont">
			<!-- <div class="afterHiddenSelector"></div> -->
			<div id="resizer">
                <div id="resizerIcon">|||</div>
            </div>

			<div class="sgnChatBox" id="rightCont">
				<div id="wrapper">
					<div id="friendPanel">
					
					</div>
					<div id="chatbox"></div>
					<form name="message" action="">
						<input name="usermsg" type="text" id="usermsg" size="63"/>
						<input name="submitmsg" type="submit" id="submitmsg" value="Send"/>
					</form>
				</div>
				<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
				<script type="text/javascript">
				//jQuery Document
				//$(document).ready(function()
				//{
			    //
				//});
				</script> -->
			</div>
		</div>	
	</div>			
	<!-- <div class="tabsContent"></div> -->
	<!-- <div class="sgnChatCont">
		<div class="sgnChatBox"></div>
	</div> -->

</body>
</html>