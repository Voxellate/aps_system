<?php
    session_start();
	include_once("db.php"); //Includes db.php file as if it was copy-pasted
    include_once("navbar.php"); //Includes navbar.php file as if it was copy-pasted


    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        die();
    } else if($_SESSION['id'] == 1) {
        header("Location: admin.php");
        die();
    }
	if(isset($_POST['logout'])){
    	header("Location: logout.php");
	}

    if(isset($_POST['teamsearch'])){
        header("Location: teams/search.php");
    }

    if(isset($_POST['playersearch'])){
        header("Location: players/search.php");
    }

    echo $navbar;
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
<?php echo $navbar; ?>

<h1>APS Sport Selection System</h1>
<h4>Press a button on the navbar to start</h4>
</body>
</html>

