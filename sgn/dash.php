<?php
	// Gain access to session array
	session_start();
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.html");
		exit();
	}

?>

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
	<script src="js/post.js"></script>
	<script src="js/event.js"></script>
	<script src="js/tournament.js"></script>
	<script src="js/group.js"></script>
	<script src="js/user_page.js"></script>
	<script src="js/esports.js"></script>
	<script src='https://embed.twitch.tv/embed/v1.js'></script>
	<title>Social Gaming Network - Dashboard</title>
	

</head>
<script>

// Group Functions Start


// Group Functions End
</script>

<script>
// Bind, works better than trigger
// Does not work


function start() {
	
}



$(document).ready(function(){
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  console.log(activeTab);
  if (activeTab) {
    $('a[href="' + activeTab + '"]').tab('show');
  }
  // $(".loader").fadeOut(1500);
	// var chatContPos = $(".sgnChatCont").position();
 //  	// console.log(chatContPos);
 //  	var buttonPos = $(".createPostButtonCont");
 //  	buttonPos.css("left", chatContPos.left - 100);
 //  	$( window ).resize(function() {
 //  		var chatContPos = $(".sgnChatCont").position();
 //  		// console.log(chatContPos);
 //  		var buttonPos = $(".createPostButtonCont");
 //  		buttonPos.css("left", chatContPos.left - 100);
 //  		if ($(".sgnChatCont").is(":hidden")) {
 //  			buttonPos.css("left", "100vw").css("left", "-=120px");
 //  		} 
	// });
	// $( ".sgnChatCont" ).resizable({
 //  		handles: { w:'.selector'},
 //  		resize: function( event, ui ) {
 //  			if (ui.size.width <= 10) {
 //  				$(this).hide();
 //  				$(".selector").appendTo($(".afterHidden"));  				  				
 //  			}
 //  			else {
 //  				$(this).show();
 //  				$(".selector").appendTo($(".afterHiddenSelector"));
 //  				var chatContPos = $(".sgnChatCont").position();
 //  				// console.log(chatContPos);
 //  				var buttonPos = $(".createPostButtonCont");
 //  				buttonPos.css("left", chatContPos.left - 100);
 //  			}  		  			

 //  		}  		
	// });
	// $(".sgnChatCont").resizable({
	// 	resize: function( event, ui ) {
	// 		if $(".selector").appendTo($(".afterHidden")) {
	// 			$(this).show();
	// 			$(".selector").appendTo($(".afterHiddenSelector"));
	// 		}
	// 	}
	// });	
	// $(".selector").click(function() {	
	// 	if ($(".sgnChatCont").css("display") == "none") {
	// 		$(".sgnChatCont").show();
	// 		$(".sgnChatCont").css("width", "35em");
	// 		$(".selector").appendTo($(".afterHiddenSelector"));
	// 		var chatContPos = $(".sgnChatCont").position();
 //  			// console.log(chatContPos);
 //  			var buttonPos = $(".createPostButtonCont");
 //  			buttonPos.css("left", chatContPos.left - 100);			
	// 	}
 //  });
  document.getElementById("resizer").addEventListener("mousedown", addMousemove);

  function addMousemove (d) {
    console.log("movable")
    document.addEventListener("mousemove", widthDriver)
  }
  // document.addEventListener("mouseup", removeMove);
  function widthDriver(e) {
      document.addEventListener("mouseup", removeMove);
      var width = e.screenX;
      if (width > window.innerWidth - 260) {
          width = window.innerWidth - 8;
          document.getElementById("rightCont").style.display = "none";
            document.getElementById("resizer").removeEventListener("mousedown", addMousemove);
            document.getElementById("postButtonCont").style.textAlign = "right";
          
      }            
      else {
        document.getElementById("rightCont").style.display = "block";  
      }
      if (width < 8) {
          width = 8;
      }      
      document.getElementById("myTabContent").style.width = (width + 6) + "px";
      document.getElementById("rightCont").style.width = (document.getElementById("mainCont").clientWidth - width - 6) + "px";
  }
  function removeMove(e) {
      document.removeEventListener("mousemove", widthDriver);
      document.removeEventListener("mouseup", removeMove);
  }
  document.getElementById("resizer").addEventListener("click", popChat);
  // document.getElementById("resizer").addEventListener("mousedown", addMousemove)
  function popChat(e) {
    console.log("clickable")
      if (document.getElementById("rightCont").style.display == "none") {
        document.getElementById("rightCont").style.width = "261px";
        document.getElementById("rightCont").style.display = "block"; } 
        document.getElementById("resizer").addEventListener("mousedown", addMousemove); 
  }
  
  // $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
  //   localStorage.setItem('activeTab', $(e.target).attr('href'));
  // });

  // var activeTab = localStorage.getItem('activeTab');
  // console.log(activeTab);
  // if (activeTab) {
  //  $('a[href="' + activeTab + '"]').tab('show');
  // }
//   $(function() {
//       $('ul.tabs li:first').addClass('active').show();
//       $('div.tab_content:first').show();
//       $('ul.tabs li').click(function() {
//             $('ul.tabs li').removeClass('active');
//             $(this).addClass('active');
//             $('div.tab_content').hide();
//             var activeTab = $(this).find('a').attr('href'); 
//             $(activeTab).show(); 
//             $.cookie('selectedTab', activeTab, {expires: 7}); // Save active tab in cookie
//             return false;
//       });
//       var activeTab = $.cookie('selectedTab'); // Retrieve active tab
//       if (activeTab) {
//             $('ul.tabs li:has(a[href="' + activeTab + '"])').click(); // And simulate clicking it
//       }

  if (document.getElementById("thumbsUpIcon") != null) {
    document.getElementById("thumbsUpIcon").addEventListener("click", thumbsUpFunc);
    function thumbsUpFunc() {
      document.getElementById("thumbsUpIcon").style.color = "#1E90FF";    
    }
  }
  document.getElementById("handUp").addEventListener("click", voteUpFunc);
  function voteUpFunc() {
    document.getElementById("handUp").style.color = "#1E90FF";
  }
  document.getElementById("handDown").addEventListener("click", voteDownFunc);
  function voteDownFunc() {
    document.getElementById("handDown").style.color = "#1E90FF";
  }
  // document.getElementById("logoutDD").addEventListener("click", logoutFunc);
  // function logoutFunc {

  // }
  // Search Bar Functionality
  // $("#searchSubmitBtn").click(function() {
    // var searchContent = $("#searchContent");    
    // var contentBox = $("#myTabContent");    
    // // contentBox.html(' ');
    // alert();    
    // contentBox.appendTo(searchContent);
    // // contentBox.show();
    // return false;    

  // });
  // searchContent = $("#searchContent"); 
  // var contentBox = $("#myTabContent");
  // contentBox.html('');
  // contentBox.appendTo(searchContent);

	// alert("Posts");
	fetchPosts(<?php echo $_SESSION["current_user_id"]; ?>);
	// alert("Events");
	// fetchEvents();
	// alert("Banner Image");
	fetchUserBannerImage();
	// alert("Notification Number");
	fetchNotificationNumber();
	// alert("Notification modal");
	fetchNotificationModal();
	// alert("Current username");
	fetchCurrentUsername();
	// alert("Profile");
	fetchUserProfileModal();
	fetchEsportsModals();
	fetchEvents();
	// fetchEsportsModals();
	
	setInterval(fetchNotificationNumber, 1500);
	setInterval(fetchNotificationModal, 1500);
	fetchGroupStuff();

  setTimeout(function(){ 
    $(".loader").delay(150).fadeOut("slow");
  // $(".loader").delay().fadeOut("slow");
  }, 200)
});

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
					    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" onclick="fetchPosts(<?php echo $_SESSION["current_user_id"]; ?>)">SGN</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="esports-tab" data-toggle="tab" href="#esports" role="tab" aria-controls="esports" aria-selected="false" onclick="fetchEsportsModals()">Esports</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups" aria-selected="false" onclick="fetchGroupStuff()">Groups</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false" onclick="fetchEvents()">Events</a>
					  </li>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Search</a>
					  </li> -->
					  <li class="nav-item searchTab">
					  	<form class="searchBar">
		      				<input type="text" class="form-control" id="search-input" placeholder="Search.." name="search">
		      				<button id="searchSubmitBtn" type="button" data-toggle="modal" onclick='fetchSearchResults()' data-target="#searchModal"><i class="fa fa-search"></i></button>    				
		      				<!-- <button type="submit">Submit</button> -->

		   				 </form>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tournaments</a>
					  </li>-->
					  </li>
					  <li class="flex-sm-fill"></li>
					  <li class="nav-item main-tabs tab-icons">
						<!-- notification number update start -->
					    <a class="nav-link" id="notifs-tab" data-toggle="modal" data-target="#notifsModal" href="#notifs" role="tab" aria-controls="notifs" aria-selected="false"><i class="fas fa-bullhorn"></i> <span id="notification_number">2</span></a>
						<!-- notification number update end -->
					    <a class="nav-link" id="settings-tab" data-toggle="modal" data-target="#settingsModal" href="#settings" role="tab" aria-controls="settings" aria-selected="false"><i class="fas fa-cog"></i></a>
					  </li>
					  <!-- <li class="nav-item main-tabs">
					    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="notifs" aria-selected="false"><i class="fas fa-bullhorn"></i> 4</a>
					  </li> -->					 
					  <li class="nav-item main-tabs tab-icons">					  	
					  	<a class="nav-link" id="profile-tab" data-toggle="modal" data-target="#profileModal" role="tab" aria-controls="profile" aria-selected="false"><img src="img/Profile-icon-9.png"></a>
					  	<a class="nav-link" id="logoutDD" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fas fa-power-off"></i></a>
					  </li>
					  <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
					  	<a class="dropdown" id="logoutDD" href="index.html">Logout</a>
					  </div>  -->				 
					</ul>
					<!-- Logout Modal -->
					<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Logout</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <h2> Note </h2>
					        <p>Do you wish to logout?
					      </div>
					      <div class="modal-footer">
							<form action="php/process_logout.php">
					        <input type="submit" class="btn btn-primary" value="Yes">
							</form> 
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- Dropdown Profile Modal -->
					<div class="modal fade" id="profileModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content" id="profileModalContent">
					      <div class="modal-header">
					        <h5 class="modal-title">Profile</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <h2 class="profileTitle">Whyos</h2>
						        <div class="profileModalImage"></div>
						        <div class="profileUserName">Name: Justin Ha</div>
						        <div class="profileEmail">Email: justinsucks@yahoo.com</div>
						        <div class="uploadImageSection">Change profile picture: <input id="uploadPictureButton" type="file" name="bannerFile"></div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary">Save changes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- Search Modal -->
					<div class='modal fade' id='searchModal' tabindex='-1' role='dialog'>
					  <div class='modal-dialog modal-lg' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title'>Search Results</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body' id='searchModalBody'>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
					      </div>
					    </div>
					  </div>
					</div>
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
					<!-- Notifications Modal -->
					<div class="modal fade" id="notifsModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Your Notifications</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body" id="notifsModalContent">
						  </div>
					      <div class="modal-footer">
					        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					      </div>
					    </div>
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
				<!-- Fetch posts start -->
				<div id="homePage"> </div>
				<!-- Fetch posts end -->
				<!-- Dialog for No Posts to show -->
			
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
			  			<div class="esportsModals" id="mainEsportsModals">						
						</div>
			  		</div>

			  	</div>
			  	<!-- Esports News Container -->
			  	<!-- <div class="esportsNewsCont">
			  		<div class="esportsTitle">Esports News</div>
			  		<div class="esportsNewsTemplatePost">
			  			
			  		</div>
			  	</div>	 -->	  		
		  	</div>
		  	<!-- Groups Tab --><div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
		  		<br>
		  			  		
		  		<div class="groupsCont">
		  			<!-- Template Group -->
					<div id="groupList"> 
						<div class="templateGroup">
							<div class="groupHeaderCont">
								<div class="groupTitle">BlazeChar's Zard Lords</div>
								<div class="group-image"></div>
							</div>
							<br>
							<div class="groupButtons">
								<button type="button" class="btn btn-primary" id="groupJoinButton" data-toggle="modal" data-target="#groupJoinModal">Join</button>
								<button type="button" class="btn btn-primary" id="groupPictureButton" data-toggle="modal" data-target="#groupPictureModal">Change Name/Picture</button>
								<button type="button" class="btn btn-primary" id="groupEventsButton" data-toggle="modal" data-target="#groupEventModal">Events</button>													
								<button type="button" class="btn btn-primary" id="groupMembersButton" data-toggle="modal" data-target="#groupMembersModal">See Members</button>
								<button type="button" class="btn btn-primary" id="groupLeaveButton" data-toggle="modal" data-target="#groupLeaveModal">Leave Group</button>
							</div>
						</div>
						<div class="templateGroup">
							<div class="groupHeaderCont">
								<div class="groupTitle">BlazeChar's Zard Lords</div>
								<div class="group-image"></div>
							</div>
							<br>
							<div class="groupButtons">
								<button type="button" class="btn btn-primary" id="groupJoinButton" data-toggle="modal" data-target="#groupJoinModal">Join</button>
								<button type="button" class="btn btn-primary" id="groupPictureButton" data-toggle="modal" data-target="#groupPictureModal">Change Name/Picture</button>
								<button type="button" class="btn btn-primary" id="groupEventsButton" data-toggle="modal" data-target="#groupEventModal">Events</button>													
								<button type="button" class="btn btn-primary" id="groupMembersButton" data-toggle="modal" data-target="#groupMembersModal">See Members</button>
								<button type="button" class="btn btn-primary" id="groupLeaveButton" data-toggle="modal" data-target="#groupLeaveModal">Leave Group</button>
							</div>
						</div>
						<!-- Template Group -->
						<!-- Template Group -->
					</div>
		  			<!-- Group Modals -->
					<!-- Join Modal -->
					<div id="groupJoinModals">
					<div class="modal fade" id="groupJoinModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Join Group</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <h2> Note </h2>
					        <p>Would you like to join </p><div class="groupName">Blazechar's Zard Lords</div>
					        <div class="group-image"></div>	
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					      </div>
					    </div>
					  </div>
					</div>
					</div>
					<!-- Change name/picture modal -->
					<!-- Group Events Modal -->		
					<div id="groupEventModals">
						<div class="modal fade" id="groupEventModal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title">Events</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <div class="modal-body">
									<div class="createEventHeader">Create Event</div>
									<div class="createEventCont">
										<form class="createEventForm">						        
											<div class="createEventTitle">Event Title: <input type="text"></div>
											<div class="createEventDate">Event Date (mm/dd/yy): <input type="text"></div>
											<div class="createEventTime">Event Time: <input type="text"></div>
										</form>
									</div>
									<br>
								  </div>
								  <div class="modal-footer">						        
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								  </div>
								</div>					  	
							</div>						
						</div>
					</div>
		  			<!-- Group Members Modal -->
					<div id="groupMembersModals">
		  			<div class="modal fade" id="groupMembersModal" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title">Group Members</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">						      							        
						        <div class="listEventsCont">
									<div class='groupEventsDialog'>Hello Admin!</div>
									<div class="groupEventsDialog">No members joined just yet!</div>
									<div class="contenderContBox">
										<div class="groupEventsTitle">Admins</div>
							        	<div class="contenderCont">							        		
							        		<div class="contenderImage"></div>
							        		<div class="contenderName">Yoshi</div>
							        		<div class="groupPromoteButtons">
							        			<button type="button" class="btn btn-primary">Promote</button>
							        			<button type="button" class="btn btn-primary">Demote</button>
							        		</div>
							        	</div>
							        	<div class="contenderCont">							        		
							        		<div class="contenderImage"></div>
							        		<div class="contenderName">Yoshi's alter ego</div>
							        		<div class="groupPromoteButtons">
							        			<button type="button" class="btn btn-primary">Promote</button>
							        			<button type="button" class="btn btn-primary">Demote</button>
							        		</div>
							        	</div>
							        </div>	
									<div class="contenderContBox">
										<div class="groupEventsTitle">Members</div>
							        	<div class="contenderCont">							        		
							        		<div class="contenderImage"></div>
							        		<div class="contenderName">Cock Munch</div>
							        		<div class="groupPromoteButtons">
							        			<button type="button" class="btn btn-primary">Promote</button>
							        			<button type="button" class="btn btn-primary">Demote</button>
							        		</div>
							        	</div>
							        	<div class="contenderCont">							        		
							        		<div class="contenderImage"></div>
							        		<div class="contenderName">Big Dick Energy</div>
							        		<div class="groupPromoteButtons">
							        			<button type="button" class="btn btn-primary">Promote</button>
							        			<button type="button" class="btn btn-primary">Demote</button>
							        		</div>
							        	</div>
							        	<div class="contenderCont">							        		
							        		<div class="contenderImage"></div>
							        		<div class="contenderName">Paul's Fantasy</div>
							        		<div class="groupPromoteButtons">
							        			<button type="button" class="btn btn-primary">Promote</button>
							        			<button type="button" class="btn btn-primary">Demote</button>
							        		</div>
							        	</div>
							        </div>									
						        </div>
						      </div>
						      <div class="modal-footer">						        
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>					  	
						</div>						
		  			</div>
					</div>
		  			<!-- Leave Group Modal -->
		  			<div class="modal fade" id="groupLeaveModal" tabindex="-1" role="dialog">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Leave Group</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <h2> Warning </h2>
					        <p>Are you sure you want to leave the group:  </p><div class="groupName">Blazechar's Zard Lords</div>
					        <div class="group-image"></div>	
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					      </div>
					    </div>
					  </div>
					</div>
		  		</div>
		  		
		  	</div>
			<!-- Events Tab -->
			
		  	<div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
		  		<div class="tabWelcome">Events</div>

				
				<!-- Fetch Events Start -->
				<!-- The div in which events list is loaded -->
				<div id="events_list"> </div>
				
				<div id="events_modal"> </div>
				
				<div id="events_post"> </div>

				<div id="tournaments_modal"> </div>
			<!-- Fetch Events End -->
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