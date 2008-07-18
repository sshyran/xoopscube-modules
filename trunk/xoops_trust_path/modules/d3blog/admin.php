<?php
/**
 * @version $Id: admin.php 293 2008-02-25 13:09:25Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirpath = dirname( __FILE__ ) ;

require $mytrustdirpath.'/include/prepend.inc.php';

$xoopsModule =& $myModule->module;
$xoopsModuleConfig =& $myModule->module_config;

// check permission of 'module_admin' of this module
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight('module_admin', $myModule->module_id, $xoopsUser->getGroups())) die( 'only admin can access this area' ) ;

// environment
require_once XOOPS_ROOT_PATH.'/class/template.php';

$xoopsOption['pagetype'] = 'admin';
require XOOPS_ROOT_PATH.'/include/cp_functions.php';

// initialize language manager
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php';
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' );
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;

if( ! empty( $_GET['lib'] ) ) {
    // common libs (eg. altsys)
    $lib = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['lib'] ) ;
    $page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] ) ;

    // check the page can be accessed (make controllers.php just under the lib)
    $controllers = array() ;
    if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/controllers.php' ) ) {
        require XOOPS_TRUST_PATH.'/libs/'.$lib.'/controllers.php' ;
        if( ! in_array( $page , $controllers ) ) $page = $controllers[0] ;
    }
    
    if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ) ) {
        include XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ;
    } else if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ) ) {
        include XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ;
    } else {
        die( 'wrong request' ) ;
    }
} else {
    // load language files (admin.php)
    $langman->read( 'admin.php' , $mydirname , $mytrustdirname ) ;
    
    // fork each pages of this module
    $page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] ) ;

    if( file_exists( "$mytrustdirpath/admin/$page.php" ) ) {
        include "$mytrustdirpath/admin/$page.php" ;
    } else if( file_exists( "$mytrustdirpath/admin/index.php" ) ) {
        include "$mytrustdirpath/admin/index.php" ;
    } else {
        die( 'wrong request' ) ;
    }
}

?>