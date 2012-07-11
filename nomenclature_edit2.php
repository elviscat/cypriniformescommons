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

  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER_SET_CLIENT=utf8");
  mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 

  //Configuration of POST and GET Variables
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";

  
  //$nomenclature_announcement = htmlspecialchars($_POST['nomenclature_announcement'],ENT_QUOTES);
  $nomenclature_announcement = $_POST['nomenclature_announcement'];
  $nomenclature_announcement = stripslashes($nomenclature_announcement);  
  //echo "nomenclature_announcement is :: ".$nomenclature_announcement."<br>\n";
  
  //$citation = htmlspecialchars($_POST['citation'],ENT_QUOTES);
  $citation = $_POST['citation'];
  $citation = stripslashes($citation);  
  //echo "citation is :: ".$citation."<br>\n";  
  
  $attachment = htmlspecialchars($_POST['attachment'],ENT_QUOTES);
  $attachment_check = substr($attachment, -1);
  if( $attachment_check == ";"){
    $attachment = substr($attachment, 0, -1);
  }
  
  $attachment_id_string = "";
  $sql = "SELECT * from nomenclature WHERE id ='".$id."'";
  //echo $sql;
  $result_sql = mysql_query($sql);
  if(mysql_num_rows($result_sql) > 0){
      while ( $nb_sql = mysql_fetch_array($result_sql) ) {
          $attachment_id_string = $nb_sql[3];
      }
  }
  
  if($attachment_id_string != ""){
    $attachment_id = $attachment_id_string.";".$attachment;
  }else{
    $attachment_id = $attachment;
  }
  
  $update_sql =  "UPDATE nomenclature SET ";
  $update_sql .= " nomenclature_announcement ='".$nomenclature_announcement."', citation ='".$citation."', attachment_id ='".$attachment_id."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  Header("Location:admin.php");

  mysql_close($dbh);  

?>
