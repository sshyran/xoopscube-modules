<?php
// ------------------------------------------------------------------------- //
//                       myblocksadmin.php (altsys)                          //
//                - XOOPS block admin for each modules -                     //
//                       GIJOE <http://www.peak.ne.jp/>                      //
// ------------------------------------------------------------------------- //

require_once dirname(__FILE__).'/class/AltsysBreadcrumbs.class.php' ;
include_once dirname(__FILE__).'/include/gtickets.php' ;
include_once dirname(__FILE__).'/include/altsys_functions.php' ;
include_once dirname(__FILE__).'/include/MyBlocksAdmin.class.php' ;
include_once dirname(__FILE__).'/include/mygrouppermform.php' ;
include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;

// only groups have 'module_admin' of 'altsys' can do that.
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( 'altsys' ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $module->getVar( 'mid' ) , $xoopsUser->getGroups() ) ) die( 'only admin of altsys can access this area' ) ;

// language file
altsys_include_language_file( 'myblocksadmin' ) ;

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( XOOPS_URL.'/user.php' , 1 , _NOPERM ) ;

// set target_module if specified by $_GET['dirname']
$module_handler =& xoops_gethandler('module');
if( ! empty( $_GET['dirname'] ) ) {
	$dirname = preg_replace( '/[^0-9a-zA-Z_-]/' , '' , $_GET['dirname'] ) ;
	$target_module =& $module_handler->getByDirname( $dirname ) ;
}

if( $mydirname == 'altsys' && is_object( @$target_module ) ) {
	// specified by dirname (as ALTSYS module)
	$target_mid = $target_module->getVar( 'mid' ) ;
	$target_mname = $target_module->getVar( 'name' ) . "&nbsp;" . sprintf( "(%2.2f)" , $target_module->getVar('version') / 100.0 ) ;
	$target_dirname = $target_module->getVar( 'dirname' ) ;
	$modinfo = $target_module->getInfo() ;
	// breadcrumbs
	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/altsys/admin/index.php?mode=admin&amp;lib=altsys&amp;page=myblocksadmin' , '_MI_ALTSYS_MENU_MYBLOCKSADMIN' ) ;
	$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/altsys/admin/index.php?mode=admin&amp;lib=altsys&amp;page=myblocksadmin&amp;dirname='.$target_dirname , $target_mname ) ;
} else if( $mydirname == 'altsys' ) {
	// default as ALTSYS module
	$target_mid = 0 ;
	$target_mname = '' ;
	$target_dirname = '__CustomBlocks__' ;
	// breadcrumbs
	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/altsys/admin/index.php?mode=admin&amp;lib=altsys&amp;page=myblocksadmin' , '_MI_ALTSYS_MENU_MYBLOCKSADMIN' ) ;
	$breadcrumbsObj->appendPath( XOOPS_URL.'/modules/altsys/admin/index.php?mode=admin&amp;lib=altsys&amp;page=myblocksadmin&amp;dirname='.$target_dirname , '_MI_ALTSYS_MENU_CUSTOMBLOCKS' ) ;
} else {
	// myblocksadmin in each modules
	$target_mid = $xoopsModule->getVar( 'mid' ) ;
	$target_mname = $xoopsModule->getVar( 'name' ) . "&nbsp;" . sprintf( "(%2.2f)" , $xoopsModule->getVar('version') / 100.0 ) ;
	$target_dirname = '' ;
	$mod_url = XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname') ;
	$modinfo = $xoopsModule->getInfo() ;
	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	$breadcrumbsObj->appendPath( $mod_url.'/'.@$modinfo['adminindex'] , $target_mname ) ;
	$breadcrumbsObj->appendPath( $mod_url.'/admin/index.php?mode=admin&amp;lib=altsys&amp;page=myblocksadmin' , _MD_A_MYBLOCKSADMIN_BLOCKADMIN ) ;
}

// check access right (needs system_admin of BLOCK)
//$sysperm_handler =& xoops_gethandler('groupperm');
//if( ! $sysperm_handler->checkRight( 'system_admin' , XOOPS_SYSTEM_BLOCK , $xoopsUser->getGroups() ) ) {
//	redirect_header( XOOPS_URL.'/user.php' , 1 , _NOPERM ) ;
//	exit ;
//}




// fork XOOPS 2.0.x and XOOPS 2.2.x
if( altsys_get_core_type() == ALTSYS_CORE_TYPE_X22 ) {
	include_once dirname(__FILE__).'/include/MyBlocksAdminForXoops22.class.php' ;
	$myba =& MyBlocksAdminForXoops22::getInstance() ;
} else {
	$myba =& MyBlocksAdmin::getInstance() ;
}


//
// transaction stage
//

if( ! empty( $_POST['preview'] ) ) {
	// preview
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$_GET['op'] = 'preview' ;
} else if( @$_POST['op'] == 'order' ) {
	// order ok
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$msg = $myba->do_order() ;
	redirect_header( '?mode=admin&lib=altsys&page=myblocksadmin&dirname='.$target_dirname , 1 , $msg ) ;
	exit ;
} else if( @$_POST['op'] == 'delete_ok' ) {
	// delete ok
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$msg = $myba->do_delete( intval( @$_GET['bid'] ) ) ;
	redirect_header( '?mode=admin&lib=altsys&page=myblocksadmin&dirname='.$target_dirname , 1 , $msg ) ;
	exit ;
} else if( @$_POST['op'] == 'clone_ok' ) {
	// clone ok
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$msg = $myba->do_clone( intval( @$_GET['bid'] ) ) ;
	redirect_header( '?mode=admin&lib=altsys&page=myblocksadmin&dirname='.$target_dirname , 1 , $msg ) ;
	exit ;
} else if( @$_POST['op'] == 'edit_ok' || @$_POST['op'] == 'new_ok' ) {
	// edit ok
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	$msg = $myba->do_edit( intval( @$_GET['bid'] ) ) ;
	redirect_header( '?mode=admin&lib=altsys&page=myblocksadmin&dirname='.$target_dirname , 1 , $msg ) ;
	exit ;
} else if( ! empty( $_POST['submit'] ) ) {
	// update module_admin,module_read,block_read
	if( ! $xoopsGTicket->check( true , 'myblocksadmin' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	include dirname(__FILE__).'/include/mygroupperm.php' ;
	redirect_header( '?mode=admin&lib=altsys&page=myblocksadmin&dirname='.$target_dirname , 1 , _MD_A_MYBLOCKSADMIN_PERMUPDATED ) ;
	exit ;
}



//
// form stage
//

// header
xoops_cp_header() ;

// mymenu
altsys_include_mymenu() ;

switch( @$_GET['op'] ) {
	case 'preview' :
		$myba->form_preview( intval( @$_GET['bid'] ) ) ;
		break ;
	case 'clone' :
		$myba->form_edit( intval( @$_GET['bid'] ) , 'clone' ) ;
		break ;
	case 'edit' :
		$myba->form_edit( intval( @$_GET['bid'] ) , 'edit' ) ;
		break ;
	case 'delete' :
		$myba->form_delete( intval( @$_GET['bid'] ) ) ;
		// breadcrumbs
		$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
		$breadcrumbsObj->appendPath( '' , _DELETE ) ;
		break ;
	case 'list' :
	default :
		// page title
		echo "<h3 style='text-align:left;'>$target_mname</h3>\n" ;
		// the first form (blocks)
		$myba->list_blocks( $target_mid , $target_dirname ) ;
		// the second form (groups)
		$myba->list_groups( $target_mid , $target_dirname , $target_mname ) ;
		break ;
}

// footer
xoops_cp_footer() ;


?>