<?php
$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;


// language file (blocks_common.php&blocks_each.php)
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
//if( file_exists( $langmanpath ) ){
	if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
	require_once( $langmanpath ) ;
	$langman =& D3LanguageManager::getInstance() ;
	$langman->read( 'blocks_common.php' , $mydirname , $mytrustdirname ) ;
	$langman->read( 'blocks_each.php' , $mydirname , $mytrustdirname ) ;
/*} else {
	// language files
	$language = empty( $GLOBALS['xoopsConfig']['language'] ) ? 'english' : $GLOBALS['xoopsConfig']['language'] ;
	if( file_exists( "$mydirpath/language/$language/blocks.php" ) ) {
	    // user customized language file (already read by class/xoopsblock.php etc)
	    include_once "$mydirpath/language/$language/blocks.php" ;
	} else if( file_exists( "$mytrustdirpath/language/$language/blocks_common.php" ) ) {
	    // default language file
	    include_once "$mytrustdirpath/language/$language/blocks_common.php" ;
	    include "$mytrustdirpath/language/$language/blocks_each.php" ;
	} else {
	    // fallback english
	    include_once "$mytrustdirpath/language/english/blocks_common.php" ;
	    include "$mytrustdirpath/language/english/blocks_each.php" ;
	}
}*/


require_once "$mytrustdirpath/blocks/block_functions.php" ;


?>