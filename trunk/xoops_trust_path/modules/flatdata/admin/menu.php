<?php
$constpref = '_MI_' . strtoupper( $mydirname ) ; 

$i=1;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU1') ;
$adminmenu[$i]['link']  = "admin/index.php?page=fields" ;
$i++;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU2') ;
$adminmenu[$i]['link']  = "admin/index.php?page=permission" ;

//ALTSYS
$i++;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU_MYLANGADMIN' ) ;
$adminmenu[$i]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin' ;
$i++;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU_MYTPLSADMIN' ) ;
$adminmenu[$i]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin' ;
$i++;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU_MYBLOCKSADMIN' ) ;
$adminmenu[$i]['link']  = 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin' ;
$i++;
$adminmenu[$i]['title'] = constant( $constpref.'_ADMENU_MYPREFERENCES' ) ;
$adminmenu[$i]['link']  = 'admin/index.php' ;


?>