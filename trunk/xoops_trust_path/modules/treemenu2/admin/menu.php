<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ; 


$adminmenu4treemenu = array(
	array(
		'title' => constant( $constpref."_ADMINMENU1"),
		'link' => "admin/index.php?act=makemenu",
	) ,
	array(
		'title' => constant( $constpref."_ADMINMENU2"),
		'link' => "admin/index.php?act=access",
	) ,
) ;


$adminmenu4altsys = array(
	array(
		'title' => constant( $constpref.'_ADMENU_MYLANGADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYTPLSADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYBLOCKSADMIN' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ,
	) ,
	array(
		'title' => constant( $constpref.'_ADMENU_MYPREFERENCES' ) ,
		'link' => 'admin/index.php?mode=admin&lib=altsys&page=mypreferences' ,
	) ,
) ;

$adminmenu = array_merge( $adminmenu4treemenu , $adminmenu4altsys ) ;

?>