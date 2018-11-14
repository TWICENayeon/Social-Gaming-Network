<!DOCTYPE html>


<html>

<?php
// Allows access to the session array
session_start();

// Check if there is a user signed in_array
// If not, redirect to index page

// Connect to the database
$conn = new mysqli("localhost", "root", "");


// Database connection error
if($conn->connect_error) {
	die("Database connection failed: " . $conn->connect_error);
}


// Validate user information query
// to test if the username and/or email are already in the database
$search_user_sql = "SELECT email, username FROM sgn_database.users WHERE username = '" . $_POST["username"] . "' OR email = '" . $_POST["email"] . "';";

//$search_user_sql = "SELECT email, username FROM sgn_database.users WHERE username = \"delta\" OR email = \"delta@mail.com\";";

$result = mysqli_query($conn, $search_user_sql);


echo "<br>";
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

if(mysqli_num_rows($result) == 0) {
	// Create a new user if it does not exist
	$search_user_sql = "INSERT INTO sgn_database.users (email, username, password, first_name, last_name, creation_date) VALUES ('" . $_POST["email"] . "','" . $_POST["username"] . "','" . $_POST["password"] . "','" . $_POST["first_name"] . "','" . $_POST["last_name"] . "',CURRENT_DATE());";
	$result = mysqli_query($conn, $search_user_sql);
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
}
else {
	// TODO: Implement log in failed
	echo "Credentials were incorrect. <br>"; 
}

// Redirect to the index page to log in
if(ob_get_length()) {
	ob_end_clean();
}

header("Location: http://localhost/sgn/index.php");

?>

</html>