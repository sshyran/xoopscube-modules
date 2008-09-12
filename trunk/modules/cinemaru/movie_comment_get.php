<?php

include 'header.php';
require_once('include/db.php');
require_once('include/misc.php');
require_once('constants.php');
include XOOPS_ROOT_PATH.'/header.php';

error_reporting(0); // error report off

$xoopsOption['template_main'] = 'cinemaru_index.html';

$groupperm_showcomment = cinemaru_checkright(CINEMARU_GROUPPERM_SHOWCOMMENT);

if ($groupperm_showcomment) {
    $list = cinemaru_comment_get($_REQUEST['id']);
    
    $user_list = array();
	
    header("Content-type: text/html");
    
    foreach ($list as $key => $val) {
	$user_name = '';
	$user_avatar = '';
	    
	if (@$val['reg_user'] == 0) {
	    $user_name = ',guest';
	} else {
	    $user_id = $val['reg_user'];
		
	    if (isset($user_list[$user_id])) {
		$user = $user_list[$user_id];
	    } else {
		$member_handler =& xoops_gethandler('member');
		$user = $member_handler->getUser($user_id);
		$user_list[$user_id] = $user;
	    }
		
	    if ($xoopsModuleConfig['name_setting'] == 0) {
		$user_name =  $user->getVar('uname');
	    } else if ($xoopsModuleConfig['name_setting'] == 1) {
		$user_name =  $user->getVar('name');
	    } else if ($xoopsModuleConfig['name_setting'] == 2) {
		$user_name = $user->getVar('uname') . '(' . $user->getVar('name') . ')';
	    } else if ($xoopsModuleConfig['name_setting'] == 3) {
		if ($user->getVar('name') != '') {
		    $user_name = $user->getVar('name');
		} else {
		    $user_name = $user->getVar('uname');
		}
	    }
		
	    $user_avatar = XOOPS_URL . '/uploads/' . $user->getVar('user_avatar');
	}

	print $val['comment_time'];
	
	print ',';
	if ($xoopsModuleConfig['show_avatar']) {
	    print $user_avatar;
	}
	print ',';
	if ($xoopsModuleConfig['show_user_id']) {
	    print xoops_utf8_encode($user_name) . ':';
	}

	print xoops_utf8_encode($val['comment']) . "\r\n";
    }
}

exit();
