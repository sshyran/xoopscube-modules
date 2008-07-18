<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;
require_once dirname(dirname(__FILE__)).'/class/gtickets.php' ;

$xoopsOption['template_main'] = $mydirname.'_main_category_form.html' ;
include XOOPS_ROOT_PATH."/header.php";

$pid = isset( $_POST['pid'] ) ? intval( $_POST['pid'] ) : intval( @$_GET['pid'] ) ;

// check pid as cat_id temporary
$cat_id = $pid ;

// get&check this category ($category4assign, $category_row), override options
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// special check for makecategory
if( ! $category4assign['can_makesubcategory'] ) die( _MD_PICO_ERR_CREATECATEGORY ) ;

// unset temporary variables;
unset( $cat_id , $category4assign ) ;


// TRANSACTION PART
// permissions will be set same as the parent category. (also moderator)
require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
if( isset( $_POST['categoryman_post'] ) ) {
	if ( ! $xoopsGTicket->check( true , 'pico' ) ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	// create a record for category and category_permissions
	$new_cat_id = pico_makecategory( $mydirname ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_category_link4html( $xoopsModuleConfig , $new_cat_id , $mydirname ) , 2 , _MD_PICO_MSG_CATEGORYMADE ) ;
	exit ;
}

// FORM PART

include dirname(dirname(__FILE__)).'/include/configs_can_override.inc.php' ;
$options4html = '' ;
foreach( $xoopsModuleConfig as $key => $val ) {
	if( isset( $pico_configs_can_be_override[ $key ] ) ) {
		$options4html .= htmlspecialchars( $key , ENT_QUOTES ) . ':' . htmlspecialchars( $val , ENT_QUOTES ) . "\n" ;
	}
}

$category4assign = array(
	'id' => -1 ,
	'title' => '' ,
	'weight' => 0 ,
	'desc' => '' ,
	'options' => '' , //$options4html ,
	'option_desc' => pico_main_get_categoryoptions4edit( $pico_configs_can_be_override ) ,
	'wraps_directories' => array( '' => '---' ) + pico_main_get_wraps_directories_recursively( $mydirname , '/' ) ,
) ;


$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
	'mod_config' => $xoopsModuleConfig ,
	'category' => $category4assign ,
	'page' => 'makecategory' ,
	'formtitle' => _MD_PICO_LINK_MAKECATEGORY ,
	'children_count' => 0 ,
	'cat_jumpbox_options' => pico_main_make_cat_jumpbox_options( $mydirname , $whr_read4cat , $pid ) ,
	'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'pico') ,
	'xoops_module_header' => "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".str_replace('{mod_url}',XOOPS_URL.'/modules/'.$mydirname,$xoopsModuleConfig['css_uri'])."\" />" . $xoopsTpl->get_template_vars( "xoops_module_header" ) ,
	'xoops_pagetitle' => _MD_PICO_CATEGORYMANAGER ,
	'xoops_breadcrumbs' => array_merge( $xoops_breadcrumbs , array( array( 'name' => _MD_PICO_LINK_MAKECATEGORY ) ) ) ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>