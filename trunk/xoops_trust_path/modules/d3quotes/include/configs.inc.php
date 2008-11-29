<?php
	global $xoopsConfig , $xoopsDB , $xoopsUser;

	//get trust dir name from blocks
	$mytrustdirname = isset($mytrustdirname) ?  $mytrustdirname : basename( dirname( dirname( __FILE__ ) ) ) ;

	// module information
	$mod_url = XOOPS_URL . "/modules/$mydirname" ;
	$mod_path = XOOPS_ROOT_PATH . "/modules/$mydirname" ;
	$mod_trust_path = XOOPS_TRUST_PATH . "/modules/$mytrustdirname" ;
	$mod_copyright = "<a href='http://oceanblue.x.cmssquare.com/'><strong>RandomQuotesD3</strong></a> &nbsp; <span style='font-size:0.8em;'>(based on <a href='http://gyakubiki.kir.jp/'>RandomQuotes</a>)</span>" ;

	// global langauge file
	//$language = $xoopsConfig['language'] ;
	//if ( file_exists( "$mod_trust_path/language/$language/d3quotes_constants.php" ) ) {
	//	include_once "$mod_trust_path/language/$language/d3quotes_constants.php" ;
	//} else {
	//	include_once "$mod_trust_path/language/english/d3quotes_constants.php" ;
	//	$language = "english" ;
	//}

	// read from xoops_config
	// get my mid
	$rs = $xoopsDB->query( "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname='$mydirname'" ) ;
	list( $d3quotes_mid ) = $xoopsDB->fetchRow( $rs ) ;

	// read configs from xoops_config directly
	//$rs = $xoopsDB->query( "SELECT conf_name,conf_value FROM ".$xoopsDB->prefix('config')." WHERE conf_modid=$d3quotes_mid" ) ;
	//while( list( $key , $val ) = $xoopsDB->fetchRow( $rs ) ) {
	//	$d3quotes_configs[ $key ] = $val ;
	//}

	//foreach( $d3quotes_configs as $key => $val ) {
	//	if( strncmp( $key , "d3quotes_" , 9 ) == 0 ) $$key = $val ;
	//}

	// User Informations
	if( empty( $xoopsUser ) ) {
		$my_uid = 0 ;
		$isadmin = false ;
	} else {
		$my_uid = $xoopsUser->uid() ;
		$isadmin = $xoopsUser->isAdmin( $d3quotes_mid ) ;
	}

	// Value Check
	//$d3quotes_addposts = intval( $d3quotes_addposts ) ;
	//if( $d3quotes_addposts < 0 ) $d3quotes_addposts = 0 ;

	// Path to Cache ;
	//if( ord( $d3quotes_cachepath ) != 0x2f ) $d3quotes_cachepath = "/$d3quotes_cachepath" ;
	//$cache_dir = XOOPS_ROOT_PATH . $d3quotes_cachepath ;
	//$cache_url = XOOPS_URL . $d3quotes_cachepath ;

	// DB table name
	$table_d3quotes = $xoopsDB->prefix( "{$mydirname}_citas" ) ;

?>