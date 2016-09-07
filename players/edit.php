<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: " . dirname(__FILE__)."/../login.php");
    die();
}?>
    <!doctype html>
    <html>
    <head>
        <title>Edit Teams</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
<body>
<?php if($_SESSION['id'] == 1) {echo $navbar_admin;} else {echo $navbar;} ?>
<h1>Add Players</h1>
<form class='form-inline' method='POST'>    <!-- Add Player form -->
    <select class='form-control' name='add_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");	//Query sports for sportName
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";} //Create a drop-down option for each index given by query
        ?>
    </select>
</form>

<?php
if(isset($_POST['add_sport_options'])){	//If the Add Player form is submitted...
    echo "<form class='form-inline' method='POST'><select class='form-control' name='add_team_options'><option selected disabled>Select Team</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['add_sport_options']}'"); //Query teams for indexes where sportName = submitted sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>"; //...Create a drop-down option
    }
    echo "</select><input type='text' name='firstname' placeholder='Player First Name'><input type='text' name='lastname' placeholder='Player Last Name'><input type='submit' name='team_options_submit' value='Add Player'></form>";
    $_SESSION['sport'] = $_POST['add_sport_options']; //Save selected sport to session data
}
if(isset($_POST['add_team_options'])){	//If the Team Options form is submitted...
    dbquery("UPDATE students SET sportName = '{$_SESSION['sport']}' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}'"); //Update sportName of student
    dbquery("UPDATE students SET teamName = '{$_POST['add_team_options']}' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}'");   //Update teamName of student
    echo "Player added to team";
}
?>
<h1>Remove Players</h1>
<form class='form-inline' method='POST'>	<!-- Remove Player form -->
    <select class='form-control' name='remove_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports"); //Query sports for sportName
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";} //Create a drop-down option for each index given by query
        ?>
    </select>
</form>
<?php
if(isset($_POST['remove_sport_options']) and $_POST['remove_sport_options'] != "Select Sport"){	//If the Remove Player form is submitted...
    echo "<br><b>Teams for " . $_POST['remove_sport_options'] . ":</b>";
    echo "<form class='form-inline' method='POST'><select class='form-control' name='remove_team_options' onchange='this.form.submit()'><option selected disabled>Select One</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['remove_sport_options']}'");	//Query teams for indexes where sportName = submitted sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";	//...Create a drop-down option
    }
    echo "</select></form>";
    $_SESSION['sport'] = $_POST['remove_sport_options'];	//Save selected sport to session data
}

if(isset($_POST['remove_team_options'])){	//If the Team Options form is submitted...
    echo "<br><b>Players for " . $_POST['remove_team_options'] . ":</b>";
    echo "<form class='form-inline' method='POST'><select class='form-control' name='player_options'><option selected disabled>Select Player</option>";
    $sql = dbquery("SELECT id, firstName, lastName FROM students WHERE teamName = '{$_POST['remove_team_options']}' AND sportName = '{$_SESSION['sport']}'"); //Query students for index with same teamName and sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        $fullname = $row['firstName'] . " " . $row['lastName'];	//Calculate fullname from firstname and lastname
        echo "<option name='{$row['id']}'>$fullname</option>";	//Create a drop-down option
    }
    echo "</select><input type='submit' name='remove_player_submit' value='Remove Player'></form>";
}

if(isset($_POST['player_options'])) {	//If the Player options form is submitted...
    $name = explode(" ", $_POST['player_options']);	//Seperate fullname into firstname and lastname
    dbquery("UPDATE students SET sportName = null WHERE firstName = '{$name[0]}' AND lastName = '{$name[1]}'"); //Remove the sportName of selected student
    dbquery("UPDATE students SET teamName = null WHERE sportName IS null"); //Remove the teamName of selected student
    echo "Player removed";
}
?>
</body>
</html>
