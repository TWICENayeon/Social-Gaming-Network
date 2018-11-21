<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}

// $_SESSION["page_id"] = $_POST["page_id"];
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
	$fetch_num_replies = "SELECT COUNT(post_id) as total
							FROM posts
							WHERE parent_post_id = " . $_POST["post_id"] . ";";
							
							
	// echo $fetch_num_replies;
							
	$result = (($conn->query($fetch_num_replies))->fetch_assoc())["total"];
	// Print replies to reply modal
	
	echo $result;

	$conn->close();
	?>


</html>