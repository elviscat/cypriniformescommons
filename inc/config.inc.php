<?php
/******************************
**	config.inc.php
**	elviscat@gmail.com
**  Elvis Hsin-Hui Wu
**  05/27/2011 Friday
**  version2:
**  01/27/2010 Wednesday?
**  version3:
**  ??/??/200? Wednesday?
*
*******************************/
// ./??????
// ../??????

function taxon_name1($lv, $id){
  /*
  include('template/dbsetup.php');  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  */
  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = $nb[0]." ".$nb[1];
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  //mysql_close($link); 
  
  //$return_word = "Level: ".ucwords($lv)."<BR>";
  $return_word .= $account_name;
  //echo "Hello Elvis!";
  return $return_word;
}

function taxon_name($lv, $id){
  /*
  include('template/dbsetup.php');  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  */
  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  //mysql_close($link); 
  
  //$return_word = "Level: ".ucwords($lv)."<BR>";
  $return_word .= "Taxon: ".$account_name;
  //echo "Hello Elvis!";
  return $return_word;
}

function taxon_name_with_level($lv, $id){

  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  $return_word .= $account_name."(".ucwords($lv).")<br>\n";
  
  return $return_word;
}

function taxon_name_without_level($lv, $id){

  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = $nb[0]." ".$nb[1];
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  $return_word .= $account_name."<br>\n";
  
  return $return_word;
}




function get_ref_c_id_from_pid($pid){

  $cid = "";
  $sql_taxon_lv_and_id = "SELECT * FROM post WHERE pid ='".$pid."'";
  $result_taxon_lv_and_id = mysql_query($sql_taxon_lv_and_id);
  if(mysql_num_rows($result_taxon_lv_and_id) > 0){
    while ( $nb_taxon_lv_and_id = mysql_fetch_array($result_taxon_lv_and_id) ) {
      $sql_ref_c_id = "SELECT * FROM committee_account WHERE level ='".$nb_taxon_lv_and_id[5]."' AND account_id ='".$nb_taxon_lv_and_id[6]."'";
      //echo $sql_ref_c_id;
      $result_ref_c_id = mysql_query($sql_ref_c_id);
      if(mysql_num_rows($result_ref_c_id) > 0){
        while ( $nb_ref_c_id = mysql_fetch_array($result_ref_c_id) ) {
          $cid = $nb_ref_c_id[3];
        }
      }
    }
  }
  
  $return_word .= $cid;
  
  return $return_word;
}


function get_pid_from_committee_id($committee_id){

  $pid = "";
  $sql_refpid = "SELECT * FROM committee_grp WHERE id ='".$committee_id."'";
  $result_refpid = mysql_query($sql_refpid);
  if(mysql_num_rows($result_refpid) > 0){
    while ( $nb_refpid = mysql_fetch_array($result_refpid) ) {
      $pid = $nb_refpid[4];
    }
  }
  $return_word = $pid;
  return $return_word;
}


function post_title($pid){

  $sql = "SELECT * FROM post WHERE pid =".$pid;
  $result_sql = mysql_query($sql);
  $post_title = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $post_title = $nb_sql[1];//ptitle
    }
  }
  
  $return_word .= $post_title."<br>\n";
  
  return $return_word;
}

function post_date($pid){

  $sql = "SELECT * FROM post WHERE pid =".$pid;
  $result_sql = mysql_query($sql);
  $post_date = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $post_date = $nb_sql[3];//pcredate
    }
  }
  
  $return_word .= $post_date;
  
  return $return_word;
}

function post_uid($pid){

  $sql = "SELECT * FROM post WHERE pid =".$pid;
  $result_sql = mysql_query($sql);
  $post_uid = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $post_uid = $nb_sql[4];//prefuid
    }
  }
  
  $return_word .= $post_uid;
  
  return $return_word;
}

function poster_name($uid){

  $sql = "SELECT * FROM user WHERE uid =".$uid;
  $result_sql = mysql_query($sql);
  $poster_name = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $poster_name = $nb_sql[3];//name
    }
  }
  
  $return_word .= $poster_name;
  
  return $return_word;
}



function post_title_for_taxon_chg_search($pid){

  $sql = "SELECT * FROM post WHERE pid =".$pid;
  $result_sql = mysql_query($sql);
  $post_title = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $post_title = $nb_sql[1];//ptitle
    }
  }
  
  $return_word .= $post_title;
  
  return $return_word;
}

function taxon_name_without_level_for_taxon_chg_search($lv, $id){

  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = $nb[0]." ".$nb[1];
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  $return_word .= $account_name;
  
  return $return_word;
}



function user_name($uid){

  $sql = "SELECT * FROM user WHERE uid =".$uid;
  $result_sql = mysql_query($sql);
  $user_name = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $user_name = $nb_sql[3];//user_name
    }
  }
  
  $return_word .= $user_name."\n";
  
  return $return_word;
}

function user_email($uid){

  $sql = "SELECT * FROM user WHERE uid =".$uid;
  $result_sql = mysql_query($sql);
  $user_email = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $user_email = $nb_sql[7];//user_email
    }
  }
  
  $return_word .= $user_email;
  
  return $return_word;
}



function taxon_name_by_pid($pid){

  $sql_get_lv_id = "SELECT * FROM post WHERE pid ='".$pid."'";
  $result_sql_get_lv_id = mysql_query($sql_get_lv_id);
  $lv = "";
  $id = "";
  if(mysql_num_rows($result_sql_get_lv_id) > 0){
    while ( $nb_sql_get_lv_id = mysql_fetch_array($result_sql_get_lv_id) ) {
      $lv = $nb_sql_get_lv_id[5];
      $id = $nb_sql_get_lv_id[6];
    }
  }  

  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  //mysql_close($link); 
  
  //$return_word = "Level: ".ucwords($lv)."<BR>";
  $return_word .= "Taxon: ".$account_name;
  //echo "Hello Elvis!";
  return $return_word;
}

function taxon_name_by_pid2($pid){

  $sql_get_lv_id = "SELECT * FROM post WHERE pid ='".$pid."'";
  $result_sql_get_lv_id = mysql_query($sql_get_lv_id);
  $lv = "";
  $id = "";
  if(mysql_num_rows($result_sql_get_lv_id) > 0){
    while ( $nb_sql_get_lv_id = mysql_fetch_array($result_sql_get_lv_id) ) {
      $lv = $nb_sql_get_lv_id[5];
      $id = $nb_sql_get_lv_id[6];
    }
  }  

  $sql_account_name = "";
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
      }else{
        $account_name = $nb[0];
      }
    }
  }
  
  //mysql_close($link); 
  
  //$return_word = "Level: ".ucwords($lv)." ";
  $return_word .= "Taxon: ".$account_name;
  //echo "Hello Elvis!";
  return $return_word;
}

function taxa_name($selected_taxa){ 
  //$return_word = $selected_taxa;
  $return_word = "";
  
  //echo "Variable selected_taxa is :: ".$selected_taxa."<br>\n";
  $array_selected_taxa = explode(",", $selected_taxa);
  for($i = 0; $i < sizeof($array_selected_taxa);$i++){
    $array_selected_taxa2 = explode(";", $array_selected_taxa[$i]);   
    $lv = $array_selected_taxa2[0];
    $id = $array_selected_taxa2[1];
    
    //echo $lv."<BR>\n";
    //echo $id."<BR>\n";
    
    $sql_account_name = "";
    if($lv == "family"){
      $sql_account_name .= "SELECT ffamily FROM flist WHERE fid =".$id;
    }elseif($lv == "genus"){
      $sql_account_name .= "SELECT ggenus FROM glist WHERE gid =".$id;
    }elseif($lv == "species"){
      $sql_account_name .= "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
    }
    //echo "11".$sql_account_name."<BR>\n";
    $result_sql_account_name = mysql_query($sql_account_name);
    
    $account_name = "";
    if(mysql_num_rows($result_sql_account_name) > 0){
      while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
        if($lv == "species"){
          $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
        }else{
          $account_name = $nb[0];
        }
      }
    }
        
    //$return_word .= "Level: ".ucwords($lv)." ";
    $return_word .= "Taxon: ".$account_name."<BR>";
    
  }  
  
  //echo "Hello Elvis!";
  return $return_word;
}


function email($host, $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content ){
  //$admin_email = "elviscat@gmail.com";
  //$from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
  //check the email address is okay or not
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  //$mail->Host = "slumailrelay.slu.edu"; // SMTP servers
  $mail->Host = $host; // SMTP servers
  $mail->SMTPAuth = false; // turn on SMTP authentication
  $mail->Username = ""; // SMTP username
  $mail->Password = ""; // SMTP password
  $mail->From = $from_email;
  $mail->FromName = $from_email_name;
  // 執行 $mail->AddAddress() 加入收件者，可以多個收件者
  
  $mail->AddAddress($eml_address);
  //$mail->AddAddress("elviscat@gmail.com","his name"); // optional name
  $mail->AddReplyTo($from_email,$from_email_name);
  $mail->WordWrap = 500; // set word wrap
  // 執行 $mail->AddAttachment() 加入附件，可以多個附件
  //$mail->AddAttachment("path_to/file"); // attachment
  //$mail->AddAttachment("path_to_file2", "INF");
  // 電郵內容，以下為發送 HTML 格式的郵件  
  $mail->IsHTML(true); // send as HTML
  $mail->Subject = $eml_subject;
  $mail->Body = $eml_content;
  $mail->AltBody = "This is the text-only body";
  
  //echo "Hello Elvis!";
  
  $result = "";
  if(!$mail->Send()){
    $result .= "eml_address is :: ".$eml_address."::Mailer Error: " . $mail->ErrorInfo."<br>\n";
    //exit;
  }else{
    $result .= "Hi ".$eml_address.", you have already sent this email!<br>\n";
  }
  //echo $from_email."\n";
  //echo $from_email_name."\n";
  //echo $result;
  return $result;
}





function hexToAsciiToString($hex){
  $strLength = strlen($hex);
  for( $i = 0; $i < $strLength; $i++ ){
		if( substr($hex, $i, 1) == "%"){
      //echo "hex code is ".substr($hex, $i, 3)."\n";
      //echo "str is ".chr(hexdec(substr($hex, $i, 3)))."\n";
      $temp_str = chr(hexdec(substr($hex, $i, 3)));
      $hex = substr_replace ($hex, $temp_str, $i, 3);
    }
    if( substr($hex, $i, 1) == "+"){
      $temp_str = " ";
      $hex = substr_replace ($hex, $temp_str, $i, 1);
    }     
  }
  //echo $hex."\n";
  return $hex;
}

function curPageURL() {
 
 $requestURI = $_SERVER["REQUEST_URI"];
 $requestURI2 = "";
 $array_requestURI = explode("/", $requestURI);
 for( $i = 0; $i < (sizeof($array_requestURI)-1); $i++){
   $requestURI2 .= $array_requestURI[$i]."/";
 }
 
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$requestURI2;
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$requestURI2;
 }
 return $pageURL;

}

function curPageURL2() {
 
 $requestURI = $_SERVER["REQUEST_URI"];
 $requestURI_1 = "";
 $requestURI_2 = "";
 $array_requestURI_0 = explode("?", $requestURI);
 $requestURI_1 = $array_requestURI_0[0];
 $array_requestURI_1 = explode("/", $requestURI_1);
 for( $i = 0; $i < (sizeof($array_requestURI_1)); $i++){
   $requestURI_2 .= $array_requestURI_1[$i]."/";
 }
 
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$requestURI_2;
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$requestURI_2;
 }
 $pageURL = substr($pageURL, 0, -1);
 return $pageURL;

}



$admin_email = "admin@cypriniformes.org";
$admin_name = "Administrator of ACSI-2";

//$from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
$from_email_name = "Administrator of ACSI-2";

//$application_caption = "<font size=\"6\">Taxon Tracker</font><sub>Beta</sub>";
$application_caption = "Cypriniformes Commons";




$initime = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"


/**Time Drift*/
$timestamp = time();
//echo strftime( "%Hh%M %A %d %b",$timestamp);
//echo "p";
//echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);

/**Test*/
//echo $initime;
//echo "<BR>";
/**Test*/

$date_time_array = getdate($timestamp);
$hours = $date_time_array["hours"];
$minutes = $date_time_array["minutes"];
$seconds = $date_time_array["seconds"];
$month = $date_time_array["mon"];
$day = $date_time_array["mday"];
$year = $date_time_array["year"];
// 用mktime()函數重新產生Unix時間戳值
// 增加19小時
//$timestamp = mktime($hours + 19, $minutes,$seconds ,$month, $day,$year);
//echo strftime( "%Hh%M %A %d %b",$timestamp);
//echo "br~E after adding 19 hours";
$timestamp = mktime($hours, $minutes,$seconds ,$month, $day + 180,$year);
//echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);

/**Test*/
//echo date("Y-m-d H:i:s",$timestamp);
/**Test*/

/**Time Drift*/
$expirationtime = date("Y-m-d H:i:s",$timestamp);

$timestamp_last_six_months = mktime($hours, $minutes,$seconds ,$month, $day - 180,$year);

$last_six_months_time = date("Y-m-d H:i:s",$timestamp_last_six_months);



?>
