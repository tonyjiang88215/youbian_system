<?php
session_start();
$_SESSION['login'] = false;
$_SESSION['user_info'] = '';

header('Location: login.php');