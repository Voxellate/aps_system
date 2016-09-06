<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: login.php");
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
<?php echo $navbar_admin; ?>]
<h1>Add Players</h1>
<form method='POST'>
    <select name='add_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        ?>
    </select>
</form>

<?php
if(isset($_POST['add_sport_options'])){
    echo "<form method='POST'><select name='team_options'><option selected disabled>Select Team</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['add_sport_options']}'");
    while($row = mysqli_fetch_assoc($sql)){
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";
    }
    echo "</select><input type='text' name='firstname' placeholder='Player First Name'><input type='text' name='lastname' placeholder='Player Last Name'><input type='submit' name='team_options_submit' value='Add Player'></form>";
    $_SESSION['sport'] = $_POST['add_sport_options'];
}
if(isset($_POST['add_team_options'])){
    dbquery("UPDATE players SET sportName = '{$_SESSION['sport']}' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}'");
    dbquery("UPDATE players SET teamName = '{$_POST['add_team_options']}' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}'");
    echo "Player added to team";
}
?>
<h1>Remove Players</h1>
<form method='POST'>
    <select name='remove_sport_options' onchange='this.form.submit()'>
        <option disabled selected>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        ?>
    </select>
</form>
<?php
if(isset($_POST['remove_sport_options']) and $_POST['remove_sport_options'] != "Select Sport"){
    echo "<br><b>Teams for " . $_POST['remove_sport_options'] . ":</b>";
    echo "<form method='POST'><select name='team_options' onchange='this.form.submit()'><option selected disabled>Select One</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['remove_sport_options']}'");
    while($row = mysqli_fetch_assoc($sql)){
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";
    }
    echo "</select></form>";
    $_SESSION['sport'] = $_POST['remove_sport_options'];
}

if(isset($_POST['team_options'])){
    echo "<br><b>Players for " . $_POST['team_options'] . ":</b>";
    echo "<form method='POST'><select name='player_options'><option selected disabled>Select Player</option>";
    $sql = dbquery("SELECT id, firstName, lastName FROM players WHERE teamName = '{$_POST['team_options']}' AND sportName = '{$_SESSION['sport']}'");
    while($row = mysqli_fetch_assoc($sql)){
        $fullname = $row['firstName'] . " " . $row['lastName'];
        echo "<option name='{$row['id']}'>$fullname</option>";
    }
    echo "</select><input type='submit' name='remove_player_submit' value='Remove Player'></form>";
}

if(isset($_POST['player_options'])) {
    $name = explode(" ", $_POST['player_options']);
    dbquery("UPDATE players SET sportName = null WHERE firstName = '{$name[0]}' AND lastName = '{$name[1]}'");
    dbquery("UPDATE players SET teamName = null WHERE sportName IS null");
    echo "Player removed";
}
?>
</body>
</html>
