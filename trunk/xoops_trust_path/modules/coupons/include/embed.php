<?php
require_once dirname(dirname( __FILE__ ))."/include/functions.php";

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) return ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$cp_dirname = htmlspecialchars(coupons_urlCheckReplace($cp_dir),ENT_QUOTES) ;
$cp_trust_dirname = basename(dirname(dirname(__FILE__))) ;
$langman->read( 'main.php' , $cp_dirname , $cp_trust_dirname ) ;
$langman->read( 'admin.php' , $cp_dirname , $cp_trust_dirname ) ;



//-----------------------------------------------------------------------------------------
function coupons_embed_display( $cp_dir , $embed_dir , $item_field , $item_id )
{
	global $xoopsDB , $xoopsUser , $xoopsConfig ;

	$mytrustdirname = basename( dirname(dirname( __FILE__ )) ) ;
	$mytrustdirpath = dirname(dirname( __FILE__ )) ;

	$mydirname = htmlspecialchars(coupons_urlCheckReplace($cp_dir),ENT_QUOTES) ;
	$mydirpath = XOOPS_ROOT_PATH .'/modules/'. $mydirname ;
	$mydirurl  = XOOPS_URL .'/modules/'. $mydirname ;


	// check the coupons exists and is active
	$module_hanlder =& xoops_gethandler( 'module' ) ;
	$module =& $module_hanlder->getByDirname( $mydirname ) ;
	if( ! is_object( $module ) || ! $module->getVar('isactive') ) {
		return ;
	}

	// check permission of "module_read"
	$mid = $module->getVar('mid') ;
	$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
	$groups = is_object( $xoopsUser ) ? $xoopsUser->getGroups() : array( XOOPS_GROUP_ANONYMOUS ) ;
	if( ! $moduleperm_handler->checkRight( 'module_read' , $mid , $groups ) ) {
		return ;
	}

	$xoopsModule = $module ;
	$config = & xoops_gethandler('config');
	$xoopsModuleConfig = & $config->getConfigList($mid);
	$page = false ;
	require "$mytrustdirpath/main/header.php";


	//----------------------------------------------------------------------
	$embedwhere = addslashes("[$embed_dir][$item_field][$item_id]%");
	$coupons->setWhere(" l.status>0 AND l.starttime<".time()." AND l.endtime>".time()." AND l.embed LIKE '$embedwhere' AND ") ;
	$coupons->setOrder(' ORDER BY l.endtime ASC ') ;
	$coupon_data = $coupons->getCoupons(0,0,0,0) ;

	if( count($coupon_data)<1 ) return ;
	//----------------------------------------------------------------------
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	$xoopsTpl->assign('coupons',$coupon_data);
	$xoopsTpl->assign( $basic_assign );
	$xoopsTpl->display('db:'.$mydirname."_embed_display.html");
	//----------------------------------------------------------------------
}


//-----------------------------------------------------------------------------------------
function coupons_embed_form( $cp_dir , $embed_dir , $item_field , $item_id )
{
	global $xoopsDB , $xoopsUser , $xoopsGTicket , $xoopsConfig ;

	$mytrustdirname = basename( dirname(dirname( __FILE__ )) ) ;
	$mytrustdirpath = dirname(dirname( __FILE__ )) ;

	$mydirname = htmlspecialchars(coupons_urlCheckReplace($cp_dir),ENT_QUOTES) ;
	$mydirpath = XOOPS_ROOT_PATH .'/modules/'. $mydirname ;
	$mydirurl  = XOOPS_URL .'/modules/'. $mydirname ;

	$module_handler = & xoops_gethandler('module');
	$module = $module_handler->getByDirname( $mydirname );
	$xoopsModule = $module ;
	$mid = $module->getVar('mid');
	$config = & xoops_gethandler('config');
	$xoopsModuleConfig = & $config->getConfigList($mid);

	$page = false ;
	require "$mytrustdirpath/main/header.php";

	//----------------------------------------------------------------------
	if( !$postperm ) return ;

	$firstCids = $categories->getFirstChild(0,"corder,cid");
	if( empty($firstCids) ) return ;

	$pathArray = parse_url( xoops_getenv('REQUEST_URI') ) ;
	$querystring = empty($pathArray['query']) ? '' : '?'.$pathArray['query'] ;
	$filequery = basename($pathArray['path']). $querystring ;
	$filequery = htmlspecialchars(coupons_urlCheckReplace($filequery),ENT_QUOTES) ;

	$selbox = $categories->makeMySelBox( 'corder,cid' , 0 , 1 , 'cid' /*,"","cid",0*/);
	//---------------------------------------------------------------
	require_once XOOPS_ROOT_PATH.'/class/template.php';
	$xoopsTpl = new XoopsTpl();
	$xoopsTpl->assign('category_selbox',$selbox);
	$xoopsTpl->assign( $basic_assign );
	$xoopsTpl->assign('gticket',$xoopsGTicket->getTicketHtml(__LINE__,1800,'coupons_embed_submit'));
	$xoopsTpl->assign('basedata',array(
	    'embed_dir'  => htmlspecialchars($embed_dir,ENT_QUOTES) ,
	    'item_field' => htmlspecialchars($item_field,ENT_QUOTES) ,
	    'item_id'    => $item_id ,
	    'filequery'  => $filequery ,
	  ));
	$xoopsTpl->display('db:'.$mydirname."_embed_form.html");
	//---------------------------------------------------------------
}
?>