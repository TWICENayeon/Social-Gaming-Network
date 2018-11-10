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
  document.getElementById("resizer").addEventListener("mousedown", addMousemove)

  function addMousemove (d) {
    console.log("movable")
    document.addEventListener("mousemove", widthDriver)

  }

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
      document.getElementById("resizer").addEventListener("click", popChat);
      function popChat(e) {
        console.log("clickable")
          if (document.getElementById("rightCont").style.display == "none") {
            document.getElementById("rightCont").style.width = "261px";
            document.getElementById("rightCont").style.display = "block"; } 
            document.getElementById("resizer").addEventListener("mousedown", addMousemove) 
      }

      document.getElementById("myTabContent").style.width = (width + 6) + "px";
      document.getElementById("rightCont").style.width = (document.getElementById("mainCont").clientWidth - width - 6) + "px";
  }
  function removeMove(e) {
      document.removeEventListener("mousemove", widthDriver);
      document.removeEventListener("mouseup", removeMove);
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
  setTimeout(function(){ 
    $(".loader").delay(150).fadeOut("slow");
  // $(".loader").delay().fadeOut("slow");
  }, 200)
});