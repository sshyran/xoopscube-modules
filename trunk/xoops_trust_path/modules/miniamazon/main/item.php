<?php
require 'header.php';


if( empty( $_GET['lid'] ) ){
	redirect_header( $mydirurl.'/' , 2 , _MD_MINIAMAZON_NOITEM );
} else {
	$lid =  intval( $_GET['lid'] ) ;
}



//Adult check, when user is under18, go to module top
if( !empty($_POST['under18']) ) redirect_header( $mydirurl.'/' , 3 , _MD_MINIAMAZON_REDIRECT );
$miniamazon_age = ( empty($_COOKIE['miniamazon_age']) ) ? 0 : intval($_COOKIE['miniamazon_age']) ;

//count up
$xoopsDB->queryF( "UPDATE $table_items SET clicks=clicks+1 WHERE lid='$lid' AND stats>0" ) ;


//from DB
$sql = "SELECT i.lid, i.cid, i.uid, i.description, i.regdate, i.clicks, i.ASIN, i.title, i.Creator, i.Manufacturer, i.ProductGroup, i.DetailPageURL, i.MediumImage, i.IsAdult, c.ctitle FROM $table_items i LEFT JOIN $table_cat c ON i.cid=c.cid WHERE i.stats>0 AND i.lid=$lid";
$rs = $xoopsDB->query( $sql ) ;
list( $lid, $cid, $itemuid, $description, $regdate, $clicks, $ASIN, $title, $Creator, $Manufacturer, $ProductGroup, $DetailPageURL, $MediumImage, $IsAdult, $ctitle ) = $xoopsDB->fetchRow( $rs );

if( !$lid ) redirect_header( $mydirurl.'/' , 2 , _MD_MINIAMAZON_NODATA );;

//adult process
$warning = "" ;
if( $IsAdult != 0 ){
	if( !empty($_POST['over18']) ){
		setcookie( 'miniamazon_age' , 1 , mktime(0,0,0,1,1,1970) , '/' );
	} else {
		$warning  = _MD_MINIAMAZON_WARNING;
		$warning .= "<form action='$mydirurl/index.php?lid=$lid' method='post'>";	//act=item&amp;
		$warning .= _MD_MINIAMAZON_WARNING2;
		$warning .= _MD_MINIAMAZON_WARNING3;
		$warning .= "<input type='submit' name='over18' value='". _YES ."'>";
		$warning .= "<input type='submit' name='under18' value='" ._NO ."'>";
		$warning .= "</form>";
	}
}

//Item navi
$fullcountresult = $xoopsDB->query( "SELECT lid FROM $table_items WHERE cid=$cid AND stats>0 ORDER BY regdate DESC" ) ;
$ids = array() ;
while( list( $id ) = $xoopsDB->fetchRow( $fullcountresult ) ) {
	$ids[] = $id ;
}

$item_nav = "" ;
$numrows = count( $ids ) ;
$pos = array_search( $lid , $ids ) ;
if( $numrows > 1 ) {
	// prev mark
	if( $ids[0] != $lid ) {
		$item_nav .= "<a href='index.php?lid=".$ids[0]."'><b>[&lt; </b></a>&nbsp;&nbsp;";	//act=item&amp;
		$item_nav .= "<a href='index.php?lid=".$ids[$pos-1]."'><b>"._MD_MINIAMAZON_PREVIOUS."</b></a>&nbsp;&nbsp;";	//act=item&amp;
	}

	$nwin = 7 ;
	if( $numrows > $nwin ) {
		if( $pos > $nwin / 2 ) {
			if( $pos > round( $numrows - ( $nwin / 2 ) - 1 ) ) {
				$start = $numrows - $nwin + 1 ;
			} else {
				$start = round( $pos - ( $nwin / 2 ) ) + 1 ;
			}
		} else {
			$start = 1 ;
		}
	} else {
		$start = 1 ;
	}
	
	for( $i = $start; $i < $numrows + 1 && $i < $start + $nwin ; $i++ ) {
		if( $ids[$i-1] == $lid ) {
			$item_nav .= "<span class='mahilight'>$i</span>&nbsp;&nbsp;";
		} else {
			$item_nav .= "<a href='index.php?lid=".$ids[$i-1]."'>$i</a>&nbsp;&nbsp;";	//act=item&amp;
		}
	}

	// next mark
	if( $ids[$numrows-1] != $lid ) {
		$item_nav .= "<a href='index.php?lid=".$ids[$pos+1]."'><b>"._MD_MINIAMAZON_NEXT."</b></a>&nbsp;&nbsp;" ;	//act=item&amp;
		$item_nav .= "<a href='index.php?lid=".$ids[$numrows-1]."'><b> &gt;]</b></a>" ;	//act=item&amp;
	}
}
//END of item navi

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

//---------------------------------------------------------------------------------
$xoopsOption['template_main'] = $mydirname."_item.html";
require XOOPS_ROOT_PATH.'/header.php';

$eperm = ( $editperm && $itemuid == $uid ) ? 1 : 0 ;
$uname = ( $itemuid==0 ) ? $xoopsConfig['anonymous'] : XoopsUser::getUnameFromId( $itemuid );
$ctitle = ( $cid==0 ) ? _MD_MINIAMAZON_NOCID : $ctitle ;


$item = array(
	'lid'           => $lid ,
	'cid'           => $cid ,
	'uid'           => $itemuid ,
	//displayTarea¡¡$text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1
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


if( $cid == 0 ) {
	$bread[] = array( 'name'=> _MD_MINIAMAZON_NOCID , 'url'=>$mydirurl.'/index.php?cid=0' );
} else {
	$breadplus = assign_get_breadcrumbs_by_tree( $table_cat , 'cid' , 'pid' , 'ctitle' , $cid , $mydirurl.'/index.php?cid=%u' );
	$bread = array_merge( $bread , $breadplus );
}
if( function_exists( 'mb_strcut' ) ) {
	$title = mb_strcut( $title , 0 , 30 ) . "..." ;
}else{
	$title = substr( $title , 0 , 30 ) . "..." ;
}
$bread[] = array( 'name'=> htmlspecialchars( $title ,ENT_QUOTES) );


$xoopsTpl->assign( 'comment_allow' , intval($xoopsModuleConfig['comment_allow']) ) ;
$xoopsTpl->assign( 'comment_dirname' , htmlspecialchars($xoopsModuleConfig['comment_dirname'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'comment_forum_id' , intval($xoopsModuleConfig['comment_forum_id']) ) ;
$xoopsTpl->assign( 'item_nav' , $item_nav ) ;
$xoopsTpl->assign( 'aid' , htmlspecialchars($xoopsModuleConfig['associate_id'],ENT_QUOTES) ) ;
$xoopsTpl->assign( 'ma_age' , $miniamazon_age ) ;
$xoopsTpl->assign( 'warning' , $warning ) ;
$xoopsTpl->assign( 'item' , $item ) ;
$xoopsTpl->assign( 'modulename' , $xoopsModule->getVar('name') );
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign( 'xoops_breadcrumbs' , $bread );
$xoopsTpl->assign( 'xoops_pagetitle' , $xoopsModule->getVar('name')." : ".htmlspecialchars($title,ENT_QUOTES) );


$css_file = '<link rel="stylesheet" href="'. $mydirurl .'/?act=css" type="text/css" media="all" />';
$xoopsTpl->assign( 'xoops_module_header' , $css_file . $xoopsTpl->get_template_vars("xoops_module_header") );

require_once XOOPS_ROOT_PATH.'/footer.php';
//---------------------------------------------------------------------------------

?>