<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu = array(
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU1' ) ,
		'link' => 'admin/index.php' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU2' ) ,
		'link' => 'admin/index.php?page=catmgr' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU3' ) ,
		'link' => 'admin/index.php?page=usermgr' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU4' ) ,
		'link' => 'admin/index.php?page=groupmgr' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU5' ) ,
		'link' => 'admin/index.php?page=ecardmgr' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3XCGAL_ADMENU6' ) ,
		'link' => 'admin/index.php?page=searchnew' ,
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

?>