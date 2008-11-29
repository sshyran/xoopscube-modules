<?php

$constpref = '_MI_' . strtoupper( $mydirname ) ;

$adminmenu = array(
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU2' ) ,
		'link' => 'admin/index.php' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU1' ) ,
		'link' => 'admin/index.php?page=photomanager' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU0' ) ,
		'link' => 'admin/index.php?page=admission' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU3' ) ,
		'link' => 'admin/index.php?page=checkconfigs' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU4' ) ,
		'link' => 'admin/index.php?page=batch' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU5' ) ,
		'link' => 'admin/index.php?page=redothumbs' ,
	) ,
	array(
		'title' => constant( $constpref.'_D3IMGTAG_ADMENU_GPERM' ) ,
		'link' => 'admin/index.php?page=groupperm_global' ,
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