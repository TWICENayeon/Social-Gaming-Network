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

// Destroy the "$_SESSION" array, 
// effectively logging the user out
$_SESSION = array();

session_destroy();

header("Location: http://localhost/sgn/index.php");


?>