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
$dbh = mysql_connect($hostname, $username, $password) 
  or die("Unable to connect to mysql");
//print "connected to mysql<br>";
$selected = mysql_select_db("acsi",$dbh) 
  or die("Could not select this database");
//$result = mysql_query("SELECT id, news_title FROM news ORDER BY id DESC LIMIT 0, 5 ");

//while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
//  print "<a href=\"news.php?id=".$row{'id'}."\" target=\"_parent\"><strong>".$row{'news_title'}."</strong></a><br>";
//}

//name 	pos 	institution 	area 	country 	addr 	eml 	tel 	gen_res_int 	acsi2_targeted_taxa 	char_type 	photo 	misc 	web 	is_core_pi 	acsi2_role 	password 	security_question_answer 	is_participated 	is_activated
$id = $_POST['id'];
$name = $_POST['name'];
$pos = $_POST['pos'];
$institution = $_POST['institution'];
$area = $_POST['area'];
$country = $_POST['country'];
$addr = $_POST['addr'];
$tel = $_POST['tel'];
$gen_res_int = $_POST['gen_res_int'];
$acsi2_targeted_taxa = $_POST['acsi2_targeted_taxa'];
$char_type = $_POST['char_type'];
$misc = $_POST['misc'];
$web = $_POST['web'];
$security_question_answer = $_POST['security_question_answer'];
$openid = $_POST['openid'];


$column_array = array();
$value_array = array();

array_push($column_array, 'name');
array_push($value_array, $name);

array_push($column_array, 'pos');
array_push($value_array, $pos);

array_push($column_array, 'institution');
array_push($value_array, $institution);

array_push($column_array, 'area');
array_push($value_array, $area);

array_push($column_array, 'country');
array_push($value_array, $country);

array_push($column_array, 'addr');
array_push($value_array, $addr);

array_push($column_array, 'tel');
array_push($value_array, $tel);

array_push($column_array, 'gen_res_int');
array_push($value_array, $gen_res_int);

array_push($column_array, 'acsi2_targeted_taxa');
array_push($value_array, $acsi2_targeted_taxa);

array_push($column_array, 'char_type');
array_push($value_array, $char_type);

array_push($column_array, 'misc');
array_push($value_array, $misc);

array_push($column_array, 'web');
array_push($value_array, $web);

array_push($column_array, 'security_question_answer');
array_push($value_array, $security_question_answer);

array_push($column_array, 'openid');
array_push($value_array, $openid);


for ($i =0; $i < sizeof($column_array); $i++){
	$sql_update = "Update participants SET ".$column_array[$i]." = '".$value_array[$i]."' WHERE id ='".$id."'";
	//echo "\$sql_update is : ".$sql_update."<br>\n";
	mysql_query($sql_update) or die ("Error Message: ".mysql_error());
	if(!mysql_query($sql_update)){
		Header("location:personal_info_edit_error.php?error_msg=".mysql_error());
	}
}
mysql_close($dbh);
Header("location:admin.php");
	
?>

