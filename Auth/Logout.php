<?php
session_start();
unset($_SESSION['jwt']);
session_destroy();

header("Location: Login.php");
exit;
