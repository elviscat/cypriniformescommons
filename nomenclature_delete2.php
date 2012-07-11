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
  $delete = htmlspecialchars($_POST['delete'],ENT_QUOTES);
  //echo "delete is :: ".$delete."<br>\n";
  //Configuration of POST and GET Variables
  if($delete == "yes"){
    //
	$delete_sql =  "DELETE FROM nomenclature WHERE id = ".$id;
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
