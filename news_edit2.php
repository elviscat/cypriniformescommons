<?php
  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) || $_SESSION['username'] == "" || $_SESSION['application_name'] != "Cypriniformes Commons"){
    Header("location:login.php");
    exit();
  } else if( $_SESSION['is_activated'] == "no"){
	Header("location:need_to_activate.php");
	session_destroy();
    exit();
  }
  
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

  //Configuration of POST and GET Variables
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  $news_title = htmlspecialchars($_POST['news_title'],ENT_QUOTES);
  //echo "news_title is :: ".$news_title."<br>\n";
  
  //$news_content = htmlspecialchars($_POST['news_content'],ENT_QUOTES);
  $news_content = $_POST['news_content'];
  $news_content = stripslashes($news_content);  
  //echo "news_content is :: ".$news_content."<br>\n";
  
  $news_link = htmlspecialchars($_POST['news_link'],ENT_QUOTES);
  //echo "news_link is :: ".$news_link."<br>\n";
  $news_type = htmlspecialchars($_POST['news_type'],ENT_QUOTES);
  //echo "news_type is :: ".$news_type."<br>\n";    
  //Configuration of POST and GET Variables
  
  $update_sql =  "UPDATE news SET ";
  $update_sql .= " news_title ='".$news_title."', news_content ='".$news_content."', news_link ='".$news_link."', news_type ='".$news_type."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  Header("Location:admin.php");

  mysql_close($dbh);  

?>
