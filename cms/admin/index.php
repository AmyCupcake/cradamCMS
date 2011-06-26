<? 
/* Include Files *********************/
include("../../database.php");
session_start();
include("../../login.php");

?>
<!DOCTYPE html>
<html>
	<head>
	<title>CradamCMS</title>
	<?php include('inccss.php'); ?>
	</head>
	<body>
	<div id="wrapper">
	<?php
	include_once('adminCMS.php');
	$obj = new cradamCMS();

	if ( $_POST )
		$obj->write($_POST);

if($logged_in){
	echo 'Logged in as '.$_SESSION['username'].', <a href="logout.php">logout</a>';
	echo ( $_GET['admin'] == 1 ) ? $obj->display_admin() : $obj->display_public();
}
else{
	echo 'Not logged in.';
}
	
	?>
</div>
</body>
</html>
