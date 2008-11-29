<?php
require 'header.php';
$myts = & MyTextSanitizer :: getInstance();

//管理者権限チェック
if( ! $deleteperm ) redirect_header( $mydirurl."/" , 2 , _NOPERM ) ;

if( empty( $_GET['lid'] ) ){
	redirect_header( $mydirurl.'/' , 2 , _MD_MINIAMAZON_NOITEM );
} else {
	$lid =  intval( $_GET['lid'] ) ;
}




//---------------------------------------------------------------------------------
//テンプレート
$xoopsOption['template_main'] = $mydirname."_item.html";
require XOOPS_ROOT_PATH.'/header.php';



//from DB
$sql = "SELECT i.lid, i.cid, i.uid, i.description, i.regdate, i.clicks, i.ASIN, i.title, i.Creator, i.Manufacturer, i.ProductGroup, i.DetailPageURL, i.MediumImage, i.IsAdult, c.ctitle FROM $table_items i LEFT JOIN $table_cat c ON i.cid=c.cid WHERE i.lid=$lid";
$rs = $xoopsDB->query( $sql ) ;
list( $lid, $cid, $itemuid, $description, $regdate, $clicks, $ASIN, $title, $Creator, $Manufacturer, $ProductGroup, $DetailPageURL, $MediumImage, $IsAdult, $ctitle ) = $xoopsDB->fetchRow( $rs );


//MZZZZZZZ.jpg, THUMBZZZ.jpg
$image_url = "http://images-jp.amazon.com/images/P/{$ASIN}.09.MZZZZZZZ.jpg";
if (! check_Image_URL($image_url)) {
	$image_url = FALSE;
} else {
	$imgsize = @getimagesize($image_url);
	if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
		$image_url = FALSE;
	}
}


$eperm = ( $editperm && $itemuid == $uid ) ? 1 : 0 ;
$uname = ( $itemuid==0 ) ? $xoopsConfig['anonymous'] : XoopsUser::getUnameFromId( $itemuid );
$ctitle = ( $cid==0 ) ? _MD_MINIAMAZON_NOCID : $ctitle ;
if( empty($Creator) ) $Creator = '-';
$item = array(
	'lid'           => $lid ,
	'cid'           => $cid ,
	'uid'           => $itemuid ,
	//displayTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1
	'description'   => $myts->displayTarea( $description , 0 , 1 , 1 , 1 , 1 ) ,
	'regdate'       => date( 'Y-n-j H:i' , $regdate ) ,
	'clicks'        => $clicks ,
	'ASIN'          => htmlspecialchars( $ASIN ,ENT_QUOTES) ,
	'title'         => htmlspecialchars( $title ,ENT_QUOTES) ,
	'Creator'       => htmlspecialchars( $Creator ,ENT_QUOTES) ,
	'Manufacturer'  => htmlspecialchars( $Manufacturer ,ENT_QUOTES) ,
	'ProductGroup'  => htmlspecialchars( $ProductGroup ,ENT_QUOTES) ,
	'DetailPageURL' => htmlspecialchars( maCodeDecode($DetailPageURL) ,ENT_QUOTES) ,
	'MediumImage'   => $image_url ,
	'IsAdult'       => $IsAdult ,
	'ctitle'        => htmlspecialchars( $ctitle ,ENT_QUOTES) ,
	'uname'         => htmlspecialchars( $uname ,ENT_QUOTES) ,
	'editperm'      => $eperm 
) ;


//xoops_breadcrumbs
if( $cid === 0 ) {
	$bread[] = array( 'name'=> _MD_MINIAMAZON_NOCID , 'url'=>$mydirurl.'/index.php?cid=0' );	//act=viewcat&amp;
} else {
	$breadplus = assign_get_breadcrumbs_by_tree( $table_cat , 'cid' , 'pid' , 'ctitle' , $cid , $mydirurl.'/index.php?cid=%u' );
	$bread = array_merge( $bread , $breadplus );
}
$bread[] = array( 'name'=> htmlspecialchars( $title ,ENT_QUOTES) );
$bread[] = array( 'name'=> _MD_MINIAMAZON_CERTIFI_CHECK );


$xoopsTpl->assign( 'aid' , htmlspecialchars($xoopsModuleConfig['associate_id'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'ma_age' , 1 ) ;
$xoopsTpl->assign( 'warning' , $warning ) ;
$xoopsTpl->assign( 'item' , $item ) ;
$xoopsTpl->assign( 'modulename' , $xoopsModule->getVar('name') );
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign( 'xoops_breadcrumbs' , $bread );


$css_file = '<link rel="stylesheet" href="'. $mydirurl .'/?act=css" type="text/css" media="all" />';
$xoopsTpl->assign( 'xoops_module_header' , $css_file . $xoopsTpl->get_template_vars("xoops_module_header") );

require_once XOOPS_ROOT_PATH.'/footer.php';




?>