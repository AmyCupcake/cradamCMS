<?
session_start(); 
include("database.php");
function usernameTaken($username){
	global $conn;
	
	$q = "select username from users where username = '$username'";
	$result = mysql_query($q,$conn);
	return (mysqli_numrows($result) > 0);
}

function addNewUser($username, $password){
	global $conn;
	$q = "INSERT INTO users VALUES ('$username', '$password')";
	return mysqli_query($q,$conn);
}

function displayStatus(){
	$uname = $_SESSION['reguname'];
	if($_SESSION['regresult']){
?>

<h1>Registered!</h1>
<p>Thank you <b><? echo $uname; ?></b>, thank you for registering you may now <a href="main.php" title="Login">log in</a>.</p>

<?
	}
	else{
?>

<h1>Registration Failed</h1>
<p>Please try again later</p>

<?
	}
	unset($_SESSION['reguname']);
	unset($_SESSION['registered']);
	unset($_SESSION['regresult']);
}

if(isset($_SESSION['registered'])){

?>

<html>
<head>
	<title>Registration Page</title>
</head>
<body>

<? displayStatus(); ?>

</body>
</html>

<?
	return;
}

if(isset($_POST['subjoin'])){
	/* Make sure all fields were entered */
	if(!$_POST['user']){
		die('You didn\'t provide a Username.');
	}
	elseif(!$_POST['pass]){
		die('You didn\'t provide a Password')
	}

	/* Spruce up username, check length */
	$_POST['user'] = trim($_POST['user']);
	if(strlen($_POST['user']) > 30){
	 die("Sorry, the username is longer than 30 characters, please shorten it.");
	}

	/* Check if username is already in use */
	if(usernameTaken($_POST['user'])){
	 $use = $_POST['user'];
	 die("Sorry, the username: <strong>$use</strong> is already taken, please pick another one.");
	}

	/* Add the new account to the database */
	$md5pass = md5($_POST['pass']);
	$_SESSION['reguname'] = $_POST['user'];
	$_SESSION['regresult'] = addNewUser($_POST['user'], $md5pass);
	$_SESSION['registered'] = true;
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
	return;
}
else{

?>

<html>
	<title>Registration Page</title>
<body>
	<h1>Register</h1>
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
		Username:<input type="text" name="user" maxlength="30">
		Password:<input type="password" name="pass" maxlength="30">
		<input type="submit" name="subjoin" value="Join!">
	</form>
</body>
</html>
<?
}
?>
