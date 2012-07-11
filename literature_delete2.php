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

  //Configuration of POST and GET Variables
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  $delete = htmlspecialchars($_POST['delete'],ENT_QUOTES);
  //echo "delete is :: ".$delete."<br>\n";
  //Configuration of POST and GET Variables
  if($delete == "yes"){
    //
	$delete_sql =  "DELETE FROM literature WHERE id = ".$id;
    //echo "delete_sql is ".$delete_sql."<br>\n";
    $result = mysql_query($delete_sql);
  }else{
    //Do nothing!
  }
  Header("Location:admin.php");

  

  mysql_close($dbh);  

?>

</body>
</html>
