<?php
$userInfoJSON = $_SESSION['user_info'];
$userInfo = json_decode($userInfoJSON , true);

$Views = array();

$Views['userInfo'] = $userInfo;
