<?php
session_start();
session_unset();
session_regenerate_id();
session_destroy();
header("Location: ../pages/login.php");
exit;
?>