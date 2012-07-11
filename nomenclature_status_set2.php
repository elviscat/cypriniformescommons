<?php
  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:login.php");
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

  //Configuration of POST and GET Variables
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  $decided_by = htmlspecialchars($_POST['decided_by'],ENT_QUOTES);
  //echo "decided_by is :: ".$decided_by."<br>\n";
  $change = htmlspecialchars($_POST['change'],ENT_QUOTES);
  //echo "change is :: ".$change."<br>\n";  
  //Configuration of POST and GET Variables

  $update_sql =  "UPDATE nomenclature SET ";
  $update_sql .= " status ='".$change."', decided_by ='".$decided_by."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);  
  mysql_close($dbh); 
  Header("Location:admin.php");

 

?>

