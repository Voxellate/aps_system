<?php
session_start();	//Starts browser session
include_once("db.php");	//Includes db.php file as if it was copy-pasted

if(isset($_POST['login'])) {	//If the submit button has been pressed...
    $username = strip_tags($_POST['username']);	//Strip tags from user's username
    $password = strip_tags($_POST['password']);	//Strip tags from user's password

    $username = stripslashes($username);	//Strip slashes from username
    $password = stripslashes($password);	//Strip slashes from password

    $username = mysqli_real_escape_string($db, $username);	//Remove escape strings from username
    $password = mysqli_real_escape_string($db, $password);	//Remove escape strings from password

    $password = md5($password);	//Hash password with md5

    $sql = dbquery("SELECT * FROM users WHERE username='$username' LIMIT 1");	//Query 'users' table for indexes where username = entered username
    $row = mysqli_fetch_array($sql);	//Create an array from the results of the query

    if($password == $row['password']) {	//If the entered password = query password
        $_SESSION['username'] = $username;	//Save the entered username to session data
        $_SESSION['id'] = $row['id'];	//Save the query id to session data
        if ($username == "admin") {header("Location: admin.php");}	//If the account is an admin, redirect user to admin.php
        else {header("Location: index.php");}	//Otherwise, redirect user to index.php
        die();	//Stop sending data
    } else {
        echo "You didn't enter the correct details!"; //Inform the user they didn't enter correct details
    }

}
?>

<html>
<head> <!-- Contains page title and links to Bootstrap style sheet -->
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
</head>
<body>
<h1>Login</h1>
<form class='form-inline' action="login.php" method="post" enctype="multipart/form-data"> <!-- Login form -->
    <input placeholder="Username" name="username" type="text" autofocus>
    <input placeholder="Password" name="password" type="password">
    <input name="login" type="submit" value="Login">
</form>
</body>
</html>
