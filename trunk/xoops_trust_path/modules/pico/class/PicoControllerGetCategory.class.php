<?php

require_once dirname(__FILE__).'/PicoControllerAbstract.class.php' ;
require_once dirname(__FILE__).'/PicoModelCategory.class.php' ;

class PicoControllerGetCategory extends PicoControllerAbstract {

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

	// check existence
	if( $this->currentCategoryObj->isError() ) {
		redirect_header( XOOPS_URL."/modules/$this->mydirname/index.php" , 2 , _MD_PICO_ERR_READCATEGORY ) ;
		exit ;
	}

	$cat_data = $this->currentCategoryObj->getData() ;
	$this->assign['category'] = $this->currentCategoryObj->getData4html() ;

	// permission check
	if( ! $cat_data['can_read'] ) {
		redirect_header( XOOPS_URL."/modules/$this->mydirname/index.php" , 2 , _MD_PICO_ERR_READCATEGORY ) ;
		exit ;
	}

	// auto-register
	if( ! empty( $this->mod_config['wraps_auto_register'] ) ) {
		require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
		pico_auto_register_from_cat_vpath( $mydirname , $this->currentCategoryObj->getData() ) ;
	}

	// contents
	$this->assign['contents'] = array() ;
	$contentObjs = $this->currentCategoryObj->getContents() ;
	foreach( $contentObjs as $contentObj ) {
		$this->assign['contents'][] = $contentObj->getData4html() ;
	}

	// subcategories
	$categoryHandler =& new PicoCategoryHandler( $this->mydirname , $this->permissions ) ;
	$subcategoryObjs = $categoryHandler->getSubCategories( $request['cat_id'] ) ;
	foreach( $subcategoryObjs as $subcategoryObj ) {
		$this->assign['subcategories'][] = $subcategoryObj->getData4html() ;
	}

	$breadcrumbsObj =& AltsysBreadcrumbs::getInstance() ;
	$this->assign['xoops_breadcrumbs'] = $breadcrumbsObj->getXoopsbreadcrumbs() ;
	$this->assign['xoops_pagetitle'] = $this->assign['category']['title'] ;

	// views (no views other than 'listcontents')
	$this->template_name = $this->mydirname.'_main_listcontents.html' ;
	$this->is_need_header_footer = true ;
}


}

?>