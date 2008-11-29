<?php

require_once dirname(__FILE__).'/PicoControllerAbstract.class.php' ;
require_once dirname(__FILE__).'/PicoModelCategory.class.php' ;

class PicoControllerGetMenu extends PicoControllerAbstract {

//var $mydirname = '' ;
//var $mytrustdirname = '' ;
//var $assign = array() ;
//var $mod_config = array() ;
//var $uid = 0 ;
//var $currentCategoryObj = null ;
//var $permissions = array() ;
//var $is_need_header_footer = true ;
//var $template_name = '' ;
//var $html_header = '' ;
//var $contentObjs = array() ;

function execute( $request )
{
	parent::execute( $request ) ;

	$categoryHandler =& new PicoCategoryHandler( $this->mydirname , $this->permissions ) ;
	$categories = $categoryHandler->getAllCategories() ;

	// auto-register
	if( ! empty( $this->mod_config['wraps_auto_register'] ) ) {
		require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
		foreach( $categories as $categoryObj ) {
			pico_auto_register_from_cat_vpath( $mydirname , $categoryObj->getData() ) ;
		}
	}

	$categories4assign = array() ;
	foreach( $categories as $cat_id => $categoryObj ) {
		// assign categories
		$categories4assign[ $cat_id ] = $categoryObj->getData4html() ;

		// contents loop
		$contentObjs = $categoryObj->getContents( true ) ;
		$private_contents_counter = 0 ;
		foreach( $contentObjs as $contentObj ) {
			$content_data = $contentObj->getData() ;
			if( ! $content_data['public'] ) $private_contents_counter ++ ;
			else if( $content_data['show_in_menu'] && $content_data['can_read'] ) $categories4assign[ $cat_id ]['contents'][] = $contentObj->getData4html() ;
		}
		$categories4assign[ $cat_id ]['private_contents_counter'] = $private_contents_counter ;
	}
	$this->assign['categories'] = $categories4assign ;

	// breadcrumbs and pagetitle
	$lastnode4assign = @$_GET['page'] == 'menu' ? _MD_PICO_MENU : $GLOBALS['xoopsModule']->getVar('name') ;
	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	$breadcrumbsObj->appendPath( '' , $lastnode4assign ) ;
	$this->assign['xoops_breadcrumbs'] = $breadcrumbsObj->getXoopsbreadcrumbs() ;
	$this->assign['xoops_pagetitle'] = $lastnode4assign ;

	// views (no views other than 'menu')
	$this->template_name = $this->mydirname.'_main_menu.html' ;
	$this->is_need_header_footer = true ;
}



}

?>