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
    <title>Edit Players</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php echo $navbar_admin; ?>
<h1>Add Team</h1>
<?php
if(isset($_POST['add_submit'])){    //if add_team form submitted...
    if ($_POST['add_gender'] == "Male"){$gender = "Boys";} else {$gender = "Girls";}    //Determine $gender from selected option
    $teamname = $gender . " " . $_POST['add_team']; //Determine $teamname
    dbquery("INSERT INTO teams (teamName, sportName, teamGender) VALUES ('$teamname','{$_POST['add_sports']}','{$_POST['add_gender']}')");  //Add a new team to teams with selected options
    echo $teamname . " " . $_POST['add_sports'] ." added successfully";
}?>
<form class='form-inline' name="team_add" method="POST">    <!-- add_team form -->
    <select class='form-control' name="add_team">
        <option selected disabled>Select Bracket</option>
        <option name="Year 7/8">Year 7/8</option>
        <option name="Year 9">Year 9</option>
        <option name="Year 10">Year 10</option>
        <option name="Open B">Open B</option>
        <option name="Open A">Open A</option>
    </select>
    <select class='form-control' name="add_sports">
        <option selected disabled>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports"); //Query sports for sportName of indexes
        while($row = mysqli_fetch_assoc($sql)){ //For each index in sports...
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}    //Create a drop-down option
        ?>
    </select>
    <select class='form-control' name="add_gender">
        <option selected disabled>Select Gender</option>
        <option name="Male">Male</option>
        <option name="Female">Female</option>
    </select>
    <input class="btn btn-default" type="submit" name="add_submit" value="Add Team">
</form>
<h1>Remove Team</h1>
<?php
if(isset($_POST['remove_submit'])){ //If remove_team form submitted...
    if ($_POST['remove_gender'] == "Male"){$gender = "Boys";} else {$gender = "Girls";}    //Determine $gender from selected option
    $teamname = $gender . " " . $_POST['remove_team']; //Determine $teamname
    dbquery("DELETE FROM teams WHERE teamName = '$teamname' AND sportName = '{$_POST['remove_sports']}' AND teamGender = '{$_POST['remove_gender']}'"); //Delete selected team from teams
    dbquery("UPDATE students SET sportName = null WHERE teamName = '$teamname' AND sportName = '{$_POST['remove_sports']}'");   //Set sportName of students in that team to null
    dbquery("UPDATE students SET teamName = null WHERE sportName IS null"); //Set teamName of indexes with null sports to null.

    echo $teamname . " " . $_POST['remove_sports'] ." removed successfully";
}?>
<form class='form-inline' name="team_remove" method="POST"> <!-- remove_team form -->
    <select class='form-control' name="remove_team">
        <option selected disabled>Select Bracket</option>
        <option name="Year 7/8">Year 7/8</option>
        <option name="Year 9">Year 9</option>
        <option name="Year 10">Year 10</option>
        <option name="Open B">Open B</option>
        <option name="Open A">Open A</option>
    </select>
    <select class='form-control' name="remove_sports">
        <option selected disabled>Select Sport</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");  //Query sports for sportName of indexes
        while($row = mysqli_fetch_assoc($sql)){ //For each index in sports...
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}    //Create a drop-down option
        ?>
    </select>
    <select class='form-control' name="remove_gender">
        <option selected disabled>Select Gender</option>
        <option name="Male">Male</option>
        <option name="Female">Female</option>
    </select>
    <input class="btn btn-default" type="submit" name="remove_submit" value="Remove Team">
</form>
</body>
</html>