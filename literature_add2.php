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
  
  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER_SET_CLIENT=utf8");
  mysql_query("SET CHARACTER_SET_RESULTS=utf8"); 
  
  //Configuration of POST and GET Variables

  //$literature_infor = htmlspecialchars($_POST['literature_infor'],ENT_QUOTES);
  $literature_infor = $_POST['literature_infor'];
  $literature_infor = stripslashes($literature_infor);
  //echo "literature_infor is :: ".$literature_infor."<br>\n";

  //$misc = htmlspecialchars($_POST['misc'],ENT_QUOTES);
  $misc = $_POST['misc'];
  $misc = stripslashes($misc);
  //echo "misc is :: ".$misc."<br>\n";
  
    
  $attachment = htmlspecialchars($_POST['attachment'],ENT_QUOTES);
  $attachment_check = substr($attachment, -1);
  if( $attachment_check == ";"){
    $attachment = substr($attachment, 0, -1);
  }
  
  //$owner = $_SESSION[username];
  $owner = $_SESSION['id'];
  //echo "owner is :: ".$owner."<br>\n";
  
  //Configuration of POST and GET Variables
  
  //Find maximun id number in TABLE::news
  $maxid = 0;
  $max_id_sql = "SELECT (Max(id)+1) FROM literature";
  $result_max_id = mysql_query($max_id_sql);	  
  list($maxid) = mysql_fetch_row($result_max_id);
    if($maxid == 0){
	  $maxid = 1;
  }
  $datetime = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  $approval_key = mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
  $disapproval_key = mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
  
  //INSERT INTO `acsi`.`news` (`id` ,`news_title` ,`news_content` ,`news_link` ,`news_type` ,`news_publisher` ,`news_published_date`) VALUES ('2', 'Cobitodea conference 2', '111', 'http://cypriniformes.org/', '111', '111', '2010-12-08 17:30:59');
  //$sql_insert = "INSERT INTO news (`id`, `news_title`, `news_content`, `news_author`, `news_datetime`) ";
  //$sql_insert .= "VALUES ('$maxid', '$news_title', '$news_content', 'maydenrl', '$datetime')";  
  
  //$sql_insert = "INSERT INTO literature (`id` ,`literature_infor` ,`misc` ,`attachment_id` ,`owner` ,`upload_date` ,`status`) ";
  //$sql_insert .= "VALUES ('$maxid', '$literature_infor', '$misc', '$attachment', '$owner', '$datetime', 'Under Review')";
  $sql_insert = "INSERT INTO literature (`id` ,`literature_infor` ,`misc` ,`attachment_id` ,`owner` ,`upload_date` ,`status` ,`approval_key` ,`disapproval_key`) ";
  $sql_insert .= "VALUES ('$maxid', '$literature_infor', '$misc', '$attachment', '$owner', '$datetime', 'Under Review', '$approval_key', '$disapproval_key')";




  $sql_admin_email_addresses = "SELECT * FROM participants WHERE acsi2_role ='admin'";
  $result_admin_email_addresses = mysql_query($sql_admin_email_addresses);
  if( mysql_num_rows($result_admin_email_addresses) > 0){
	while($nb_admin_email_addresses = mysql_fetch_array($result_admin_email_addresses)){
	
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
  
	  $mail->AddAddress($nb_admin_email_addresses['eml']);
	  //$mail->AddAddress("elviscat@gmail.com","elviscat2@gmail.com"); // optional name
	  $mail->AddReplyTo($admin_email,$from_email_name);
	  $mail->WordWrap = 50; // set word wrap
  
	  //$mail->AddAttachment("path_to/file"); // attachment
	  //$mail->AddAttachment("path_to_file2", "INF");
  
	  $mail->IsHTML(true); // send as HTML
	  $mail->Subject = "A new research material is posted by ".$_SESSION['general_name']." in ACSI-2 at ".date('l jS \of F Y h:i:s A');
	  //$mail->Body = "This is the <b>HTML body</b>";
	  $mail->Body = "Hi ".$nb_admin_email_addresses['name'].",<br>";
	  $mail->Body .= "A new research material is posted <a href=\"".curPageURL()."literature.php?id=".$maxid."\">here</a>!<br>";	  
	  $mail->Body .= "<B>Research Material Information:</B><BR> ".$literature_infor."<br>";
	  $mail->Body .= "<B>Miscellaneous:</B><BR> ".$misc."<br>";
	  $mail->Body .= "Please review it and decide to <a href=\"".curPageURL()."validate_contribution.php?type=research_materials&key=".$approval_key."&id=".$maxid."&decided_by=".$nb_admin_email_addresses['id']."\">publish</a> ";
	  $mail->Body .= "or <a href=\"".curPageURL()."validate_contribution.php?type=research_materials&key=".$disapproval_key."&id=".$maxid."&decided_by=".$nb_admin_email_addresses['id']."\">not publish</a>!<br>";
	  $mail->Body .= "Sincerely,<br>";
	  $mail->Body .= "ACSI-2 System Agent";
	  $mail->AltBody = "This is the text-only body";
	  if(!$mail->Send()){
	  	echo "Your email is not valid, please type correct email again!";
	  	//echo "Mailer Error: " . $mail->ErrorInfo;
	  	exit;
	  }
    }
  }


  //echo "sql_insert is ".$sql_insert."<br>\n";
  mysql_query($sql_insert);
  mysql_close($dbh);
  Header("Location:admin.php");
?>