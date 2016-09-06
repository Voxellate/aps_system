<?php
session_start();
include_once("db.php"); //Includes db.php file as if it was copy-pasted
?>

<!DOCTYPE html>
<html>
<head>
    <title>APS System</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css' integrity='sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js' integrity='sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD' crossorigin='anonymous'></script>

</head>
<body>
<h1>APS Sport Selection</h1>
<?php
if (isset($_POST['submit'])) {
    if ($_POST['gender'] == "male"){$gender = "Boys";} else {$gender = Girls;}

    if($_POST['yearlevel'] <= 8) {$team = $gender . " Year 7/8";}
    else if($_POST['yearLevel'] == 9) {$team = $gender . " Year 9";}
    else if($_POST['yearLevel'] == 10) {$team = $gender . " Year 10";}
    else if($_POST['yearLevel'] == 11) {$team = $gender . " Open B";}
    else if($_POST['yearLevel'] == 12) {$team = $gender . " Open A";}

    dbquery("UPDATE students SET sportName = '{$_POST['sport_options']}', teamName = '$team' WHERE firstName = '{$_POST['firstname']}' AND lastName = '{$_POST['lastname']}' AND gender = '{$_POST['gender']}' AND yearLevel = '{$_POST['yearlevel']}'");

    echo "<h6>Thank You for selecting your APS Sport.</h6>";

} else { echo
"<form name='selection_form' method='POST'><table>
    <tr><td><b>First Name:</b></td><td><input type='text' name='firstname' placeholder='First Name'></td></tr>
    <tr><td><b>Last Name:</b></td><td><input type='text' name='lastname' placeholder='Last Name'></td></tr>
    <tr><td><b>Gender:</b></td><td><input type='radio' name='gender' value='male' checked> Male <input type='radio' name='gender' value='female'> Female</td></tr>
    <tr><td><br><b>Year Level:</b></td><td><input type='number' name='yearlevel' min='7' max='12'></td></tr>
    <tr><td><b>Sport Selection:</b></td><td><select name='sport_options'>
        <option disabled selected>Select One</option>";
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        echo "</select></td></tr><tr><td><input type='submit' name='submit' value='Next'></td></tr></table></form>";}
?>
</body>
</html>