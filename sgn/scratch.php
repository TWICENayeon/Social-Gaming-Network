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
<?php 
echo "
<div class='streamBox'><div id='twitch-embed'></div></div>
 

    <script src='https://embed.twitch.tv/embed/v1.js'></script>

    <script type='text/javascript'>
      new Twitch.Embed('twitch-embed', {
        width: 1166,
        height: 552,
		layout: 'video',
        channel: 'TWICE_ny'
      });
    </script>
	<br>
	<br>
	<br>";
	
	?>
	
	<div class='streamBox'><div id='twitch-embed'></div></div>
 

    <script src='https://embed.twitch.tv/embed/v1.js'></script>

    <script type='text/javascript'>
      new Twitch.Embed('twitch-embed', {
        width: 1166,
        height: 552,
		layout: 'video',
        channel: 'TWICE_ny'
      });
    </script>