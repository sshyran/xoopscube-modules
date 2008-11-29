<?php

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;


$module_handler =& xoops_gethandler( 'module' ) ;
$xoopsModule =& $module_handler->getByDirname( $mydirname ) ;
$config_handler =& xoops_gethandler( 'config' ) ;
$xoopsModuleConfig =& $config_handler->getConfigsByCat( 0 , $xoopsModule->getVar( 'mid' ) ) ;


// check permission of 'module_admin' of this module
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $xoopsModule->getVar( 'mid' ) , $xoopsUser->getGroups() ) ) die( 'only admin can access this area' ) ;


////$xoopsOption['pagetype'] = 'admin' ;
require XOOPS_ROOT_PATH.'/include/cp_functions.php' ;

// language files (admin.php)
// initialize language manager
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
//if( file_exists($langmanpath) ){
	if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
	require_once( $langmanpath ) ;
	$langman =& D3LanguageManager::getInstance() ;
/*} else {
	$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
	if( file_exists( "$mydirpath/language/$language/admin.php" ) ) {
		include_once "$mydirpath/language/$language/admin.php" ;	// user customized language file
	} else if( file_exists( "$mytrustdirpath/language/$language/admin.php" ) ) {
		include_once "$mytrustdirpath/language/$language/admin.php" ;	// default language file
	} else {
		include_once "$mytrustdirpath/language/english/admin.php" ;	// fallback english
	}
}*/

$act = empty( $_GET['act'] ) ? "index" : $_GET['act'];
$act = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $act ) ;
$actions = Array( "index","cat","gperm","stats","req", );	//white list

if( in_array( $act , $actions ) ) {
	if( file_exists( "$mytrustdirpath/admin/$act.php" ) ) {
		include "$mytrustdirpath/admin/$act.php" ;
	} else {
		die( 'wrong request' ) ;
	}
} else {
	die( 'wrong request' ) ;
}

?>