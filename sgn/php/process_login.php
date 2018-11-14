<!DOCTYPE html>


<?php
// Allows access to the session array
session_start();


// Connect to database
$conn = new mysqli("localhost", "root", "");

// Database connection error
if ($conn->connect_errno)
{
  echo "Failed to connect to MySQL: " . $conn->connect_error;
}

echo  "<br>";
echo "Connection successful";
echo  "<br>";

// Validate the credentials
// TODO: store the hashes of the password instead of the plaintext
$search_user_sql = "SELECT user_id, username FROM sgn_database.users WHERE (username = '" . $_POST["main"] . "' OR email = '" . $_POST["main"] . "') AND password = '" . $_POST["password"] . "';";

//$search_user_sql = "SELECT email, username FROM sgn_database.users WHERE username = \"delta\" OR email = \"delta@mail.com\";";


$result = $conn->query($search_user_sql);

$conn->close();

// If credentials are valid
// Redirect to the user's page
if($result->num_rows == 1) {
	$result_tuple = $result->fetch_assoc();
	echo "Log in success <br>";
	
	$_SESSION["current_user_id"] = $result_tuple["user_id"];
	$_SESSION["current_username"] = $result_tuple["username"];
echo  "<br>";	
	echo $result->fetch_assoc()["username"];
echo  "<br>";
	echo "Printed out session info";

	if(ob_get_length()) {
		ob_end_clean();
	}

	header("Location: http://localhost/sgn/dash.php");
}
// If credentials are not valid
// Redirect to the index page
else {
	echo "Log in failed <br>";
	
	


	if(ob_get_length()) {
		ob_end_clean();
	}

	header("Location: http://localhost/sgn/index.php");
}

?>