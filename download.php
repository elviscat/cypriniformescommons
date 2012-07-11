<?php
session_start();

if(isset($_GET['id'])){// if id is set then get the file with the id from database
  if($_GET['id'] == 0){
    echo "There is no uploaded attached file here!";
    exit;  
  }else if ($_SESSION['is_login'] == false){
    echo "You are not a member of Cypriniformes Commons!";
    exit;    
  }else{

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



    $id = $_GET['id'];
    $query = "SELECT name, type, size, content " .
             "FROM upload WHERE id = '$id'";

    $result = mysql_query($query) or die('Error, query failed');
    list($name, $type, $size, $content) = mysql_fetch_array($result);
    
    header("Content-length: $size");
    header("Content-type: $type");
    //header("Content-Disposition: attachment; filename=".$name);
	//header('Content-Disposition: attachment; filename="downloaded.pdf"');
    //header('Content-Disposition: attachment; filename="123.pdf"');
	header('Content-Disposition: attachment; filename="'.$name.'"');
    echo $content;

    mysql_close($dbh);
    exit;  
  }
}
?>
