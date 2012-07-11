<?php 
  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) || $_SESSION['username'] == "" ){
    echo "<p class=\"text1\"><a href=\"login.php\" target=\"_parent\">Login</a></p>";
  }else{
	echo "<p class=\"text1\"><a href=\"admin.php\" target=\"_parent\">User Dashboard</a> <a href=\"logout.php\" target=\"_parent\">Logout</a></p>";
  }
?>



