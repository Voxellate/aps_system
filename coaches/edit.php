<?php
session_start();	//Begins Browser Session
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    die();
}?>
    <!doctype html>
    <html>
<head>
    <title>Edit Coaches</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php echo $navbar_admin; ?>
<h1>Add Coaches</h1>
<form class='form-inline' method='POST'> <!-- Add Coach form -->
    <select class='form-control' name='add_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");	//Query sports for sportName
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";} //Create a drop-down option for each index given by query
        ?>
    </select>
</form>

<?php
if(isset($_POST['add_sport_options'])){	//If the Add Coach form is submitted...
    echo "<form class='form-inline' method='POST'><select class='form-control' name='add_team_options'><option selected disabled>Select Team</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['add_sport_options']}'"); //Query teams for indexes where sportName = submitted sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>"; //...Create a drop-down option
    }
    echo "</select><input type='text' name='firstname' placeholder='Coach First Name'><input type='text' name='lastname' placeholder='Coach Last Name'><input type='text' name='email' placeholder='Coach Email'> <input type='submit' name='team_options_submit' value='Add Coach'></form>";
    $_SESSION['sport'] = $_POST['add_sport_options']; //Save selected sport to session data
}
if(isset($_POST['add_team_options'])){	//If the Team Options form is submitted...
    dbquery("INSERT INTO coaches (firstName, lastName, email, teamName, sportName) VALUES ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['email']}','{$_POST['add_team_options']}','{$_SESSION['sport']}')"); //Insert a new index
    echo "Coach added and assigned to team";
}
?>
<h1>Remove Coaches</h1>
<form class='form-inline' method='POST'>	<!-- Remove Coach form -->
    <select class='form-control' name='remove_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports"); //Query sports for sportName
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";} //Create a drop-down option for each index given by query
        ?>
    </select>
</form>
<?php
if(isset($_POST['remove_sport_options']) and $_POST['remove_sport_options'] != "Select Sport"){	//If the Remove Coach form is submitted...
    echo "<br><b>Teams for " . $_POST['remove_sport_options'] . ":</b>";
    echo "<form class='form-inline' method='POST'><select class='form-control' name='team_options' onchange='this.form.submit()'><option selected disabled>Select One</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['remove_sport_options']}'");	//Query teams for indexes where sportName = submitted sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";	//...Create a drop-down option
    }
    echo "</select></form>";
    $_SESSION['sport'] = $_POST['remove_sport_options'];	//Save selected sport to session data
}

if(isset($_POST['team_options'])){	//If the Team Options form is submitted...
    echo "<br><b>Coaches for " . $_POST['team_options'] . ":</b>";
    echo "<form class='form-inline' method='POST'><select class='form-control' name='coach_options'><option selected disabled>Select Coach</option>";
    $sql = dbquery("SELECT id, firstName, lastName FROM coaches WHERE teamName = '{$_POST['team_options']}' AND sportName = '{$_SESSION['sport']}'");	//Query coaches for indexes where teamName = submitted teamName and sportName = submitted sportName
    while($row = mysqli_fetch_assoc($sql)){	//For each index returned by query...
        $fullname = $row['firstName'] . " " . $row['lastName'];	//Calculate fullname from firstname and lastname
        echo "<option name='{$row['id']}'>$fullname</option>";	//Create a drop-down option
    }
    echo "</select><input type='submit' name='remove_coach_submit' value='Remove Coach'></form>";
}

if(isset($_POST['coach_options'])) {	//If the Coach options form is submitted...
    $name = explode(" ", $_POST['coach_options']);	//Seperate fullname into firstname and lastname
    dbquery("DELETE FROM coaches WHERE firstName = '{$name[0]}' AND lastName = '{$name[1]}'");	//Delete submitted coach
    dbquery("UPDATE coaches SET teamName = null WHERE sportName IS null");	//Remove teamName from indexes with no sportName
    echo "Coach removed";
}
?>
</body>
</html>
