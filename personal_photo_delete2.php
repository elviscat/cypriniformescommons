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
	require('phpmailer/class.phpmailer.php');
	require('inc/config.inc.php');
	
	$username = "webappconnect";
	$password = "u5QZWEMfAd3fbLLw";
	$hostname = "localhost";
	$dbh = mysql_connect($hostname, $username, $password) or die("Unable to connect to mysql");
	//print "connected to mysql<br>";
	$selected = mysql_select_db("acsi",$dbh) or die("Could not select this database");
	//$result = mysql_query("SELECT id, news_title FROM news ORDER BY id DESC LIMIT 0, 5 ");

	//while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	//  print "<a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".$row{'news_title'}."</strong></a><br>";
	//}
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");
	
	$id = $_POST['id'];
	
	if(isset($_POST['submit_b']) && $_POST['post_from_form'] === '1'){
		//id 	catalogue_number 	media_type 	media_content 	notes 	notes_from 	upload_datetime 	provider_ref 	page_ref
		$sql_update = "UPDATE `participants` SET photo = '' WHERE id = '".$id."'";
		//echo "\$sql_update is :: ".$sql_update."<BR>\n";
		mysql_query($sql_update) or die(mysql_error());
		mysql_close($dbh);
		Header("location:personal_info_edit.php");
		//
		
	}else if(isset($_POST['back_b'])){
		Header("location:personal_info_edit.php");
	}else{
		echo "Illegal Access!";
	}
	

?>

