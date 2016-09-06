<?php
session_start();
include_once(dirname(__FILE__)."/../db.php"); //Includes db.php file as if it was copy-pasted

if(isset($_POST['login'])) {
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);

    $password = md5($password);

    $sql = dbquery("SELECT * FROM users WHERE username='$username' LIMIT 1");
    $row = mysqli_fetch_array($sql);
    $id = $row['id'];
    $db_password = $row['password'];

    if($password == $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;
        echo $username;
        if ($username == "admin") {header("Location: admin.php");}
        else {header("Location: index.php");}
        die();
    } else {
        echo "You didn't enter the correct details!";
    }

}
?>

<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
</head>
<body>
<h1>Login</h1>
<form action="login.php" method="post" enctype="multipart/form-data">
    <input placeholder="Username" name="username" type="text" autofocus>
    <input placeholder="Password" name="password" type="password">
    <input name="login" type="submit" value="Login">
</form>
</body>
</html>
