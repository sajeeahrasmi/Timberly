<?php
session_start();
session_destroy();
header("Location: ../public/landingPage.html");
exit;
?>
