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

$name = $_POST['name'];
$loginname = $_POST['loginname'];
$password = base64_encode($_POST['password']);
$password_confirmation = base64_encode($_POST['password_confirmation']);
$security_question_answer = $_POST['security_question_answer'];



$eml = $loginname;
  
$sql = "SELECT * FROM participants WHERE eml = '".$eml."'";
//echo "Variable sql is : ".$sql."<br>\n";
$result = mysql_query($sql);
if( mysql_num_rows($result) > 0){
  //echo "Account is already registered!";
  Header("location:account_already_registered.php");
}else{

  $regtime = date('Y-m-d h:i:s');

  if( $loginname == "" || $password == "" || $password_confirmation == "" || $name == "" || $security_question_answer == ""){
    //echo "Sign Up Error 1";
	Header("location:sign_up_error.php?error_msg=you need fill out all fields!");
  }else if($password != $password_confirmation){
    //echo "Sign Up Error 2";
	Header("location:sign_up_error.php?error_msg=password should match confirm password!");
  }else{
    
	//echo "eml is ".$eml."\n<br>";
    $activationkey = md5($loginname);
  
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
    $mail->Subject = "You have signed up an account in Cypriniformes Commons (cypriniformes.org) with ACSI-2 project at ".date('l jS \of F Y h:i:s A');
    //$mail->Body = "This is the <b>HTML body</b>";
    $mail->Body = "Hi ".$name.",<br>";
    $mail->Body .= "Your login name is ".$_POST['loginname']." and your password is ".$_POST['password']."<br>";
	$mail->Body .= "Please go to this link to activate your account: <a href=\"".curPageURL()."emailvalidate.php?loginname=".$eml."&key=".$activationkey."\">".curPageURL()."emailvalidate.php?loginname=".$eml."&key=".$activationkey."</a><br>";
    $mail->Body .= "Sincerely,<br>";
    $mail->Body .= "ACSI-2 System Administrator";
    $mail->AltBody = "This is the text-only body";
    if(!$mail->Send()){
      echo "Your email is not valid, please type correct email again!";
      //echo "Mailer Error: " . $mail->ErrorInfo;
      exit;
    }else{
      $max_id = 0;
      //echo "Your recommendation has been sent.";
      //okay, insert the sign up information into database
	  $max_id_sql = "SELECT (Max(id)+1) FROM participants";
	  $result_max_id = mysql_query($max_id_sql);	  
      list($max_id) = mysql_fetch_row($result_max_id);
	  if($max_id == 0){
		$max_id = 1;
	  }
	  $insert_sql = "INSERT INTO participants (id, name, eml, password, security_question_answer, acsii_role, is_participated, is_activated)";
      $insert_sql .= " VALUES ('$max_id', '$name', '$eml','$password', '$security_question_answer', 'member', 'no', 'no')";
      //echo "insert_sql is ".$insert_sql."\n<br>";
      $result=mysql_query($insert_sql);
      //echo "Yes, you can insert into database!";
    
      //echo "Your email seems correct but need to validate again. Then the account would be activated! ";//need to modified
      //Modified on April 05, 2010 Monday
      //echo "Thanks for your interest in Taxon Tracker. An e-mail has been sent to the e-mail address provided to confirm it is valid.";
      //Modified on April 05, 2010 Monday
	  Header("location:sign_up_success.php");
    }
  }
  
}
mysql_close($dbh);

?>

