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
  
  $owner = $_SESSION[username];
  //echo "owner is :: ".$owner."<br>\n";
  
  //Configuration of POST and GET Variables
  
  //Find maximun id number in TABLE::news
  $maxid = 0;
  $max_id_sql = "SELECT (Max(id)+1) FROM nomenclature";
  $result_max_id = mysql_query($max_id_sql);	  
  list($maxid) = mysql_fetch_row($result_max_id);
    if($maxid == 0){
	  $maxid = 1;
  }
  $datetime = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  //INSERT INTO `acsi`.`news` (`id` ,`news_title` ,`news_content` ,`news_link` ,`news_type` ,`news_publisher` ,`news_published_date`) VALUES ('2', 'Cobitodea conference 2', '111', 'http://cypriniformes.org/', '111', '111', '2010-12-08 17:30:59');
  //$sql_insert = "INSERT INTO news (`id`, `news_title`, `news_content`, `news_author`, `news_datetime`) ";
  //$sql_insert .= "VALUES ('$maxid', '$news_title', '$news_content', 'maydenrl', '$datetime')";  
  $sql_insert = "INSERT INTO nomenclature (`id` ,`nomenclature_announcement` ,`citation` ,`attachment_id` ,`owner` ,`upload_date` ,`status`) ";
  $sql_insert .= "VALUES ('$maxid', '$nomenclature_announcement', '$citation', '$attachment', '$owner', '$datetime', 'Under Review')";
  //echo "sql_insert is ".$sql_insert."<br>\n";
  mysql_query($sql_insert);
  mysql_close($dbh);
  Header("Location:admin.php");
?>