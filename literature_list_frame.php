<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
<?php //echo "<strong>Cobitodea conference</strong>";

$username = "webappconnect";
$password = "u5QZWEMfAd3fbLLw";
$hostname = "localhost";	
$dbh = mysql_connect($hostname, $username, $password) 
	or die("Unable to connect to mysql");
//print "connected to mysql<br>";
$selected = mysql_select_db("acsi",$dbh) 
	or die("Could not select this database");

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 

$sql = "SELECT id, literature_infor FROM literature WHERE status = 'Approved' ORDER BY id DESC LIMIT 0, 5";

$result = mysql_query($sql);

//echo $sql;

while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
  //print "<a href=\"literature.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".$row{'literature_infor'}."</strong></a><br>";
  //print "-- <a href=\"literature.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'literature_infor'}, 0, 100)."...</strong></a><br/>";
  //add •::May 05, 2011 Thursday
  print "• <a href=\"literature.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'literature_infor'}, 0, 100)."...</strong></a><br/>";
}
mysql_close($dbh);
?>

</body>
</html>
