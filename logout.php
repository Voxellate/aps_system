<?php
    session_start(); //Starts browser session
    session_destroy();	//Ends browser session
?>
<html>
<body>
Please wait...
<meta http-equiv="refresh" content="1;url=login.php"> <!-- Redirects to login.php -->
</body>
</html>
