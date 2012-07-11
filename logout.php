<?php
  session_start();
  session_destroy();
  Header("location:logout_already.php");
?>
