<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 12, 2010 Friday:: upload module
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	Header("location:authorizedFail.php");
	exit();
  }  

//$uploaddir = 'upload/';
//wedon't need this anymore since we store the uploaded file in database
$upload_file_name = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

if($_FILES['userfile']['size'] >  0){
  $fileName = $_FILES['userfile']['name'];
  $tmpName  = $_FILES['userfile']['tmp_name'];
  $fileSize = $_FILES['userfile']['size'];
  $fileType = $_FILES['userfile']['type'];

  $fp = fopen($tmpName, 'r');
  $content = fread($fp, filesize($tmpName));
  $content = addslashes($content);
  fclose($fp);

  if(!get_magic_quotes_gpc()){
    $fileName = addslashes($fileName);
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
  
  
  $upload_datetime = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  
  $username = $_SESSION['username'];
  $refuid = 0;
  $sql_find_uid = "SELECT id from participants WHERE eml ='".$username."'";
  $result_sql_find_uid = mysql_query($sql_find_uid);  
  if(mysql_num_rows($result_sql_find_uid) > 0){
    while ( $nb_sql_find_uid = mysql_fetch_array($result_sql_find_uid) ) {
      $refuid = $nb_sql_find_uid[0];
    }
  }
  
  $query = "INSERT INTO upload (name, size, type, content, refuid, upload_time ) ".
  "VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$refuid', '$upload_datetime')";
  
  if (mysql_query($query)){
    //echo "<br>File $fileName uploaded<br>";
    $max_id = 0;
    $sql_max_id = "SELECT max(id) from upload";
    $result_sql_max_id = mysql_query($sql_max_id);
    if(mysql_num_rows($result_sql_max_id) > 0){
      while ( $nb_sql_max_id = mysql_fetch_array($result_sql_max_id) ) {
        $max_id = $nb_sql_max_id[0];
      }
    }
    echo $max_id.";".$fileName;//response to ajax upload
  }else{
    //or die('Error, query failed');
    echo "0;Fail to upload!";//response to ajax upload
  } 
  mysql_close($dbh);
}else{
  echo "0;Fail to upload: File size may exceed to 2MB.";//response to ajax upload
}

/*
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  //echo "success";
  //echo "success:<a href:\"".$uploadfile."\">".$upload_file_name."</a>";
  echo "success:".$upload_file_name." Go to this link to download: http://maydenlab.slu.edu/~hwu5/100305/demos/upload/".$upload_file_name;
} else {
  // WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
  // Otherwise onSubmit event will not be fired
  //echo "error";
  echo "error: fail to upload this file".$uploadfile;
}
*/
