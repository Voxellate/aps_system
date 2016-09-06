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
    <title>Edit Coaches</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php echo $navbar_admin; ?>
<h1>Add Coaches</h1>
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
    echo "<form method='POST'><select name='add_team_options'><option selected disabled>Select Team</option>";
    $sql = dbquery("SELECT * FROM teams WHERE sportName = '{$_POST['add_sport_options']}'");
    while($row = mysqli_fetch_assoc($sql)){
        echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";
    }
    echo "</select><input type='text' name='firstname' placeholder='Coach First Name'><input type='text' name='lastname' placeholder='Coach Last Name'><input type='text' name='email' placeholder='Coach Email'> <input type='submit' name='team_options_submit' value='Add Coach'></form>";
    $_SESSION['sport'] = $_POST['add_sport_options'];
}
if(isset($_POST['add_team_options'])){
    dbquery("INSERT INTO coaches (firstName, lastName, email, teamName, sportName) VALUES ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['email']}','{$_POST['add_team_options']}','{$_SESSION['sport']}')");
    echo "Coach added and assigned to team";
}
?>
<h1>Remove Coaches</h1>
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
    echo "<br><b>Coaches for " . $_POST['team_options'] . ":</b>";
    echo "<form method='POST'><select name='coach_options'><option selected disabled>Select Coach</option>";
    $sql = dbquery("SELECT id, firstName, lastName FROM coaches WHERE teamName = '{$_POST['team_options']}' AND sportName = '{$_SESSION['sport']}'");
    while($row = mysqli_fetch_assoc($sql)){
        $fullname = $row['firstName'] . " " . $row['lastName'];
        echo "<option name='{$row['id']}'>$fullname</option>";
    }
    echo "</select><input type='submit' name='remove_coach_submit' value='Remove Coach'></form>";
}

if(isset($_POST['coach_options'])) {
    $name = explode(" ", $_POST['coach_options']);
    dbquery("DELETE FROM coaches WHERE firstName = '{$name[0]}' AND lastName = '{$name[1]}'");
    dbquery("UPDATE coaches SET teamName = null WHERE sportName IS null");
    echo "Coach removed";
}
?>
</body>
</html>
