<?
function confirmUser($username, $password){
   global $conn;
   if(!get_magic_quotes_gpc()) {
	$username = addslashes($username);
   }

   $q = "select password from users where username = '$username'";
   $result = mysql_query($q,$conn);
   if(!$result || (mysql_numrows($result) < 1)){
      return 1;
   }

   $dbarray = mysql_fetch_array($result);
   $dbarray['password']  = stripslashes($dbarray['password']);
   $password = stripslashes($password);


   if($password == $dbarray['password']){
      return 0; 
   }
   else{
      return 2; 
   }
}

function checkLogin(){

   if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['username'] = $_COOKIE['cookname'];
      $_SESSION['password'] = $_COOKIE['cookpass'];
   }


   if(isset($_SESSION['username']) && isset($_SESSION['password'])){

      if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){

         unset($_SESSION['username']);
         unset($_SESSION['password']);
         return false;
      }
      return true;
   }

   else{
      return false;
   }
}

function displayLogin(){
   global $logged_in;
   if($logged_in){
      echo "<b>$_SESSION[username]</b> is now logged in. <a href=\"logout.php\">Logout</a>";
   }
   else{
?>

<h1>Login</h1>
<form action="" method="post">

Username:<input type="text" name="user" maxlength="30"><br/>
Password:<input type="password" name="pass" maxlength="30"><br/>
<input type="checkbox" name="remember">
Remember me next time<br/>
<input type="submit" name="sublogin" value="Login">
<a href="register.php">Join</a>
<br/>
</form>

<?
   }
}



if(isset($_POST['sublogin'])){

   if(!$_POST['user'] || !$_POST['pass']){
      die('You didn\'t fill in a required field.');
   }

   $_POST['user'] = trim($_POST['user']);
   if(strlen($_POST['user']) > 30){
      die("Sorry, the username is longer than 30 characters, please shorten it.");
   }


   $md5pass = md5($_POST['pass']);
   $result = confirmUser($_POST['user'], $md5pass);


   if($result == 1){
      die('That username doesn\'t exist in our database.');
   }
   else if($result == 2){
      die('Incorrect password, please try again.');
   }


   $_POST['user'] = stripslashes($_POST['user']);
   $_SESSION['username'] = $_POST['user'];
   $_SESSION['password'] = $md5pass;


   if(isset($_POST['remember'])){
      setcookie("cookname", $_SESSION['username'], time()+60*60*24*100, "/");
      setcookie("cookpass", $_SESSION['password'], time()+60*60*24*100, "/");
   }


   echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
   return;
}


$logged_in = checkLogin();

?>
