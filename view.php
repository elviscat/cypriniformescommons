<?php

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

    if(isset($_GET['id'])) {
        // get the image from the db
        $sql = "SELECT photo FROM participants WHERE id='".$_GET['id']."'";
        // the result of the query
        $result = mysql_query("$sql") or die("Invalid query: " . mysql_error());
        // set the header for the image
        header("Content-type: image/jpeg");
        echo mysql_result($result, 0);
    }else {
        echo 'File not selected';
    }
mysql_close($dbh);
?> 

