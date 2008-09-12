<?php

if (defined('__CINEMARU_GROUPPERM_FUNC_PHP__')) {
    return;
}
define('__CINEMARU_GROUPPERM_FUNC_PHP__', 1);

function cinemaru_checkright($perm)
{
    global $xoopsUser;

    if (isset($xoopsUser) && is_object($xoopsUser)) {
		$my_group_ids = $xoopsUser->getGroups();
    } else {
		$my_group_ids = array(XOOPS_GROUP_ANONYMOUS); 
    }

    $basename = basename( dirname( dirname( __FILE__ ) ) ) ;
    $module_handler =& xoops_gethandler('module');
    $xoopsModule =& $module_handler->getByDirname($basename);
    $mid = $xoopsModule->mid();
    
    $gperm_handler =& xoops_gethandler( 'groupperm' ) ;
    
    return $gperm_handler->checkRight( 'cinemaru_global' , $perm , $my_group_ids , $mid ) ;
}


