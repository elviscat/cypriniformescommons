<?php 
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

$loginname = $_POST['loginname'];

$security_question_answer = $_POST['security_question_answer'];


$eml = $loginname;
  
$sql = "SELECT * FROM participants WHERE eml = '".$eml."' AND security_question_answer = '".$security_question_answer."'";
//echo "Variable sql is : ".$sql."<br>\n";
$result = mysql_query($sql);
if( mysql_num_rows($result) > 0){
  $regtime = date('Y-m-d h:i:s');
  while ( $nb = mysql_fetch_array($result) ) {
    $name = $nb['name'];
	if($name == ''){
	  $name = 'Empty Name';
	}
	$password = base64_decode($nb['password']);
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
    $mail->Subject = "You have requested your password in ACSI-2 at ".date('l jS \of F Y h:i:s A');
    //$mail->Body = "This is the <b>HTML body</b>";
    $mail->Body = "Hi ".$name.",<br>";
    $mail->Body .= "Your password is <B>".$password."</B>.<br>";
	$mail->Body .= "Please go to <a href=\"".curPageURL()."login.php\">login page</a> to login!<br>";
    $mail->Body .= "Sincerely,<br>";
    $mail->Body .= "ACSI-2 System Administrator";
    $mail->AltBody = "This is the text-only body";
    if(!$mail->Send()){
      echo "Your email is not valid, please type correct email again!";
      //echo "Mailer Error: " . $mail->ErrorInfo;
      exit;
    }else{
	  //$update_sql = "UPDATE participants SET password = '".$reset_password."' WHERE eml = '".$loginname."'";
      
	  ////echo "update_sql is ".$update_sql."\n<br>";
      
	  
	  //$result=mysql_query($update_sql);
      
	  ////echo "Yes, you can insert into database!";
    
      ////echo "Your email seems correct but need to validate again. Then the account would be activated! ";//need to modified
      ////Modified on April 05, 2010 Monday
      ////echo "Thanks for your interest in Taxon Tracker. An e-mail has been sent to the e-mail address provided to confirm it is valid.";
      ////Modified on April 05, 2010 Monday
	  //Header("location:forgot_password_reset_success.php");
	  Header("location:forgot_password_success.php");
    }
  }
}else{
  Header("location:forgot_password_error.php");
}
mysql_close($dbh);

?>

