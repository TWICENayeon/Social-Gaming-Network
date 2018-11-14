<?php
	session_start();
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.php");
		exit();
	}
	
	if(isset($_GET["page_id"])) {
		echo "GET USED! <br><br><br><br>";
		$_SESSION["page_id"] = $_GET["page_id"];
	}
	
	if(isset($_POST["page_id"])) {
		echo "POST USED! <br><br><br><br>";
		$_SESSION["page_id"] = $_POST["page_id"];
	}
	
	
	
	echo $_SESSION["current_username"] . "<br>";

?>

<?php

	// Connect to the database
	$conn = new mysqli("localhost", "root", "");
	
	
	if ($conn->connect_errno)
	{
	  echo "Failed to connect to MySQL: " . $conn->connect_error;
	}
	
	$conn->select_db("sgn_database");



?>

<?php

	// Get number of unresolved notifications
	$fetch_num_unresolved_notifications_query = "SELECT COUNT(resolved_status) AS num_unresolved
												FROM notifications
												WHERE recipient_id = " . $_SESSION["current_user_id"] . " and resolved_status = false;";
	
	// echo $fetch_num_unresolved_notifications_query;
												
	$num_unresolved_string = (($conn->query($fetch_num_unresolved_notifications_query))->fetch_assoc())["num_unresolved"];



?>
	

<!-- Banner Start -->
<a href="http://localhost/sgn/user_page.php?page_id=<?php echo $_SESSION["current_user_id"]; ?>"> SGN </a> <br>
<form action="search_results.php" method="get">
	<input type="text" name = "search_term" placeholder="Search. . ." >
	<input type="submit" value="Search">
</form>
<br>
<a href="http://localhost/sgn/my_groups.php"> My Groups </a> <br>
<a href="http://localhost/sgn/my_events.php"> My Events </a> <br>
<a href="http://localhost/sgn/my_friends.php"> My Friends </a> <br>
<a href="http://localhost/sgn/my_notifications.php"> Notifications </a> <?php if(intval($num_unresolved_string) > 0) {echo "[" . $num_unresolved_string . "]";}?> <br>
<a href="http://localhost/sgn/esports.php"> Esports </a> <br>
<a href="http://localhost/sgn/settings.php"> User settings </a> <br>

<br>
<br>

<a href="http://localhost/sgn/process_logout.php"> Logout </a> <br> <br> <br>
	
	<!-- Banner End-->


<?php
	// Get article text file from article id
	$article_file_name = "articles/" . $_SESSION["page_id"] . ".txt";

	$handle = fopen($article_file_name, "r");
	
	echo "<pre><span class=\"inner-pre\" style=\"font-family: 'Times New Roman';\" \"Times New Roman\" style=\"font-size: 12px\">TITLE: ". fgets($handle) . 
		"</span></pre>";
	
	
	
	echo "<pre><span class=\"inner-pre\" style=\"font-family: 'Times New Roman';\" \"Times New Roman\" style=\"font-size: 12px\">Author: ". fgets($handle) . 
		"</span></pre>";
		
	echo "<br><br>";
		
	echo "<pre><span class=\"inner-pre\" style=\"font-family: 'Times New Roman';\" \"Times New Roman\" style=\"font-size: 12px\">"
	. fread($handle, filesize($article_file_name)) . 
	"</span></pre>";
	
?>

<pre><span class="inner-pre" style="font-family: 'Times New Roman';" "Times New Roman" style="font-size: 12px">
<?php
	echo fread($handle, filesize($article_file_name));
?>
</span></pre>



<?php

	fclose($handle);
	
?>