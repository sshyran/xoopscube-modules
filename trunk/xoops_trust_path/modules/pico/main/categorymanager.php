<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;

$xoopsOption['template_main'] = $mydirname.'_main_category_form.html' ;
include XOOPS_ROOT_PATH."/header.php";

$cat_id = isset( $_POST['cat_id'] ) ? intval( $_POST['cat_id'] ) : intval( @$_GET['cat_id'] ) ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// count children
include_once XOOPS_ROOT_PATH."/class/xoopstree.php" ;
$mytree = new XoopsTree( $xoopsDB->prefix($mydirname."_categories") , "cat_id" , "pid" ) ;
$children = $mytree->getAllChildId( $cat_id ) ;

// special check for categorymanager
if( ! $isadminormod ) die( _MD_PICO_ERR_CATEGORYMANAGEMENT ) ;

// redirect to preferences (install altsys)
/* if( ! $cat_id ) {
	$use_altsys = file_exists(XOOPS_TRUST_PATH.'/libs/altsys/mypreferences.php') ? '?mode=admin&lib=altsys&page=mypreferences' : '' ;
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php$use_altsys" , 2 , _MD_PICO_MSG_GOTOPREFERENCE4EDITTOP ) ;
	exit ;
} */

// TRANSACTION PART
require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
if( isset( $_POST['categoryman_post'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	pico_updatecategory( $mydirname , $cat_id ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_category_link4html( $xoopsModuleConfig , $cat_id , $mydirname ) , 2 , _MD_PICO_MSG_CATEGORYUPDATED ) ;
	exit ;
}
if( isset( $_POST['categoryman_delete'] ) && count( $children ) == 0 && $cat_id > 0 ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	pico_delete_category( $mydirname , $cat_id ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_category_link4html( $xoopsModuleConfig , $cat_row['pid'] , $mydirname ) , 2 , _MD_PICO_MSG_CATEGORYDELETED ) ;
	exit ;
}

// FORM PART

include dirname(dirname(__FILE__)).'/include/configs_can_override.inc.php' ;
$options4html = '' ;
$category_configs = @unserialize( $cat_row['cat_options'] ) ;
if( is_array( $category_configs ) ) foreach( $category_configs as $key => $val ) {
	if( isset( $pico_configs_can_be_override[ $key ] ) ) {
		$options4html .= htmlspecialchars( $key , ENT_QUOTES ) . ':' . htmlspecialchars( $val , ENT_QUOTES ) . "\n" ;
	}
}

$category4assign = array(
	'id' => $cat_id ,
	'title' => htmlspecialchars( $cat_row['cat_title'] , ENT_QUOTES ) ,
	'weight' => intval( $cat_row['cat_weight'] ) ,
	'vpath' => htmlspecialchars( $cat_row['cat_vpath'] , ENT_QUOTES ) ,
	'desc' => htmlspecialchars( $cat_row['cat_desc'] , ENT_QUOTES ) ,
	'options' => $options4html ,
	'option_desc' => pico_main_get_categoryoptions4edit( $pico_configs_can_be_override ) ,
	'wraps_directories' => array( '' => '---' ) + pico_main_get_wraps_directories_recursively( $mydirname , '/' ) ,
) ;


$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
	'mod_config' => $xoopsModuleConfig ,
	'category' => $category4assign ,
	'page' => 'categorymanager' ,
	'formtitle' => _MD_PICO_CATEGORYMANAGER ,
	'children_count' => count( $children ) ,
	'cat_jumpbox_options' => pico_main_make_cat_jumpbox_options( $mydirname , $whr_read4cat , $cat_row['pid'] ) ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'pico') ,
	'xoops_module_header' => "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".str_replace('{mod_url}',XOOPS_URL.'/modules/'.$mydirname,$xoopsModuleConfig['css_uri'])."\" />" . $xoopsTpl->get_template_vars( "xoops_module_header" ) ,
	'xoops_pagetitle' => _MD_PICO_CATEGORYMANAGER ,
	'xoops_breadcrumbs' => array_merge( $xoops_breadcrumbs , array( array( 'name' => _MD_PICO_CATEGORYMANAGER ) ) ) ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>