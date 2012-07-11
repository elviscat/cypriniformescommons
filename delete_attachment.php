<?php

  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	Header("location:login.php");
	exit();
  }
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  
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

  
  $username = $_SESSION['username'];
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  $attachment_id = htmlspecialchars($_GET['attachment_id'],ENT_QUOTES);
  $type = htmlspecialchars($_GET['type'],ENT_QUOTES);  
 
  if($type == "literature"){
      $attachment_id_array_string = "";
	  $sql = "SELECT * from literature WHERE owner = '".$username."' AND id ='".$id."' AND attachment_id like '%".$attachment_id."%'";
      //echo $sql;
	  $result_sql = mysql_query($sql);
      if(mysql_num_rows($result_sql) > 0){
          while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              $attachment_id_array_string = $nb_sql[3];
          }
      }
	  //echo "attachment_id_array_string is ".$attachment_id_array_string;
	  
	  $attachment_id_array = explode(";", $attachment_id_array_string);
	  //echo "Size:".sizeof($attachment_id_array);
	  $attachment_id_array_string_new = "";
      for($i = 0; $i < sizeof($attachment_id_array); $i++){
        if($attachment_id_array[$i] != $attachment_id && $attachment_id_array[$i] != ""){
		    $attachment_id_array_string_new .= $attachment_id_array[$i].";";
		}
      }
	  $attachment_id_array_string_new = substr($attachment_id_array_string_new, 0, -1);
	  //echo "attachment_id_array_string_new is ".$attachment_id_array_string_new;	   
      
	  $update_sql = "UPDATE literature SET attachment_id = '".$attachment_id_array_string_new."' WHERE id ='".$id."'";
	  mysql_query($update_sql) or die('Error, query failed');
	  
	  $delete_sql = "DELETE FROM upload WHERE id = '$attachment_id'";
      mysql_query($delete_sql) or die('Error, query failed');
      
      mysql_close($dbh);
      Header("location:literature_edit.php?id=".$id);
      exit;

  }elseif($type == "nomenclature"){
      $attachment_id_array_string = "";
	  $sql = "SELECT * from nomenclature WHERE owner = '".$username."' AND id ='".$id."' AND attachment_id like '%".$attachment_id."%'";
      //echo $sql;
	  $result_sql = mysql_query($sql);
      if(mysql_num_rows($result_sql) > 0){
          while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              $attachment_id_array_string = $nb_sql[3];
          }
      }
	  //echo "attachment_id_array_string is ".$attachment_id_array_string;
	  
	  $attachment_id_array = explode(";", $attachment_id_array_string);
	  //echo "Size:".sizeof($attachment_id_array);
	  $attachment_id_array_string_new = "";
      for($i = 0; $i < sizeof($attachment_id_array); $i++){
        if($attachment_id_array[$i] != $attachment_id && $attachment_id_array[$i] != ""){
		    $attachment_id_array_string_new .= $attachment_id_array[$i].";";
		}
      }
	  $attachment_id_array_string_new = substr($attachment_id_array_string_new, 0, -1);
	  //echo "attachment_id_array_string_new is ".$attachment_id_array_string_new;	   
      
	  $update_sql = "UPDATE nomenclature SET attachment_id = '".$attachment_id_array_string_new."' WHERE id ='".$id."'";
	  mysql_query($update_sql) or die('Error, query failed');
	  
	  $delete_sql = "DELETE FROM upload WHERE id = '$attachment_id'";
      mysql_query($delete_sql) or die('Error, query failed');
      
      mysql_close($dbh);
      Header("location:nomenclature_edit.php?id=".$id);
      exit;

  }else{
      //echo "There is no uploaded attached file here!";
      echo "You don't have the authority to delete this file!";
	  exit;  
  }  
  

?>
