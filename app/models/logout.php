<?php
session_start();
session_destroy();
header("Location: /public_html/app/control/login.php");
exit;
?>
