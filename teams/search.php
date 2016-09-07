<?php
    session_start();
	include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

    if(!isset($_SESSION['id'])){
        header("Location: login.php");
        die();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Teams</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php if($_SESSION['id'] == 1) {echo $navbar_admin;} else {echo $navbar;} ?>

<h1>Team Search</h1>
<p>Choose a team from the drop-down list</p><br>
<h6><b>Sport:</b></h6>
<form class='form-inline' method='POST'>    <!-- sport_options form -->
    <select class='form-control' name='sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select One</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports"); //Query sports for sportName of indexes
        while($row = mysqli_fetch_assoc($sql)){ //For each index in sports...
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}    //Create a drop-down option
        ?>
    </select>
</form>

<?php
if(isset($_POST['sport_options']) and $_POST['sport_options'] != "Select Sport"){ //If sport_options form submitted...
    echo "<br><b>Teams for " . $_POST['sport_options'] . ":</b>";
    echo "<form class='form-inline' method='POST'><select class='form-control' name='team_options' onchange='this.form.submit()'><option selected disabled>Select One</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['sport_options']}'");    //Query teams for indexes with selected sport name
    while($row = mysqli_fetch_assoc($sql)){ //For each index returned by query...
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";   //Create a drop-down option
    }
    echo "</select></form>";
	$_SESSION['sport'] = $_POST['sport_options'];   //Save selected sport to session data
    }

if(isset($_POST['team_options'])){  //If team_options form submitted
    echo "<br><h6><b>Team Players:</b><h6>";
	echo "<table class=\"table\"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Year Level</b></td></tr>";
    $sql = dbquery("SELECT firstName, lastName, yearLevel FROM students WHERE teamName = '{$_POST['team_options']}' AND sportName = '{$_SESSION['sport']}'");   //Query students for indexes with matching sportName and teamName
    while($row = mysqli_fetch_assoc($sql)){ //For each index returned by query...
        echo "<tr><td>{$row['firstName']}</td><td>{$row['lastName']}</td><td>{$row['yearLevel']}</td></tr>";    //Create a table row
    }
    echo "</table>";
}
?>
</body>
</html>

