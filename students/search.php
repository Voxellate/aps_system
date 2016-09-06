<?php
    session_start();
	include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted

    if (!isset($_SESSION['id'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Name Storage</title>
</head>
<body>
<h1>Player Search</h1>
<form method="GET">
    <input type="text" name="firstname" placeholder="First Name">
    <input type="text" name="lastname" placeholder="Last Name">
    <input type="text" name="yearlevel" placeholder="Year Level">
    <select name="sportname" placeholder="Sport">
        <option selected disabled>Sport</option>
        <?php
        $sql = dbquery("SELECT DISTINCT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";
        }
        ?>
    </select>
    <select name="teamname" placeholder="Team Name">
        <option selected disabled>Team</option>
        <?php
        $sql = dbquery("SELECT DISTINCT teamName FROM teams");
        while($row = mysqli_fetch_assoc($sql)){
              echo "<option name='{$row['teamName']}'>{$row['teamName']}</option>";
        }?>
     </select>
    <input type="submit" name="search" value="Search">
    <input type="submit" name="reset" value="Reset">
</form>

<?php
if (isset($_GET['reset'])) {header("Location: students.php");}

if (isset($_GET['search'])) {

    $query = "SELECT * FROM students WHERE id>0";
    if(!empty($_GET['firstname'])){$query .= " AND firstName='{$_GET['firstname']}'";}
    if(!empty($_GET['lastname'])){$query .= " AND lastName='{$_GET['lastname']}'";}
    if(!empty($_GET['yearlevel'])){$query .= " AND yearLevel='{$_GET['yearlevel']}'";}
    if(!empty($_GET['sportname'])){$query .= " AND sportName='{$_GET['sportname']}'";}
    if(!empty($_GET['teamname'])){$query .= " AND teamName='{$_GET['teamname']}'";}
    $query .= " ORDER BY lastName";
    $sql = dbquery($query);
    echo "<table><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Gender</b></td><td><b>Year Level</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>";
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['gender'] . "</td><td>" . $row['yearLevel'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>";
    }
    echo "</table>";

} else {
    $sql = dbquery("SELECT * FROM students ORDER BY lastName");
    if (mysqli_num_rows($sql) > 0) {
        echo "<table><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Gender</b></td><td><b>Year Level</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>";
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['gender'] . "</td><td>" . $row['yearLevel'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "There is no data to display.";
    }
}
?>
</body>
</html>
