<!DOCTYPE html>

<html>


<?php					echo"
							<div class='modal fade' id='leagueStreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>League of Legends Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo'><iframe
												src='https://player.twitch.tv/?channel=riot games'
												height='478'
												width='765'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat'><div id='lolStreamChat'></div></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='csgoStreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>Counter-Strike: Global Offensive Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo'><iframe
												src='https://player.twitch.tv/?channel=esl_csgo'
												height='478'
												width='765'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat'><div id='csgoStreamChat'></div></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='owStreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>Overwatch Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo'><iframe
												src='https://player.twitch.tv/?channel=esl_overwatch'
												height='478'
												width='765'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat'><div id='owStreamChat'></div></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='hotsStreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>Heroes of the Storm Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo'><iframe
												src='https://player.twitch.tv/?channel=esl_heroes'
												height='478'
												width='765'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat' id='hotsStreamChat'></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='sc2StreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>Starcraft II Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo'><iframe
												src='https://player.twitch.tv/?channel=esl_sc2'
												height='478'
												width='765'
												frameborder='0'
												scrolling='no'
												allowfullscreen='true'>
											</iframe></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat'><div id='sc2StreamChat'></div></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>
							<div class='modal fade' id='freeStreamModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-lg' role='document'>
							    <div class='modal-content modal-1200'>
							      <div class='modal-header'>
							        <h5 class='modal-title' id='exampleModalLabel'>Watch Desired Stream</h5>
							        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							          <span aria-hidden='true'>&times;</span>
							        </button>
							      </div>
							      <div class='modal-body' id='esportModalBody'>
							        <div class='streamCont'>
							        	<div class='streamVideo' id='freeStreamVideo'></div>
							        </div>
							        <div class='streamChatCont'>
							        	<div class='streamChat'><div id='freeStreamChat'></div></div>
							        </div>
							      </div>
							      <div class='modal-footer'>
										<p style='color:black'>Choose desired Stream: <input type='text' id='freeStreamName'>
										<button type='button' class='btn btn-primary' onclick='loadFreeStream()'>Watch!</button>
							        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
							      </div>
							    </div>
							  </div>
							</div>";		?>   </html>