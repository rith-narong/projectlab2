<?php
session_start();
session_unset();
session_destroy();
header("Location: /projectlab2/index.php");
exit;
?>