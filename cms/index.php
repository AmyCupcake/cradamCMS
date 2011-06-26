<?php include("../database.php");
session_start();
?>
<!DOCTYPE html>

<html>
 <head>
  <title>CradamCMS</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
 </head>
 <body>
 	<div id="wrapper">
  <?php
   include_once('guestCMS.php');
   $obj = new cradamCMS();
   if ( $_POST )
    $obj->write($_POST);
  ?>
	</div>
 </body>
</html>
