<?php
    session_start();	//Begin browser session
	include_once("db.php"); //Includes db.php file as if it was copy-pasted
    include_once("navbar.php"); //Includes navbar.php file as if it was copy-pasted


    if(!isset($_SESSION['id'])){	//If the session id isn't set...
        header("Location: login.php");	//Redirect to login.php
        die();
    } else if($_SESSION['id'] == 1) {	//If the session id = 1 (admin)...
        header("Location: admin.php");	//Redirect to admin.php
        die();
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>APS System</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php echo $navbar;	//Prints the navbar?>

<h1>APS Sport Selection System</h1>
<h4>Press a button on the navbar to start</h4>
</body>
</html>

