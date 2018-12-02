<!DOCTYPE html>
<?php
// Gain access to the session array
session_start();

// 
if(!isset($_SESSION["current_user_id"])) {
	header("Location: http://localhost/sgn/index.php");
	exit();
}
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
	$leave_group_query = "DELETE FROM memberships
							WHERE of_group_id = " . $_POST["group_id"] . " AND member_id = " . $_SESSION["current_user_id"] . ";";
	
	echo $leave_group_query;
	
	$conn->query($leave_group_query);


?>