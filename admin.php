<?php
session_start();
include_once("db.php"); //Includes db.php file as if it was copy-pasted
include_once("navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    die();
} else if($_SESSION['id'] != 1){
    header("Location: index.php");
    die();
}?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php echo $navbar_admin; //Prints the admin navbar?>

<?php
if (isset($_POST['email_address'])) {	//If the email form has been submitted…
    mail($_POST['email_address'], 'APS Sport Selection', "<html><body>Hello, <br> Your Director of activities has requested that you select your sport preference. You can do this by accessing the form <a href='http://localhost/aps_system/selection.php'>Here</a>.</body></html>"); //Send an email to that address
echo "Email sent.";
}
?>

<h4>Send a Sport Selection Email:</h4>
<form class='form-inline' name="email_form" method="POST">
    <input class='form-control' type="text" name=”email_address”>
    <input class='form-control' type='submit' name='email_submit'>
</form>


<h1>Admin Menu</h1>
<h4>The following students do not have a sport/team:</h4>

<table class="table"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Gender</b></td><td><b>Year Level</b></td><td><b>Sport Name</b></td><td><b>Team Name</b></td></tr>
<?php
$sql = dbquery("SELECT * FROM students WHERE sportName IS null OR teamName IS null"); //Queries the database for 'students' indexes where there is no sportname or teamname
while ($row = mysqli_fetch_assoc($sql)) { //Whilst there are entries in the query array...
    echo "<tr><td>" . $row['firstName'] . "</td><td>" . $row['lastName'] . "</td><td>" . $row['gender'] . "</td><td>" . $row['yearLevel'] . "</td><td>" . $row['sportName'] . "</td><td>" . $row['teamName'] . "</td></tr>"; // Print a new row in the table
}
?>
    </table>
</body>
</html>

