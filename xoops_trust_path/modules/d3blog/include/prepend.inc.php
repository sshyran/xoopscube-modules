<?php
/**
 * @version $Id: prepend.inc.php 320 2008-03-03 14:17:35Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Copyrighted(c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

$mytrustdirpath = dirname( dirname( __FILE__ ));
$mytrustdirname = basename( $mytrustdirpath );
$mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);
$mydirpath4show = htmlspecialchars(XOOPS_ROOT_PATH.'/modules/'.$mydirname, ENT_QUOTES);
$mytrustdirname4show = htmlspecialchars($mytrustdirname, ENT_QUOTES);
$mytrustdirpath4show = htmlspecialchars($mytrustdirpath, ENT_QUOTES);

if(!class_exists($mydirname)) {
    require $mytrustdirpath.'/class/global.class.php';
}

require $mytrustdirpath.'/include/functions.php';
require $mytrustdirpath.'/include/config.inc.php';

// GET MODULE INFORMATION
$myModule = call_user_func(array($mydirname, 'getInstance'));

// CURRENT USER'S INFO
require $mytrustdirpath.'/lib/user.php';
if(!isset($GLOBALS['currentUser'])) {
    global $xoopsUser;
    $GLOBALS['currentUser'] = new myXoopsUserObject($xoopsUser);
    $GLOBALS['currentUser']->_groups_ = $GLOBALS['currentUser']->getGroups();
}

// USER'S PRIVILEGES ON THIS MODULE
if(!isset($GLOBALS['currentUser']->_userPerm[$myModule->module_id])) {
    $GLOBALS['currentUser']->_userPerm[$myModule->module_id] = new myXoopsUserPermission($GLOBALS['currentUser'], $myModule);
}

?>