<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    die();
} else if($_SESSION['id'] != 1){
    header("Location: index.php");
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
<?php echo $navbar_admin; ?>
<h1>Add Team</h1>
<?php
if(isset($_POST['add_submit'])){
    if ($_POST['add_gender'] == "Male"){$gender = "Boys";} else {$gender = "Girls";}
    $teamname = $gender . " " . $_POST['add_team'];
    dbquery("INSERT INTO teams (teamName, sportName, teamGender) VALUES ('$teamname','{$_POST['add_sports']}','{$_POST['add_gender']}')");
    echo $teamname . " " . $_POST['add_sports'] ." added successfully";
}?>
<form name="team_add" method="POST">
    <select name="add_team">
        <option selected disabled>Select Bracket</option>
        <option name="Year 7/8">Year 7/8</option>
        <option name="Year 9">Year 9</option>
        <option name="Year 10">Year 10</option>
        <option name="Open B">Open B</option>
        <option name="Open A">Open A</option>
    </select>
    <select name="add_sports">
        <option selected disabled>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        ?>
    </select>
    <select name="add_gender">
        <option selected disabled>Select Gender</option>
        <option name="Male">Male</option>
        <option name="Female">Female</option>
    </select>
    <input type="submit" name="add_submit" value="Add Team">
</form>
<h1>Remove Team</h1>
<?php
if(isset($_POST['remove_submit'])){
    if ($_POST['remove_gender'] == "Male"){$gender = "Boys";} else {$gender = "Girls";}
    $teamname = $gender . " " . $_POST['remove_team'];
    dbquery("DELETE FROM teams WHERE teamName = '$teamname' AND sportName = '{$_POST['remove_sports']}' AND teamGender = '{$_POST['remove_gender']}'");
    dbquery("UPDATE players SET sportName = null WHERE teamName = '$teamname' AND sportName = '{$_POST['remove_sports']}'");
    dbquery("UPDATE players SET teamName = null WHERE sportName IS null");

    echo $teamname . " " . $_POST['remove_sports'] ." removed successfully";
}?>
<form name="team_remove" method="POST">
    <select name="remove_team">
        <option selected disabled>Select Bracket</option>
        <option name="Year 7/8">Year 7/8</option>
        <option name="Year 9">Year 9</option>
        <option name="Year 10">Year 10</option>
        <option name="Open B">Open B</option>
        <option name="Open A">Open A</option>
    </select>
    <select name="remove_sports">
        <option selected disabled>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        ?>
    </select>
    <select name="remove_gender">
        <option selected disabled>Select Gender</option>
        <option name="Male">Male</option>
        <option name="Female">Female</option>
    </select>
    <input type="submit" name="remove_submit" value="Remove Team">
</form>
</body>
</html>