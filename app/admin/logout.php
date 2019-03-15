<?php
# microText ver 0.6
# http://microText.info

session_start();
$_SESSION['logout'] = true;
header('Location: ../index.php');
