<!--
Rizal Azhari
XII RPL 1 
-->
<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
