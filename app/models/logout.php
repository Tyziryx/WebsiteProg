<?php
session_start();
session_destroy();
header("Location: /AMS/app/control/login.php");
exit;
?>
