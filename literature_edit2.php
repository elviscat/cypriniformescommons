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

  
  //$literature_infor = htmlspecialchars($_POST['literature_infor'],ENT_QUOTES);
  $literature_infor = $_POST['literature_infor'];
  $literature_infor = stripslashes($literature_infor);  
  //echo "literature_infor is :: ".$literature_infor."<br>\n";
  
  //$misc = htmlspecialchars($_POST['misc'],ENT_QUOTES);
  $misc = $_POST['misc'];
  $misc = stripslashes($misc);  
  //echo "misc is :: ".$misc."<br>\n";  
  
  $attachment = htmlspecialchars($_POST['attachment'],ENT_QUOTES);
  $attachment_check = substr($attachment, -1);
  if( $attachment_check == ";"){
    $attachment = substr($attachment, 0, -1);
  }
  
  $attachment_id_string = "";
  $sql = "SELECT * from literature WHERE id ='".$id."'";
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
  
  $update_sql =  "UPDATE literature SET ";
  $update_sql .= " literature_infor ='".addslashes($literature_infor)."', misc ='".addslashes($misc)."', attachment_id ='".$attachment_id."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  Header("Location:admin.php");

  mysql_close($dbh);  

?>
