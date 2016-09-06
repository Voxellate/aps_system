<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if (!isset($_SESSION['id'])){
    header("Location: index.php");
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
<?php if($_SESSION['id'] == 1) {echo $navbar_admin;} else {echo $navbar;} ?>

<h1>Sport Search</h1>
<?php
$sql = dbquery("SELECT * FROM sports ORDER BY sportName");
if (mysqli_num_rows($sql) > 0) {
    echo "<table class=\"table\"><tr><td><b>Sport Name</b></td></tr>";
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<tr><td>" . $row['sportName'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "There is no data to display.";
}
?>
</body>
</html>
