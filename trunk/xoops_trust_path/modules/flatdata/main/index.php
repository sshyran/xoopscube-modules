<?php
$fidarr = $fields->getFidArray('list');

$ord = NULL ;
if( isset($_GET['ord']) ){
	//if( strtoupper($_GET['ord'])=='A' || strtoupper($_GET['ord'])=='B' ){
	if( in_array( strtoupper($_GET['ord']) , array('A','B','C','D','E','F','R') ) ){
		$ord = strtoupper($_GET['ord']) ;
	}elseif( in_array(abs($_GET['ord']),$fidarr) ){
		$ord = intval($_GET['ord']) ;
	}
}

$get_uid = 0 ;
if( isset($_GET['uid']) && $_GET['uid']>0 ){
	$get_uid = intval($_GET['uid']) ;
	$get_uid_name = getUnameFromUid($get_uid) ;
	$flatdata->setWhere( 'uid' , $get_uid ) ;
}

//search
$sf = $ao = $sq = NULL ;
if( isset($_GET['sf']) && isset($_GET['ao']) && isset($_GET['sq']) ){
	$sf = intval($_GET['sf']) ;
	$ao = intval($_GET['ao']) ;
	$sq = $myts->stripSlashesGPC(trim($_GET['sq'])) ;
	$flatdata->setSearch( $ao , $sf , $sq ) ;
}
$rowsnum = $flatdata->getCount();

$datas = $nav_html = $navinfo = '' ;
$p = empty( $_GET['p'] ) ? 0 : intval( $_GET['p'] ) ;
if( $p >= $rowsnum ) $p = 0 ;
if( isset($rowsnum) && $rowsnum > 0 ){ 
	if( $rowsnum > $num ) {
		$extra_arg_arr = array( 'ord'=>$ord , 'ao'=>$ao , 'sf'=>$sf , 'sq'=>$sq , 'uid'=>$get_uid ) ;
		$nav = new flatdataPageNavi( $rowsnum , $num , $p , $extra_arg_arr ) ;
		$nav_html = $nav->renderNav() ;
		$navinfo  = $nav->renderNavinfo() ;
	}
	if( !empty($ord) ) $flatdata->setOrder($ord) ;
	$datas = $flatdata->getDatas( $fidarr , $num , $p );
}


$allfields = $fields->getAllFields();
//--------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname."_index.html";
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign( 'flatdata' , $datas );
$xoopsTpl->assign( 'fields' , $allfields );
$xoopsTpl->assign( 'p' , $p );
if( !empty($ord) ) $xoopsTpl->assign( 'ord' , $ord );

$xoopsTpl->assign( 'nav' , $nav_html ) ;
$xoopsTpl->assign( 'navinfo' , $navinfo ) ;
$xoopsTpl->assign( $basic_assign );

$thereare = ( isset($get_uid_name) && $get_uid_name != '' ) ? _MD_THEREARE_UID : _MD_THEREARE ;
if( isset($ao) && isset($sf) && isset($sq) ){
	$xoopsTpl->assign( 'ao' , $ao );
	$xoopsTpl->assign( 'sf' , $sf );
	$xoopsTpl->assign( 'sq' , htmlspecialchars(flatdata_urlCheckReplace($sq),ENT_QUOTES) );
	$thereare = ( isset($get_uid_name) && $get_uid_name != '' ) ? _MD_SEARCH_RESULT_UID : _MD_SEARCH_RESULT ;
}
if( isset($get_uid_name) && $get_uid_name != '' ){
	$xoopsTpl->assign('lang_thereare', sprintf($thereare,$rowsnum,$get_uid_name));
}else{
	$xoopsTpl->assign('lang_thereare', sprintf($thereare,$rowsnum));
}
$xoopsTpl->assign('xoops_module_header', $xoops_module_header.$xoopsTpl->get_template_vars('xoops_module_header') ) ;

include XOOPS_ROOT_PATH.'/footer.php';
?>