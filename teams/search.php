<?php
    session_start();
	include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted

    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        die();
    }

    if(isset($_POST['logout'])){
        header("Location: logout.php");
    }

    if(isset($_POST['index'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Name Storage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>

</head>
<body>

<?php
echo "<h1>Team Search</h1><p>Choose a team from the drop-down list</p><br><h6><b>Sport:</b></h6>";
echo "<form method='POST'><select name='sport_options' onchange='this.form.submit()'><option disabled selected>Select One</option>";
$sql = dbquery("SELECT sportName FROM sports");
while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
echo "</select></form>";

if(isset($_POST['sport_options'])){
    echo "<br><b>Teams for " . $_POST['sport_options'] . ":</b>";
    echo "<form method='POST'><select name='team_options' onchange='this.form.submit()'><option selected disabled>Select One</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['sport_options']}'");
    while($row = mysqli_fetch_assoc($sql)){
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";
    }
    echo "</select></form>";
	$_SESSION['sport'] = $_POST['sport_options'];
    }

if(isset($_POST['team_options'])){
    echo "<br><h6><b>Team Players:</b><h6>";
	echo "<table><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Year Level</b></td></tr>";
    $sql = dbquery("SELECT firstName, lastName, yearLevel FROM students WHERE teamName = '{$_POST['team_options']}' AND sportName = '{$_SESSION['sport']}'");
    while($row = mysqli_fetch_assoc($sql)){
        echo "<tr><td>{$row['firstName']}</td><td>{$row['lastName']}</td><td>{$row['yearLevel']}</td></tr>";
    }
    echo "</table>";
}
?>

    <br><form method="GET">
        <input type="submit" name="index" value="Main Menu"/>
        <input type="submit" name="logout" value="Logout"/>
    </form>

</body>
</html>

