<?php

//if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

//if( empty( $mydirname ) ) $mydirname = basename(dirname(dirname(__FILE__))) ;

if( ! defined( 'XOOPS_ORETEKI' ) ) {
	

	if( ! isset( $module ) || ! is_object( $module ) ) $module = $xoopsModule ;
	else if( ! is_object( $xoopsModule ) ) die( '$xoopsModule is not set' )  ;

	// language files (modinfo.php)
	$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
	if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
	require_once( $langmanpath ) ;
	$langman =& D3LanguageManager::getInstance() ;
	$langman->read( 'modinfo.php' , $mydirname , $mytrustdirname ) ;

	include  dirname(__FILE__) .'/menu.php' ;

	if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mylangadmin.php' ) ) {	//言語定数管理
		$title = defined( '_MD_A_MYMENU_MYLANGADMIN' ) ? _MD_A_MYMENU_MYLANGADMIN : 'langadmin' ;
		array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin' ) ) ;
	}

	if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mytplsadmin.php' ) ) {	//テンプレート管理
		$title = defined( '_MD_A_MYMENU_MYTPLSADMIN' ) ? _MD_A_MYMENU_MYTPLSADMIN : 'tplsadmin' ;
		array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ) ) ;
	}

	if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/myblocksadmin.php' ) ) {	//ブロック・アクセス権限
		$title = defined( '_MD_A_MYMENU_MYBLOCKSADMIN' ) ? _MD_A_MYMENU_MYBLOCKSADMIN : 'blocksadmin' ;
		array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ) ) ;
	}

	// 一般設定
	$config_handler =& xoops_gethandler('config');
	if( count( $config_handler->getConfigs( new Criteria( 'conf_modid' , $module->mid() ) ) ) > 0 ) {
		if( file_exists( XOOPS_TRUST_PATH.'/libs/altsys/mypreferences.php' ) ) {
			// mypreferences
			$title = defined( '_MD_A_MYMENU_MYPREFERENCES' ) ? _MD_A_MYMENU_MYPREFERENCES : _PREFERENCES ;
			array_push( $adminmenu , array( 'title' => $title , 'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences' ) ) ;
		} else {
			//NE+ move
			if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
				if( $module->getvar('hasconfig') ) array_push( $adminmenu , array( 'title' => _PREFERENCES , 'link' => XOOPS_URL.'/modules/legacy/admin/index.php?action=PreferenceEdit&confmod_id=' . $module->getvar('mid') ) ) ;
			} else {
				array_push( $adminmenu , array( 'title' => _PREFERENCES , 'link' => XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$module->mid() ) ) ;
			}
		}
	}


	$mymenu_uri = empty( $mymenu_fake_uri ) ? $_SERVER['REQUEST_URI'] : $mymenu_fake_uri ;
	$mymenu_link = substr( strstr( $mymenu_uri , '/admin/' ) , 1 ) ;

	// hilight
	foreach( array_keys( $adminmenu ) as $i ) {
		if( $mymenu_link == $adminmenu[$i]['link'] ) {
			$adminmenu[$i]['color'] = '#FFCCCC' ;
			$adminmenu_hilighted = true ;
		} else {
			$adminmenu[$i]['color'] = '#DDDDDD' ;
		}
	}
	if( empty( $adminmenu_hilighted ) ) {
		foreach( array_keys( $adminmenu ) as $i ) {
			if( stristr( $mymenu_uri , $adminmenu[$i]['link'] ) ) {
				$adminmenu[$i]['color'] = '#FFCCCC' ;
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

  if( !defined('OMITMYMENU') ){
	// display
	echo "<div style='text-align:left;width:98%;'>" ;
	foreach( $adminmenu as $menuitem ) {
		echo "<div style='float:left;height:1.5em;'><nobr><a href='".htmlspecialchars($menuitem['link'],ENT_QUOTES)."' style='background-color:{$menuitem['color']};font:normal normal bold 9pt/12pt;'>".htmlspecialchars($menuitem['title'],ENT_QUOTES)."</a>&nbsp;|&nbsp;</nobr></div>\n" ;
	}
	echo "</div>\n<hr style='clear:left;display:block;' />\n" ;
  }

}// Skip for ORETEKI XOOPS

?>