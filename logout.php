<?php
session_start(); 
include("database.php");
include("login.php");

if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
	setcookie("cookname", "", time()-60*60*24*100, "/");
	setcookie("cookpass", "", time()-60*60*24*100, "/");
}

?>

<html>
<title>Logging Out</title>
<body>

<?php

if(!$logged_in){
	echo "<h1>Error!</h1>\n";
	echo "You are not currently logged in, logout failed. Back to <a href=\"main.php\">main</a>";
}
else{

	unset($_SESSION['username']);
	unset($_SESSION['password']);
	$_SESSION = array();
	session_destroy();
	echo "<h1>Logged Out</h1>\n";
	echo "<a href=\"main.php\">main</a>";
}
?>
</body>
</html>
