<?php
    session_start();
	include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

    if (!isset($_SESSION['id'])){
        header("Location: " . dirname(__FILE__)."/../login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Players</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php if($_SESSION['id'] == 1) {echo $navbar_admin;} else {echo $navbar;} ?>

<h1>Player Search</h1>
<form class='form-inline' method="GET"> <!-- Player Search form -->
    <input type="text" name="firstname" placeholder="First Name">
    <input type="text" name="lastname" placeholder="Last Name">
    <input type="number" name="yearlevel" max="12" min="7" placeholder="Grade">
    <select class='form-control' name="gender" placeholder="Gender">
        <option selected disabled>Gender</option>
        <option name='male'>Male</option>
        <option name='female'>Female</option>
    </select>
    <select class='form-control' name="sportname" placeholder="Sport">
        <option selected disabled>Sport</option>
        <?php
        $sql = dbquery("SELECT DISTINCT sportName FROM sports");    //Query sports for sportName of each index
        while($row = mysqli_fetch_assoc($sql)){ //For each index in sports...
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>"; //Create a drop-down option
        }
        ?>
    </select>
    <select class='form-control' name="teamname" placeholder="Team Name">
        <option selected disabled>Team</option>
        <?php
        $sql = dbquery("SELECT DISTINCT teamName FROM teams");  //Query teams for teamName of each index
        while($row = mysqli_fetch_assoc($sql)){ //For each index in teams...
              echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>"; //Create a drop-down option
        }?>
     </select>
    <input class="btn btn-default" type="submit" name="search" value="Search">
    <input class="btn btn-default" type="button" name="reset" value="Reset" onclick="window.location = 'search.php'">
</form>

<?php
if (isset($_GET['reset'])) {header("Location: edit.php"); die();}   //If reset button pressed, refresh page

if (isset($_GET['search'])) {   //If search button pressed...

    $query = "SELECT * FROM students WHERE id>0";   //Query students where...
    if(!empty($_GET['firstname'])){$query .= " AND firstName='{$_GET['firstname']}'";}  //...(if entered) firstName = entered first name...
    if(!empty($_GET['lastname'])){$query .= " AND lastName='{$_GET['lastname']}'";} //...(if entered) lastName = entered last name...
    if(!empty($_GET['yearlevel'])){$query .= " AND yearLevel='{$_GET['yearlevel']}'";}  //...(if entered) yearLevel = entered year level...
    if(!empty($_GET['gender'])){$query .= " AND gender='{$_GET['gender']}'";}   //...(if entered) gender = selected gender...
    if(!empty($_GET['sportname'])){$query .= " AND sportName='{$_GET['sportname']}'";}  //...(if entered) sportName = selected sport name...
    if(!empty($_GET['teamname'])){$query .= " AND teamName='{$_GET['teamname']}'";} //...(if entered) teamName = selected team name...
    $query .= " ORDER BY lastName"; //...and order by last name
    $sql = dbquery($query); //Execute query
    echo "<table class=\"table\"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Gender</b></td><td><b>Year Level</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>";
    while ($row = mysqli_fetch_assoc($sql)) {   //For each index returned by query
        echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['gender'] . "</td><td>" . $row['yearLevel'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>";    //Create a table row
    }
    echo "</table>";

} else {
    $sql = dbquery("SELECT * FROM students ORDER BY lastName"); //Query students for all indexes
    if (mysqli_num_rows($sql) > 0) {    //If there is at least 1 index...
        echo "<table class=\"table\"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Gender</b></td><td><b>Year Level</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>";
        while ($row = mysqli_fetch_assoc($sql)) {   //For each index in students...
            echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['gender'] . "</td><td>" . $row['yearLevel'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>";    //Create a table row
        }
        echo "</table>";
    } else {
        echo "There is no data to display.";
    }
}
?>
</body>
</html>
