<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted
include_once(dirname(__FILE__)."/../navbar.php"); //Includes navbar.php file as if it was copy-pasted

if(!isset($_SESSION['id'])){
    header("Location: " . dirname(__FILE__)."/../login.php");
    die();
} else if($_SESSION['id'] != 1){
    header("Location: " . dirname(__FILE__)."/../index.php");
    die();	
}?>

<!doctype html>
<html>
<head>
    <title>Edit Sports</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php echo $navbar_admin; ?>
<h1>Add Sport</h1>
<?php
if(isset($_POST['add_submit'])){    //If the add_sport form was submitted...
    dbquery("INSERT INTO sports (sportName) VALUES ('{$_POST['sportname']}')"); //Create a new index in sports with the entered sport name
    echo $_POST['sportname']." added successfully";
} else {echo "Please enter a value";}
?>
<form class='form-inline' name="sport_add" method="POST">   <!-- add_sport form -->
	<input type="text" name="sportname" placeholder="Sport Name">
    <input class="btn btn-default" type="submit" name="add_submit" value="Add Sport">
</form>

<h1>Remove Sport</h1>
<?php
if (isset($_POST['remove_options'])){   //If remove_sport form was submitted...
    dbquery("DELETE FROM sports WHERE sportName = '{$_POST['remove_options']}'");   //Remove the sport from sports
    dbquery("UPDATE students SET teamName = NULL WHERE sportName = '{$_POST['remove_options']}'");  //Remove teamName from students with that sport name
    dbquery("UPDATE students SET sportName = NULL WHERE sportName = '{$_POST['remove_options']}'");//Remove sportName from students with that sport name
    dbquery("DELETE FROM teams WHERE sportName = '{$_POST['remove_options']}'");    //Delete teams with that sportName from sports
    echo $_POST['remove_options']." removed successfully. Affected players have been updated, and affected teams have been removed.";

} else {echo "Please select a sport";}
?>
<form class='form-inline' name="sport_remove" method="POST">    <!-- remove_sport form -->
    <select class='form-control' name="remove_options">
        <option selected disabled>Select One</option>
        <?php
        $sql = dbquery("SELECT sportName FROM sports"); //Query sports for sportName of each index
        while($row = mysqli_fetch_assoc($sql)){ //For each index in sports...
            echo "<option name='{$row['sportName']}'>{$row['sportName']}</option>";} //create a drop-down option
        ?>
    </select>
    <input class="btn btn-default" type="submit" name="remove_submit" value="Remove Sport" onclick="return confirm('Are you sure you want to delete this sport from the database?');">
</form>
</body>
</html>