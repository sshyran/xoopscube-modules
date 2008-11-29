<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

if( ! defined( 'XOOPS_ORETEKI' ) ) 
{

	if( ! isset( $module ) || ! is_object( $module ) ) $module = $xoopsModule ;
	else if( ! is_object( $xoopsModule ) ) die( '$xoopsModule is not set' )  ;

	// language files (modinfo.php)
	$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
	if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
	require_once( $langmanpath ) ;
	$langman =& D3LanguageManager::getInstance() ;
	$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname ) ;

	include  dirname(__FILE__) .'/menu.php' ;

	$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
	$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;

	// hilight
	foreach( array_keys( $adminmenu ) as $i ) {
		$adminmenu[$i]['color'] = '#DDDDDD' ;//
		$adminmenu[$i]['selected'] = false ;
		if( $mymenu_link == $adminmenu[$i]['link'] ) {
			$adminmenu[$i]['color'] = '#FFCCCC' ;//
			$adminmenu[$i]['selected'] = true ;
			$adminmenu_hilighted = true ;
		}
	}
	if( empty( $adminmenu_hilighted ) ) {
		foreach( array_keys( $adminmenu ) as $i ) {
			if( stristr( $mymenu_uri , $adminmenu[$i]['link'] ) ) {
				$adminmenu[$i]['color'] = '#FFCCCC' ;//
				$adminmenu[$i]['selected'] = true ;
				break ;
			}
		}
	}

	// link conversion from relative to absolute
	foreach( array_keys( $adminmenu ) as $i ) {
		if( stristr( $adminmenu[$i]['link'] , XOOPS_URL ) === false ) {
			$adminmenu[$i]['link'] = XOOPS_URL."/modules/$mydirname/" . $adminmenu[$i]['link'] ;
		}
	}


	// display
	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$tpl =& new XoopsTpl() ;
	$tpl->assign( array(
		'adminmenu' => $adminmenu ,
	) ) ;
	$tpl->display( 'db:altsys_inc_mymenu.html' ) ;
	//echo "<a href='$mydirurl/'>$mydirurl/</a>" ;

}// Skip for ORETEKI XOOPS
?>