<?php
if ( !isset($_GET['did']) || empty($_GET['did'])  ) {
	redirect_header( $mydirurl."/" , 2 , _MD_CANT_GET_DATA );
	exit();
}

//GET data
$did = intval($_GET['did']) ;

$flatdata->countup($did) ;

$allfields = $fields->getAllFields();
$fidarr = $fields->getFidArray();
$data = $flatdata->getData( $did , $fidarr ) ;

if( count($allfields)<1 || empty($data) ){
	redirect_header($mydirurl."/",2,_MD_CANT_GET_DATA);
}

$alldid = $flatdata->getAllDid() ;
$page_navi = flatdata_singleNavi( $alldid , $did ) ;


//category bread
$cat_bread = array() ;
if( $data['cat_id']!=0 && in_array($data['cat_id'],array_keys($catTitleArr)) ){
	$cat_bread[0]['name'] = htmlspecialchars($catTitleArr[$data['cat_id']],ENT_QUOTES) ;
	$cat_bread[0]['url'] = $mydirurl ."/index.php?cat_id=". $data['cat_id'] ;
	$catPath = $client->call('getCatPath', array('cat_id'=>$data['cat_id']));
	for($i=0; $i<count($catPath['cat_id']); $i++){
		$cat_bread[$i+1]['name'] = htmlspecialchars($catPath['cat_title'][$i],ENT_QUOTES) ;
		$cat_bread[$i+1]['url'] = $mydirurl ."/index.php?cat_id=". intval($catPath['cat_id'][$i]) ;
	}
	$cat_bread = array_reverse($cat_bread);
}
$cat_bread[]['name'] = "ID:$did" ;
$bread = array_merge( $bread , $cat_bread );



//---------------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname.'_single.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign( 'fields' , $allfields );
$xoopsTpl->assign( 'data' , $data );
$xoopsTpl->assign( 'page_navi' , $page_navi );
$xoopsTpl->assign( $basic_assign );

$xoopsTpl->assign('xoops_breadcrumbs' , $bread );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header.$xoopsTpl->get_template_vars('xoops_module_header') ) ;

include XOOPS_ROOT_PATH.'/footer.php';
//---------------------------------------------------------------------------------
?>