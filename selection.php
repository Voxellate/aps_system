<?php
session_start();	//Begin browser session
include_once("db.php"); //Includes db.php file as if it was copy-pasted
?>

<!DOCTYPE html>
<html>
<head>
    <title>APS System</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<h1>APS Sport Selection</h1>
<?php
if (isset($_POST['submit'])) {	//If the submit button has been pressed...
    if ($_POST['gender'] == "male"){$gender = "Boys";} else {$gender = Girls;}	//Set $gender relative to the value of submitted gender

    if($_POST['yearLevel'] <= 8) {$team = $gender . " Year 7/8";}		//
    else if($_POST['yearLevel'] == 9) {$team = $gender . " Year 9";}	//	This block determines the team to assign based on
    else if($_POST['yearLevel'] == 10) {$team = $gender . " Year 10";}	//	what year level and gender is given.
    else if($_POST['yearLevel'] == 11) {$team = $gender . " Open B";}	//
    else if($_POST['yearLevel'] == 12) {$team = $gender . " Open A";}	//

    dbquery("UPDATE students SET sportName = '{$_POST['sport_options']}', teamName = '$team' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}' AND gender = '{$_POST['gender']}' AND yearLevel = '{$_POST['yearLevel']}'");	//Updates students table with sports selection and team designation

    echo "<h6>Thank You for selecting your APS Sport.</h6>";

} else { echo //Otherwise, print the sports selection form
"<form class='form-inline' name='selection_form' method='POST'><table>
    <tr><td><b>First Name:</b></td><td><input type='text' name='firstname' placeholder='First Name'></td></tr>
    <tr><td><b>Last Name:</b></td><td><input type='text' name='lastname' placeholder='Last Name'></td></tr>
    <tr><td><b>Gender:</b></td><td><input type='radio' name='gender' value='male' checked> Male <input type='radio' name='gender' value='female'> Female</td></tr>
    <tr><td><br><b>Year Level:</b></td><td><input type='number' name='yearLevel' min='7' max='12'></td></tr>
    <tr><td><b>Sport Selection:</b></td><td><select class='form-control' name='sport_options'>
        <option disabled selected>Select One</option>";
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        echo "</select></td></tr><tr><td><input type='submit' name='submit' value='Next'></td></tr></table></form>";}
?>
</body>
</html>