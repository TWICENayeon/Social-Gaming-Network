<!DOCTYPE html>


<html>

<header>
<h1>SGN</h1>
</header>

<body>

<!-- Validate all user input -->

<!-- Log in form -->
LOG IN: 
<form action="process_login.php" method="post">
username/email: <input type="text" name="main"> <br>
password: <input type="password" name="password"> <br>
<input type="submit">
</form>


<br>
<br>
<br>

<!-- Sign up form -->
SIGN UP:
<form action="process_registration.php" method="post">
Username: <input type="text" name="username"> <br>
Email: <input type="text" name="email"> <br>
First Name: <input type="text" name="first_name"> <br>
Last Name: <input type="text" name="last_name"> <br>
Password: <input type="password" name="password"> <br>
<input type="submit">
</form>


</body>
</html>
