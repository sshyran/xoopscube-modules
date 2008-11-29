<?php

include_once $mytrustdirpath .'/include/gtickets.php' ;//Gticket
include_once $mytrustdirpath .'/include/functions.php' ;

//DB table
$table_menu = $xoopsDB->prefix( $mydirname."_menu" ) ;
$table_addurl = $xoopsDB->prefix( $mydirname."_addurl" ) ;
$table_access = $xoopsDB->prefix( $mydirname."_access" ) ;

$myts = & MyTextSanitizer :: getInstance();

$moduleperm_handler =& xoops_gethandler('groupperm');
$module_handler =& xoops_gethandler('module');
$xoopsModule =& $module_handler->getByDirname($mydirname);
if( !is_object($xoopsModule) ) {
	redirect_header( XOOPS_URL , 1, _MODULENOEXIST );
}

$user_isadmin = false;
if ( is_object($xoopsUser) ) $user_isadmin = $xoopsUser->isAdmin( $xoopsModule->getVar('mid') ) ;

$uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0 ;

//lang PREFIX
$constpref = '_MD_' . strtoupper( $mydirname ) ;


?>