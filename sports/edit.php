<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted

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
    <title>Edit Sports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
</head>
<body>

<h1>Add Sport</h1>
<?php
if(isset($_POST['add_submit'])){
    dbquery("INSERT INTO sports (sportName) VALUES ('{$_POST['sportname']}')");
    echo $_POST['sportname']." added successfully";
} else {echo "Please enter a value";}
?>
<form name="sport_add" method="POST">
	<input type="text" name="sportname" placeholder="First Name">
    <input type="submit" name="add_submit" value="Add Sport">
</form>

<h1>Remove Sport</h1>
<?php
if (isset($_POST['remove_options'])){
    dbquery("DELETE FROM sports WHERE sportName = '{$_POST['remove_options']}'");
    dbquery("UPDATE students SET teamName = NULL WHERE sportName = '{$_POST['remove_options']}'");
    dbquery("UPDATE students SET sportName = NULL WHERE sportName = '{$_POST['remove_options']}'");
    dbquery("DELETE FROM teams WHERE sportName = '{$_POST['remove_options']}'");
    echo $_POST['remove_options']." removed successfully. Affected students have been updated, and affected teams have been removed.";

} else {echo "Please select a sport";}
?>
<form name="sport_remove" method="POST">
    <select name="remove_options">
        <option selected disabled>Select One</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports");
        while($row = mysqli_fetch_assoc($sql)){echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";}
        ?>
    </select>
    <input type="submit" name="remove_submit" value="Remove Sport" onclick="return confirm('Are you sure you want to delete this sport from the database?');">
</form>
</body>
</html>