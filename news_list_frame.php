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
$result = mysql_query("SELECT id, news_title FROM news WHERE news_status = 'approved' ORDER BY id DESC LIMIT 0, 5 ");
  //print "<ul>";
while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
  //print "<p class=\"text1\"><a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'news_title'}, 0, 45)."...</strong></a></p>";
  //print "-- <a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'news_title'}, 0, 45)."...</strong></a><br/>";
  //add •::May 05, 2011 Thursday
  print "• <a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'news_title'}, 0, 45)."...</strong></a><br/>";
  //print "<li><a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".substr($row{'news_title'}, 0, 45)."...</strong></a>";
}
  //print "</ul>";
mysql_close($dbh);
?>

</body>
</html>
