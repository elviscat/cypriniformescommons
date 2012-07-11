<?php

  session_start();
  
  $username = "webappconnect";
  $password = "u5QZWEMfAd3fbLLw";
  $hostname = "localhost";	
  $dbh = mysql_connect($hostname, $username, $password) 
    or die("Unable to connect to mysql");
  //print "connected to mysql<br>";
  $selected = mysql_select_db("acsi",$dbh) 
    or die("Could not select this database");
  //$result = mysql_query("SELECT id, news_title FROM news ORDER BY id DESC LIMIT 0, 5 ");

  //while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
  //  print "<a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".$row{'news_title'}."</strong></a><br>";
  //}
   
  $openid = $_GET['gmail'];

  $sql = "SELECT * FROM participants WHERE openid = '".$openid."'";
  //echo "\$sql is : ".$sql."<br>\n";
  
  
  $result = mysql_query($sql);
  if( mysql_num_rows($result) > 0){
    $row = mysql_fetch_array($result);
    //echo "id: ".$row[0]."<br>\n"; // id 
    //echo "name: ".$row[1]."<br>\n"; // name, general name
    //echo "acsi_role: ".$row[17]."<br>\n"; // acsi_role
	//
	
	//echo "\$row{'name'} is".$row{'name'};
	//echo "\$row{'acsi2_role'} is".$row{'acsi2_role'};
	//echo "\$row{'eml'} is".$row{'eml'};
	
	//	 
	//set session
    $_SESSION['username'] = $eml;//eml
	$_SESSION['general_name'] = $row{'name'};//column::name
	$_SESSION['id'] = $row{'id'};//column::name
	$_SESSION['role'] = $row{'acsi2_role'}; //column::acsii_role
	$_SESSION['application_name'] = "Cypriniformes Commons";
	$_SESSION['is_login'] = true;
	
	
	//$_SESSION['uid'] = $row['uid'];
    if( $row{'is_activated'} == "no"){//$row[21] --> is_activated
	  //echo "row[21] is ".$row[21]."<br>\n";
	  $_SESSION['is_activated'] = "no";
	  Header("location:need_to_activate.php"); 
	}else{
	  //echo "row[21] is ".$row[21]."<br>\n";
	  $_SESSION['is_activated'] = "yes";
	  Header("location:admin.php");
	}
	//echo "Hello<br>\n";
    //echo $_SESSION['is_activated']."<br>\n";
    //echo "Hello2<br>\n";
  }else{
    Header("location:loginFail.php");
  }
  
  mysql_close($dbh);   
?>


