<?php
include_once 'header.php';

//age チェック
$miniamazon_age = ( empty($_COOKIE['miniamazon_age']) ) ? 0 : intval($_COOKIE['miniamazon_age']) ;

//categories
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php" ;
$cattree = new XoopsTree( $table_cat , "cid" , "pid" ) ;


//---------------------------------------------------------------------------------
//テンプレート
$xoopsOption['template_main'] = $mydirname."_index.html";
require XOOPS_ROOT_PATH.'/header.php';

//item の数
$prs = $xoopsDB->query( "SELECT COUNT(lid) FROM $table_items WHERE stats>0" ) ;
list( $item_num_total ) = $xoopsDB->fetchRow( $prs ) ;

// Navigation
$num = empty( $_GET['num'] ) ? intval($xoopsModuleConfig['item_num_perpage']) : intval( $_GET['num'] ) ;
if( $num < 1 ) $num = 0 ;	//一般設定で 0 設定で全件表示
$pos = empty( $_GET['pos'] ) ? 0 : intval( $_GET['pos'] ) ;
if( $pos >= $item_num_total ) $pos = 0 ;
if( $item_num_total > $num ) {
	include_once( XOOPS_ROOT_PATH . '/class/pagenav.php' ) ;
	$nav = new XoopsPageNav( $item_num_total , $num , $pos , 'pos' , "num=$num" ) ;
	$nav_html = $nav->renderNav( 10 ) ;
	$xoopsTpl->assign( 'navidisp' , true ) ;
	$xoopsTpl->assign( 'navi' , $nav_html ) ;
} else {
	$xoopsTpl->assign( 'navidisp' , false ) ;
}

//DB
$sql = "SELECT i.lid, i.cid, i.uid, i.description, i.regdate, i.clicks, i.ASIN, i.title, i.Creator, i.Manufacturer, i.ProductGroup, i.DetailPageURL, i.MediumImage, i.IsAdult, c.ctitle FROM $table_items i LEFT JOIN $table_cat c ON i.cid=c.cid WHERE i.stats>0 ORDER BY i.regdate DESC";
$rs = $xoopsDB->query( $sql , $num , $pos ) ;


while( $row = $xoopsDB->fetchArray( $rs ) ) {
	$eperm = ( $editperm && $row['uid'] == $uid ) ? 1 : 0 ;
	$uname = ( $row['uid']==0 ) ? $xoopsConfig['anonymous'] : XoopsUser::getUnameFromId( $row['uid'] );
	$ctitle = ( $row['cid']==0 ) ? _MD_MINIAMAZON_NOCID : $row['ctitle'] ;
	//displayTarea　$text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1
	$description = strip_tags($myts->displayTarea( $row['description'] , 0 , 0 , 1 , 1 , 1 ) );
	$desc_max = intval($xoopsModuleConfig['item_num_strings']);
	if( $desc_max != 0 ){
		if( mb_strlen($description) > $desc_max ) $description = mb_strcut($description,0,$desc_max)."..";
	}


	//極小 THUMBZZZ、小 TZZZZZZZ、中 MZZZZZZZ、大 LZZZZZZZ
	$image_url = "http://images-jp.amazon.com/images/P/". $row['ASIN'] .".09.THUMBZZZ.jpg";
	if (! check_Image_URL($image_url)) {
		$image_url = FALSE;
	} else {
		$imgsize = @getimagesize($image_url);
		if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
			$image_url = FALSE;
		}
	}

	$items = array(
		'lid'           => $row['lid'] ,
		'cid'           => $row['cid'] ,
		'uid'           => $row['uid'] ,
		'description'   => $description ,
		'regdate'       => date( 'Y-n-j H:i' , $row['regdate'] ) ,
		'clicks'        => $row['clicks'] ,
		'ASIN'          => htmlspecialchars($row['ASIN'],ENT_QUOTES) ,
		'title'         => htmlspecialchars($row['title'],ENT_QUOTES) ,
		'Creator'       => htmlspecialchars($row['Creator'],ENT_QUOTES) ,
		'Manufacturer'  => htmlspecialchars($row['Manufacturer'],ENT_QUOTES) ,
		'ProductGroup'  => htmlspecialchars($row['ProductGroup'],ENT_QUOTES) ,
		'DetailPageURL' => htmlspecialchars(maCodeDecode($row['DetailPageURL']),ENT_QUOTES) ,
		'MediumImage'   => $image_url ,
		'IsAdult'       => $row['IsAdult'] ,
		'ctitle'        => htmlspecialchars($ctitle,ENT_QUOTES) ,
		'uname'         => htmlspecialchars($uname,ENT_QUOTES) ,
		'editperm'      => $eperm 
	) ;
	$xoopsTpl->append( 'items' , $items ) ;
}



$xoopsTpl->assign( 'subcategories' , ma_get_sub_categories( 0 , $cattree ) ) ;
$xoopsTpl->assign( 'category_options' , ma_get_cat_options() ) ;	//

$xoopsTpl->assign( 'comment_allow' , intval($xoopsModuleConfig['comment_allow']) ) ;
$xoopsTpl->assign( 'comment_dirname' , htmlspecialchars($xoopsModuleConfig['comment_dirname'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'comment_forum_id' , intval($xoopsModuleConfig['comment_forum_id']) ) ;

$xoopsTpl->assign( 'alltotal' , sprintf( _MD_MINIAMAZON_ALLTOTAL , $item_num_total ) );
$xoopsTpl->assign( 'ma_age' , $miniamazon_age );
$xoopsTpl->assign( $basic_assign );


$css_file = '<link rel="stylesheet" href="'. $mydirurl .'/?act=css" type="text/css" media="all" />';
$xoopsTpl->assign( 'xoops_module_header' , $css_file . $xoopsTpl->get_template_vars("xoops_module_header") );

require_once XOOPS_ROOT_PATH.'/footer.php';
//---------------------------------------------------------------------------------


?>