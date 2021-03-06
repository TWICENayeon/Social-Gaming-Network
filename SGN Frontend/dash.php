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
<body>
	<div class="loader"></div>
	<div class="sgnBanner"><!-- FILLER BANNER (Add Pic) -->
		<div class="imageIcon"><i class="fa fa-camera" id="cameraIcon" aria-hidden="true"></i></div>
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
				          <a class="dropdown-item" href="../index.html">Logout</a>
				        </div>
					  </li> 				 
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

				<div class="template-post">					
					<div class="image-buttons-container">						
						<div class="post-profile-image"></div>						
						<div class="post-profile-gap"></div>
						<div class="post-like-button">													
							<i class="far fa-thumbs-up" id="thumbsUpIcon" onclick="thumbsUpFunc()"></i>							
							2.5M
						</div>						
						<div class="post-comment-button" data-toggle="modal" data-target="#commentsModal">							
							<i class="far fa-comments" id="commentsIcon"></i>
							33
						</div>
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
					        			<div class="commentPostUpvote"><i class="fa fa-hand-o-up" aria-hidden="true"></i></div>
					        			<div class="commentPostDownvote"><i class="fa fa-hand-o-down" aria-hidden="true"></i></div>
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
				<div class="template-post">
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
				</div>
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
		  		<div class="tabWelcome">Events</div>
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
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" aria-hidden="true"></i></div>
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
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" aria-hidden="true"></i></div>
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
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" aria-hidden="true"></i></div>
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
					        			<div class="eventPostUpvote"><i class="fa fa-hand-o-up" aria-hidden="true"></i></div>
					        			<div class="eventPostDownvote"><i class="fa fa-hand-o-down" aria-hidden="true"></i></div>
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