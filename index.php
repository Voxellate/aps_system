<?php
    session_start();
    include_once("db.php"); //Includes db.php file as if it was copy-pasted

    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        die();
    }

	if(isset($_POST['logout'])){
    	header("Location: logout.php");
	}

    if(isset($_POST['teamsearch'])){
        header("Location: teams/search.php");
    }

    if(isset($_POST['playersearch'])){
        header("Location: students/search.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>APS System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>

</head>
<body>

    <h1>Main Menu</h1>
    <br><form method="POST">
        <input type="submit" name="teamsearch" value="Team Search"/>
        <input type="submit" name="playersearch" value="Player Search"/>
        <input type="submit" name="logout" value="Logout"/>
    </form>

</body>
</html>

