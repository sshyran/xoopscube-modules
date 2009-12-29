<?php
/**
 * @version $Id: admin_menu.php 185 2007-10-09 02:22:41Z hodaka $
 */

$constpref = '_MI_' . strtoupper( $mydirname ) ; 
 
$adminmenu[1]['title'] = constant( $constpref.'_ADMENU_CATEGORY_MANAGER');
$adminmenu[1]['link'] = 'admin/index.php?page=category_manager';
$adminmenu[2]['title'] = constant( $constpref.'_ADMENU_PERMISSION_MANAGER');
$adminmenu[2]['link'] = 'admin/index.php?page=permission_manager' ;
$adminmenu[3]['title'] = constant( $constpref.'_ADMENU_APPROVAL_MANAGER');
$adminmenu[3]['link'] = 'admin/index.php?page=approval_manager';
$adminmenu[4]['title'] = constant( $constpref.'_ADMENU_IMPORT_MANAGER');
$adminmenu[4]['link'] = 'admin/index.php?page=import_manager';
$adminmenu[5]['title'] = constant( $constpref.'_ADMENU_CSS_MANAGER');
$adminmenu[5]['link'] = 'admin/index.php?page=css_manager';
$adminmenu4altsys[6]['title'] = constant( $constpref.'_ADMENU_MYLANGADMIN');
$adminmenu4altsys[6]['link'] = 'admin/index.php?mode=admin&lib=altsys&page=mylangadmin';
$adminmenu4altsys[7]['title'] = constant( $constpref.'_ADMENU_MYTPLSADMIN' );
$adminmenu4altsys[7]['link'] = 'admin/index.php?mode=admin&lib=altsys&page=mytplsadmin';
$adminmenu4altsys[8]['title'] = constant( $constpref.'_ADMENU_MYBLOCKSADMIN');
$adminmenu4altsys[8]['link'] = 'admin/index.php?mode=admin&lib=altsys&page=myblocksadmin';
$adminmenu4altsys[9]['title'] = constant( $constpref.'_ADMENU_MYPREFERENCES');
$adminmenu4altsys[9]['link'] = 'admin/index.php?mode=admin&lib=altsys&page=mypreferences';

?>