<?
$conn = mysql_connect("localhost", "username", "password") or die(mysql_error());
mysql_select_db('cradamCMS', $conn) or die(mysql_error());
?>
