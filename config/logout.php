<?php
session_start();
session_destroy();
header("Location: ../public/landingPage.php");
exit;
?>
