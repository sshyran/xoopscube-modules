<?php
$mydirurl  = XOOPS_URL .'/modules/'. $mydirname ;
$mytrustdirpath = dirname(dirname( __FILE__ )) ;

require_once $mytrustdirpath .'/class/gtickets.php' ;
require_once $mytrustdirpath .'/include/functions.php' ;
require $mytrustdirpath .'/include/version.php' ;
require_once $mytrustdirpath .'/class/flatdataPageNavi.php' ;

if( !isset($xoopsModule) ){
	$module_handler = & xoops_gethandler('module');
	$xoopsModule = $module_handler->getByDirname( $mydirname );
}
if( !is_object($xoopsModule) ) return ;
$mid = $xoopsModule->getVar('mid') ;
$modulename = $xoopsModule->getVar('name') ;

if( !isset($xoopsModuleConfig) ){
	$config = & xoops_gethandler('config');
	$xoopsModuleConfig = & $config->getConfigList( $mid );
}


//DB table
$xoopsDB =& Database::getInstance() ;
$table_field = $xoopsDB->prefix( $mydirname."_filed" ) ;
$table_data  = $xoopsDB->prefix( $mydirname."_data" ) ;

$myts = & MyTextSanitizer::getInstance();

//xoopsuser and permission check
if ( isset($xoopsUser) && is_object($xoopsUser) ) {
	$uid = $xoopsUser->uid() ;
	$uname = $xoopsUser->uname();
	$realname = $xoopsUser->name() ? $xoopsUser->name() : '' ;
	$isadmin = $xoopsUser->isAdmin( $mid ) ;//module admin check
	$groups = $xoopsUser->getGroups();
}else{
	$uid = 0 ;
	$uname = isset($xoopsConfig) ? $xoopsConfig['anonymous'] : '' ;
	$realname = '' ;
	$isadmin = false ;
	$groups = XOOPS_GROUP_ANONYMOUS;
}


//When 'embed_disp_perm' is 1, the access to the module is only the module administrator.
$embed_dispperm = intval($xoopsModuleConfig['embed_disp_perm']) ;
if( !(isset($_POST['flatdata_embed_dir']) || isset($embed_dir) || isset($_POST['flatdata_embed'])) ){//$_POST['flatdata_embed']
	if( $embed_dispperm==1 && !$isadmin ){
		redirect_header(XOOPS_URL."/",2,_NOPERM);
		exit();
	}
}
$sp_embed_dir = array('userinfo.php','edituser.php','register.php') ;//TODO


//POST:1, EDIT:2, DELETE:3
$gperm =& xoops_gethandler('groupperm');
$postperm = ( $gperm->checkRight('flatdata_perm',1,$groups,$mid) || $isadmin ) ? true : false ;
$editperm = (($gperm->checkRight('flatdata_perm',2,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;
$delperm  = (($gperm->checkRight('flatdata_perm',3,$groups,$mid) && is_object($xoopsUser)) || $isadmin ) ? true : false ;


//fields instance
require_once $mytrustdirpath."/class/fields.class.php" ;
$fields = new flatdataFieldsClass( $mydirname ) ;
//flatdata instance
require_once $mytrustdirpath."/class/flatdata.class.php" ;
$flatdata = new Flatdata( $mydirname , @$page ) ;
if($xoopsModuleConfig['use_bbcode']){
	$flatdata->useBBcode() ;
}

//category(XCAT)
$cattree = $catTitleArr = $countByCat = NULL ;
if( defined('XOOPS_CUBE_LEGACY') && $xoopsModuleConfig['xcat_cat_gr']>0 && file_exists(XOOPS_ROOT_PATH."/modules/xcat/xoops_version.php") ){
	$flatdata->useCategory() ;
	$root =& XCube_Root::getSingleton();
	$service = $root->mServiceManager->getService("Xcat_CatService");
	$client = $root->mServiceManager->createClient($service);
	
	$cattree = $client->call( 'getTree', array('gr_id'=>intval($xoopsModuleConfig['xcat_cat_gr'])) );
	if( !(@$page=='submit' || @$page=='edit') ){
		$catTitleArr = $client->call('getTitleList', array('gr_id'=>intval($xoopsModuleConfig['xcat_cat_gr'])));
	}
	if( $cattree && (@$page=='index' || @$page=='categ') ){
		$countByCat = $flatdata->countByCategory($cattree);
	}
}

//Bread crumbs
$bread[] = array( 'name'=> $modulename , 'url'=>$mydirurl.'/' );
if( isset($page) ){
	$bcname = '' ;
	if( $page=='submit' ) $bcname = _MD_SUBMIT_DATA ;
	if( $page=='edit' ) $bcname = _MD_EDIT_DATA ;
	if( !empty($bcname) ) $bread[] = array( 'name'=> $bcname );
}


$num = intval($xoopsModuleConfig['number_of_list']) ;

//basic assign
$basic_assign = array(
	'myurl'             => $mydirurl ,
	'mydirname'         => $mydirname ,
	'uid'               => $uid ,
	'uname'             => htmlspecialchars($uname,ENT_QUOTES) ,
	'realname'          => htmlspecialchars($realname,ENT_QUOTES) ,
	'isadmin'           => $isadmin ,
	'xoops_breadcrumbs' => $bread ,
	'version'           => htmlspecialchars($flatdata_version,ENT_QUOTES) ,
	'postperm'          => $postperm ,
	'editperm'          => $editperm ,
	'delperm'           => $delperm ,
	'cattree'           => $cattree ,
	'catTitleArr'       => $catTitleArr ,
	'countByCat'        => $countByCat ,
);

$xoops_module_header = '<link rel="stylesheet" type="text/css" media="all" href="'. $mydirurl .'/index.php?page=css" />' ;

if( defined('XOOPS_CUBE_LEGACY') && isset($page) ){
	XCube_DelegateUtils::call('Flatdata.Event.Header.Preprocess', new XCube_Ref($flatdata), new XCube_Ref($fields) , $page );
}
?>