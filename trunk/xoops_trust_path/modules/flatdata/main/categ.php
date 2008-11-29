<?php
if ( !defined('XOOPS_CUBE_LEGACY') || !is_object($client) || !isset($_GET['cat_id']) || @$_GET['cat_id']<0  ) {
	redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
	exit();
}
$cat_id = intval($_GET['cat_id']) ;


$fidarr = $fields->getFidArray('list');

$ord = NULL ;
if( isset($_GET['ord']) ){
	if( strtoupper($_GET['ord'])=='A' || strtoupper($_GET['ord'])=='B' ){
		$ord = strtoupper($_GET['ord']) ;
	}elseif( in_array(abs($_GET['ord']),$fidarr) ){
		$ord = intval($_GET['ord']) ;
	}
}


//search
$sf = $ao = $sq = NULL ;
if( isset($_GET['sf']) && isset($_GET['ao']) && isset($_GET['sq']) ){
	$sf = intval($_GET['sf']) ;
	$ao = intval($_GET['ao']) ;
	$sq = $myts->stripSlashesGPC($_GET['sq']) ;
	$flatdata->setSearch( $ao , $sf , $sq ) ;
}


//GET datas
$allfields = $fields->getAllFields();
$flatdata->setWhere( 'cat_id' , $cat_id ) ;
$rowsnum = $flatdata->getCount();
//navi
$datas = '' ;
$p = empty( $_GET['p'] ) ? 0 : intval( $_GET['p'] ) ;
if( $p >= $rowsnum ) $p = 0 ;
$nav_html = $navinfo = '' ;
if( isset($rowsnum) && $rowsnum > 0 ){ 
	if( $rowsnum > $num ) {
		$extra_arg_arr = array( 'cat_id'=>$cat_id , 'ord'=>$ord , 'ao'=>$ao , 'sf'=>$sf , 'sq'=>$sq ) ;
		$nav = new flatdataPageNavi( $rowsnum , $num , $p , $extra_arg_arr ) ;
		$nav_html = $nav->renderNav() ;
		$navinfo  = $nav->renderNavinfo() ;
	}

	if( !empty($ord) ) $flatdata->setOrder($ord) ;
	$datas = $flatdata->getDatas( $fidarr , $num , $p );
}


if( count($allfields)<1 || count($datas)<1 ){
	redirect_header($mydirurl."/",2,_MD_CANT_GET_DATA);
}

//category bread
$cat_bread = array() ;
if( $cat_id==0 ){
	$cat_bread[]['name'] = _MD_FD_NONE ;
} else {
	$cat_bread[0]['name'] = htmlspecialchars($catTitleArr[$cat_id],ENT_QUOTES) ;
	$catPath = $client->call('getCatPath', array('cat_id'=>$cat_id));
	for($i=0; $i<count($catPath['cat_id']); $i++){
		$cat_bread[$i+1]['name'] = htmlspecialchars($catPath['cat_title'][$i],ENT_QUOTES) ;
		$cat_bread[$i+1]['url'] = $mydirurl ."/index.php?cat_id=". intval($catPath['cat_id'][$i]) ;
	}
	$cat_bread = array_reverse($cat_bread);
}
$bread = array_merge( $bread , $cat_bread );

//category tree
$cattree = $client->call( 'getTree', array('p_id'=>$cat_id) );//'gr_id'=>intval($xoopsModuleConfig['xcat_cat_gr']),

//---------------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_index.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign( 'fields' , $allfields );
$xoopsTpl->assign( 'flatdata' , $datas );
$xoopsTpl->assign( 'p' , $p );
if( !empty($ord) ) $xoopsTpl->assign( 'ord' , $ord );
$xoopsTpl->assign( 'cat_id' , $cat_id );
$xoopsTpl->assign( 'category' , true );
if($nav_html) $xoopsTpl->assign( 'nav' , $nav_html ) ;
if($navinfo) $xoopsTpl->assign( 'navinfo' , $navinfo ) ;

$thereare = _MD_THEREARE_IN_CAT ;
if( isset($ao) && isset($sf) && isset($sq) ){
	$xoopsTpl->assign( 'ao' , $ao );
	$xoopsTpl->assign( 'sf' , $sf );
	$xoopsTpl->assign( 'sq' , htmlspecialchars(flatdata_urlCheckReplace($sq),ENT_QUOTES) );
	$thereare = _MD_SEARCH_RESULT_IN_CAT ;
}
$xoopsTpl->assign('lang_thereare', sprintf($thereare,$rowsnum));
$xoopsTpl->assign('xoops_module_header', $xoops_module_header.$xoopsTpl->get_template_vars('xoops_module_header') ) ;

$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign('xoops_breadcrumbs' , $bread );
$xoopsTpl->assign( 'cattree' , $cattree );

include XOOPS_ROOT_PATH.'/footer.php';
//---------------------------------------------------------------------------------
?>