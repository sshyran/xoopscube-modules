<?php
require 'header.php';

if( !$postperm ){
	redirect_header( $mydirurl.'/' , 3 , _NOPERM );
	exit();
}

$op   = isset( $_POST['op'] ) ? $_POST['op'] : '' ;
$asin = isset( $_POST['asin'] ) ? preg_replace( '/[^a-zA-Z0-9]/' , '' , $_POST['asin'] ) : '' ;
$cid  = isset( $_POST['cid'] ) ? intval($_POST['cid']) : '' ;
$cid  = ( empty($cid) && isset($_GET['cid']) ) ? intval($_GET['cid']) : $cid ;

if( isset($_POST['chk']) ){
	if( $_POST['chk']=='maps' || $_POST['chk']=='' ){
		redirect_header( $mydirurl.'/?act=submit' , 3 , _MD_MINIAMAZON_JS_NOTICE );
	}elseif( intval($_POST['chk']) > time() || intval($_POST['chk']) < time()-1800 ){
		redirect_header( $mydirurl.'/?act=submit' , 3 , _MD_MINIAMAZON_INVALID_DATA );
	}
}

//カテゴリーセレクタ
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php" ;
$cattree = new XoopsTree( $table_cat , "cid" , "pid" ) ;
ob_start();
$cattree->makeMySelBox( 'ctitle' , 'corder' , $cid , 1 , 'cid' , '' );
$catselbox = ob_get_contents();
ob_end_clean();



if( ! empty( $_POST['newItem'] ) ) {
//if( $op == 'submit' ){
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header( $mydirurl.'/' ,3,$xoopsGTicket->getErrors());
	}
	$desc = isset( $_POST['desc'] ) ? addslashes($myts->stripSlashesGPC($_POST['desc'])) : '' ;
	$amazon = new miniAmazon( $xoopsModuleConfig['associate_id'] );
	list( $error, $title, $creator, $manufacturer, $img_m, $pgroup, $dpURL, $isadult ) = $amazon->query($asin);
	if( $error ) redirect_header( $mydirurl.'/index.php?act=submit' , 3 , htmlspecialchars($error,ENT_QUOTES) );
	$ASIN = addslashes( $asin );
	$title = addslashes($title);
	$creator = addslashes($creator);
	$manufacturer = addslashes($manufacturer);
	$pgroup = addslashes($pgroup);
	$dpURL = addslashes($dpURL);
	$img_m = addslashes($img_m);
	$isadult = intval($isadult);
	$stats = ( $post_certifi ) ? 1 : 0 ;	//投稿承認がいる場合：0
	$regdate = time();

	$sql = "INSERT INTO $table_items (cid, uid, description, stats, regdate, ASIN, title, Creator, Manufacturer, ProductGroup, DetailPageURL, MediumImage, IsAdult ) VALUES ($cid, $uid, '$desc', $stats, $regdate, '$ASIN', '$title', '$creator', '$manufacturer', '$pgroup', '$dpURL', '$img_m',  $isadult)";
	$xoopsDB->query( $sql ) or die( "DB error: INSERT item table" ) ;

	//IncrementPost 
	if( $uid > 0 ){
		$user_handler =& xoops_gethandler('user') ;
		$submitter_obj =& $user_handler->get( $uid ) ;
		if( is_object( $submitter_obj ) ) $submitter_obj->incrementPost() ;
	}

	redirect_header( $mydirurl.'/' , 2 , _MD_MINIAMAZON_SUCCESS ) ;
	exit();
}

//---------------------------------------------------------------------------------
//テンプレート
$xoopsOption['template_main'] = $mydirname."_submit.html";
require XOOPS_ROOT_PATH.'/header.php';

	//===============================
	switch( $op )
	{
		case 'query':
			if ( ! $xoopsGTicket->check() ) {	// Ticket Check
				redirect_header( $mydirurl.'/' , 3 , $xoopsGTicket->getErrors() );
			}
			$amazon = new miniAmazon( $xoopsModuleConfig['associate_id'] );
			list( $error, $title, $creator, $manufacturer, $img_m, $pgroup, $dpURL, $isadult ) = $amazon->query($asin);

			//MZZZZZZZ.jpg, THUMBZZZ.jpg
			$image_url = "http://images-jp.amazon.com/images/P/{$asin}.09.MZZZZZZZ.jpg";
			if (! check_Image_URL($image_url)) {
				$image_url = FALSE;
			} else {
				$imgsize = @getimagesize($image_url);
				if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
					$image_url = FALSE;
				}
			}

			if( $error ) $error = 1;
			$xoopsTpl->assign( 'error' , intval($error) );
			$xoopsTpl->assign( 'title' , htmlspecialchars($title,ENT_QUOTES) );
			$xoopsTpl->assign( 'creator' , htmlspecialchars($creator,ENT_QUOTES) );
			$xoopsTpl->assign( 'manufacturer' , htmlspecialchars($manufacturer,ENT_QUOTES) );
			$xoopsTpl->assign( 'img_m' , htmlspecialchars(maCodeDecode($img_m),ENT_QUOTES) );
			$xoopsTpl->assign( 'img_m_url' , $image_url);
			$xoopsTpl->assign( 'pgroup' , htmlspecialchars($pgroup,ENT_QUOTES) );
			$xoopsTpl->assign( 'dpurl' , htmlspecialchars(maCodeDecode($dpURL),ENT_QUOTES) );
			$xoopsTpl->assign( 'isadult' , intval($isadult) );
			$desc = new XoopsFormDhtmlTextArea( "" , "desc" , "" , 6 , 60 ) ;
			$desc_render = $desc->render();
			$xoopsTpl->assign( 'desc' , $desc_render );
			$xoopsTpl->assign( 'gt' , $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ ) );	// Ticket
			break;
		//---------------------
		default:
			//if( ! $catselbox ) die( 'NO CATEGORY' );
			$xoopsTpl->assign( 'gt' , $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ ) );	// Ticket
			$xoopsTpl->assign( 'newpost' , 1 );
	}
	//===============================


$xoopsTpl->assign( 'cid' , $cid );
$xoopsTpl->assign( 'catsel' , $catselbox );
$xoopsTpl->assign( 'asin_no' , htmlspecialchars($asin,ENT_QUOTES) );
$xoopsTpl->assign( $basic_assign );
$xoopsTpl->assign( 'deleteperm' , $deleteperm );
$xoopsTpl->assign( 'chker' , time() );


$css_file = '<link rel="stylesheet" href="'. $mydirurl .'/?act=css" type="text/css" media="all" />';
$xoopsTpl->assign( 'xoops_module_header' , $css_file . $xoopsTpl->get_template_vars("xoops_module_header") );

require_once XOOPS_ROOT_PATH.'/footer.php';
//---------------------------------------------------------------------------------

?>