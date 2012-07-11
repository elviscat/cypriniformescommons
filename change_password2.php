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

$ori_password = base64_encode($_POST['ori_password']);
$new_password = base64_encode($_POST['new_password']);
$new_password_confirmation = base64_encode($_POST['new_password_confirmation']);

$eml;
$result = mysql_query("SELECT * FROM `participants` WHERE eml = '".$_SESSION['username']."'");
while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	$eml = $row{'eml'};
}	
	
  
$sql = "SELECT * FROM participants WHERE eml = '".$eml."' and password = '".$ori_password."'";
//echo "Variable sql is : ".$sql."<br>\n";
$result = mysql_query($sql);
if( mysql_num_rows($result) > 0){
  $regtime = date('Y-m-d h:i:s');

  if( $ori_password == "" || $new_password == "" || $new_password_confirmation == ""){
    //echo "Forgot Password Error 1";
	Header("location:change_password_result.php?msg=You didn't type your original password or new password. Please send this error message to Cypriniformes Commons Administrator, thanks much!");
  }else if($reset_password != $reset_password_confirmation){
    //echo "Forgot Password Error 2";
	Header("location:change_password_result.php?msg=Your new password and new password confirmation is not matching! Please send this error message to Cypriniformes Commons Administrator, thanks much!");
  }else{
    
	//echo "eml is ".$eml."\n<br>";
    
  
    //$admin_email = "elviscat@gmail.com";
    //$from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
    $from_email = $admin_email;
    $from_email_name = $from_email_name;
  
    //check the email address is okay or not
    $mail = new PHPMailer();
    $mail->IsSMTP(); // send via SMTP
    $mail->Host = "slumailrelay.slu.edu"; // SMTP servers
    $mail->SMTPAuth = false; // turn on SMTP authentication
    $mail->Username = ""; // SMTP username
    $mail->Password = ""; // SMTP password
    $mail->From = $admin_email;
    $mail->FromName = $from_email_name;
    
    $mail->AddAddress($eml);
    //$mail->AddAddress("elviscat@gmail.com","elviscat2@gmail.com"); // optional name
    $mail->AddReplyTo($admin_email,$from_email_name);
    $mail->WordWrap = 50; // set word wrap
  
    //$mail->AddAttachment("path_to/file"); // attachment
    //$mail->AddAttachment("path_to_file2", "INF");
  
    $mail->IsHTML(true); // send as HTML
    $mail->Subject = "You have changed your password in ACSI-2 at ".date('l jS \of F Y h:i:s A');
    //$mail->Body = "This is the <b>HTML body</b>";
    $mail->Body = "Hi ".$_SESSION['username'].",<br>";
    $mail->Body .= "Your new passwrd is <B>".base64_decode($new_password)."</B>.<br>";
	$mail->Body .= "Please go to <a href=\"".curPageURL()."login.php\">login page</a> and use new password to login!<br>";
    $mail->Body .= "Sincerely,<br>";
    $mail->Body .= "ACSI-2 System Administrator";
    $mail->AltBody = "This is the text-only body";
    if(!$mail->Send()){
      echo "Your email is not valid, please type correct email again!";
      //echo "Mailer Error: " . $mail->ErrorInfo;
      exit;
    }else{
	  $update_sql = "UPDATE participants SET password = '".$new_password."' WHERE eml = '".$eml."' and password = '".$ori_password."'";
      //echo "update_sql is ".$update_sql."\n<br>";
      $result=mysql_query($update_sql);
      //echo "Yes, you can insert into database!";
    
      //echo "Your email seems correct but need to validate again. Then the account would be activated! ";//need to modified
      //Modified on April 05, 2010 Monday
      //echo "Thanks for your interest in Taxon Tracker. An e-mail has been sent to the e-mail address provided to confirm it is valid.";
      //Modified on April 05, 2010 Monday
	  Header("location:change_password_result.php?msg=You have changed your password successfully!");
    }
  }
}else{
  Header("location:change_password_result.php?msg=Error, not valid password! Please send this error message to Cypriniformes Commons Administrator, thanks much!");
}
mysql_close($dbh);

?>

