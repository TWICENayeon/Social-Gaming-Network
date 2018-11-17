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
        xmlhttp.open("POST", "php/fetch_posts.php", true);
        xmlhttp.send();
}

function fetchEventList() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("events_list").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/fetch_events_list.php", true);
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
        xmlhttp.send();
}
</script>

<script>

function tabAlert() {
	alert("Tab Alert!");
}


// Bind, works better than trigger
function tabClick() {
	var $link = $(this);
	if($link.attr("id") == "home-tab") {
		fetchPosts();
	}
	if($link.attr("id") == "esports-tab") {
	}
	if($link.attr("id") == "groups-tab") {
		alert("groups");
	}
	if($link.attr("id") == "events-tab") {
		alert("events");
		fetchEventList();
		fetchEventModals();
		fetchEventPosts();
	}
}

$(document).ready(function(){
    $('a.nav-link').bind("click", tabClick);
});



// Trigger
// $(document).on("click", "a", function(){
	// var $link = $(this);
	// if($link.attr("id") == "home-tab") {
		// alert($link.attr("id"));
	// }
// });

// $(document).ready(function(){
    // $("a.nav-link").trigger("click");
// });
</script>

<body onload=fetchPosts()>
	<div class="loader"></div>
	<div class="sgnBanner"><!-- FILLER BANNER (Add Pic) -->
		<div class="imageIcon" data-toggle="modal" data-target="#uploadBannerModal"><i class="fa fa-camera" id="cameraIcon" aria-hidden="true"></i></div>
		<!-- Upload Banner Modal -->
		<div class="modal fade" id="uploadBannerModal" tabindex="-1" role="dialog">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Upload Banner Image</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        <p>Select an image to upload for your custom banner: <input type="file" name="bannerFile"></p>		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary">Save changes</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="sgnTabs">				
					<ul class="nav nav-tabs mr-auto flex-col flex-sm-row" id="dashTabs" role="tablist">
					  <li class="nav-item main-tabs">
					    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">SGN</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="esports-tab" data-toggle="tab" href="#esports" role="tab" aria-controls="esports" aria-selected="false">Esports</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups" aria-selected="false">Groups</a>
					  </li>
					  <li class="nav-item main-tabs">
					    <a class="nav-link" id="events-tab" data-toggle="tab" href="#events" role="tab" aria-controls="events" aria-selected="false">Events</a>
					  </li>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Search</a>
					  </li> -->
					  <li class="nav-item searchTab">
					  	<form class="searchBar">
		      				<input type="text" class="form-control" placeholder="Search.." name="search">
		      				<button type="submit"><i class="fa fa-search"></i></button>    				
		      				<!-- <button type="submit">Submit</button> -->

		   				 </form>
					  <!-- <li class="nav-item">
					    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tournaments</a>
					  </li>-->
					  </li>
					  <li class="flex-sm-fill"></li>					 
					  <li class="nav-item dropdown" id="profileLi" data-toggle="dropdown">					  	
					  	<a class="nav-link" id="profile-tab" data-toggle="dropdown-toggle"><img src="img/Profile-icon-9.png"></a>
					  	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
					  	  <a class="dropdown-item" id="profileName">TWICE_Nayeon</a>
				          <a class="dropdown-item" href="#">Profile</a>
				          <a class="dropdown-item" href="#">Account</a>
				          <!-- <div class="dropdown-item"><a id="logoutDD" href="index.html">Logout</a></div> -->
				          <a class="dropdown-item" id="logoutDD" href="index.html">Logout</a>
				        </div>				        
					  </li>
					  <!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
					  	<a class="dropdown" id="logoutDD" href="index.html">Logout</a>
					  </div>  -->				 
					</ul>															
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
				        <button type="button" class="btn btn-primary">Post!</button>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="tabWelcome">Dashboard</div>

				
				<!-- Posts are loaded into this div -->
				<div id="posts"> </div>

				<!-- Search Results hidden by default unless searched -->
				<div class="searchResults">
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
				<!-- The div in which events list is loaded -->
				<div id="events_list"> </div>
		  		
				<div id="events_modal"> </div>
				
		  		<div id="events_post"> </div>
		  				  		
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