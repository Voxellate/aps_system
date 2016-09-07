<?php
    session_start();	//Start Browser Session
	include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

    if (!isset($_SESSION['id'])){
        header("Location: " . dirname(__FILE__)."/../login.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Coaches</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php if($_SESSION['id'] == 1) {echo $navbar_admin;} else {echo $navbar;} //If user is admin, print navbar_admin, else print navbar?>

<h1>Coach Search</h1>
<?php
$sql = dbquery("SELECT * FROM coaches ORDER BY lastName"); //Query coaches for all indexes; order by lastName
if (mysqli_num_rows($sql) > 0) {	//If there is at least one entry...
    echo "<table class=\"table\"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Email</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>";
    while ($row = mysqli_fetch_assoc($sql)) {	//For each index returned by query...
        echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['email'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>";	//...Create a new table row
    }
    echo "</table>";
} else {
    echo "There is no data to display.";
}
?>
</body>
</html>
