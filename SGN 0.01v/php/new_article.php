<!DOCTYPE html>

<?php
	// Get access to the "$_SESSION" array
	session_start();	
	
	// Check if there is a user signed in_array
	// If not, redirect to index page
	if(!isset($_SESSION["current_user_id"])) {
		header("Location: http://localhost/sgn/index.php");
		exit();
	}
	
	
	// Check if the new article has 
	if(isset($_POST["title"]) && $_POST["body"] && !empty(ltrim($_POST["title"])) && !empty(ltrim($_POST["body"]))) {
		// Connect to database
		$conn = new mysqli("localhost", "root", "");

		if ($conn->connect_errno)
		{
		  echo "Failed to connect to MySQL: " . $conn->connect_error;
		}
		
		$conn->select_db("sgn_database");
		
		echo "Title: " . $_POST["title"] . "<br><br>";
		echo "Body: " . $_POST["body"] . "<br><br>";

		echo  "<br>";
		echo "Connection successful";
		echo  "<br>";
		
		// Insert article tuple, without article file name yet
		// File name will be updated later, based on id of tuple
		$insert_article_tuple_query = "INSERT INTO esport_articles (esport_id, article_title)
										VALUES (" . $_SESSION["page_id"] . ", '" . $_POST["title"] . "');";
										
		
		echo $insert_article_tuple_query;
										
		$conn->query($insert_article_tuple_query);
		
		// Fetching inserted tuple's id to use in name of the article's text file
		// So that articles can have the same name and unique text file names
		$new_article_tuple_id = $conn->insert_id;
		
		
		$new_file_name = "articles/" . $new_article_tuple_id . ".txt";
		
		echo $new_file_name;
		
		$myfile = fopen($new_file_name, "w") or die("Unable to open file!");
		
		// $write_title = $_POST["title"];
		// Create file and write the article contents in it
		fwrite($myfile, $_POST["title"].PHP_EOL);
		
		
		// fwrite($myfile, "\nA new line\n");
		// $write_author = $_SESSION["current_username"] . "\n";
		
		
		fwrite($myfile, $_SESSION["current_username"].PHP_EOL);
		
		// fwrite($myfile, "\n");
		
		
		fwrite($myfile, $_POST["body"].PHP_EOL);
		
		fclose($myfile);
		
		$conn->close();
		
		
		// Redirect back to the page
		if(ob_get_length()) {
			ob_end_clean();
		}

		// TODO: Redirect to the page that has been posted
		header("Location: http://localhost/sgn/esport_page.php?");
		
	}
	else {
		echo "Invalid form submission";
		
	}
	


?>