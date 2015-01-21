<?php
$Views = array();

// $Views['user_group'] =  factory::getModel('hx_user_group')->get_groups();

$userInfo = json_decode($_SESSION['user_info'] , true);

$user_group = factory::getModel('hx_user_group')->get_groups_by_control($userInfo['id'] , 0 , 100);

$Views['user_group'] = $user_group['data'];

$user_role = factory::getModel('hx_user_role')->get_roles_by_control($userInfo['id'] , 0 , 10000);

$Views['user_role'] = $user_role['data'];

$user_workset = factory::getModel('hx_workset')->get_worksets_by_control($userInfo['id'] , 0 , 10000);

$Views['worksets'] =  $user_workset['data'];
