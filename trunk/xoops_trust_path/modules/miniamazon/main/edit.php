<?php
require 'header.php';

$lid = isset( $_POST['lid'] ) ? intval($_POST['lid']) : '' ;
$lid = ( empty($lid) && isset($_GET['lid']) ) ? intval($_GET['lid']) : $lid ;
if( empty($lid) ){
	redirect_header( $mydirurl."/" , 2 , _MD_MINIAMAZON_NODATA ) ;
	exit();
}

$op = isset( $_POST['op'] ) ? $_POST['op'] : '' ;
//$op = ( empty($op) && isset($_GET['op']) ) ? $_GET['op'] : $op ;
if( ! empty($_POST['requery']) ) $op = "requery";


//削除
if( ! empty( $_POST['do_delete'] ) ) {
	if( ! $deleteperm ) {
		redirect_header( $mydirurl."/" , 2 , _NOPERM ) ;
		exit();
	}
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}
	if( $lid < 1 ) die( "Invalid ID" ) ;

	$prs = $xoopsDB->query("SELECT lid FROM $table_items WHERE lid=$lid Limit 1" ) ;
	while( list( $lid ) = $xoopsDB->fetchRow( $prs ) ) {
		$xoopsDB->query( "DELETE FROM $table_items WHERE lid=$lid" ) or die( "DB error: DELETE item table." ) ;
	}
	redirect_header( $mydirurl."/" , 2 , _MD_MINIAMAZON_DELE_SUCCESS ) ;
	exit ;
}

//削除のキャンセル
if( ! empty( $_POST['cancel_delete'] ) ) {
	redirect_header( $mydirurl."/index.php?lid=$lid" , 2 , _MD_MINIAMAZON_DELE_CANCEL ) ;	//act=item&amp;
	exit ;
}

//削除の確認
if( !empty( $_POST['conf_delete']) ){
	if( ! $deleteperm ) {
		redirect_header( $mydirurl."/" , 2 , _NOPERM ) ;
		exit();
	}

	//include XOOPS_ROOT_PATH.'/include/cp_functions.php' ;
	include XOOPS_ROOT_PATH.'/header.php';

	$result = $xoopsDB->query( "SELECT title,MediumImage FROM $table_items WHERE lid=$lid" ) ;
	list( $title, $img_m ) = $xoopsDB->fetchRow( $result ) ;
	$img_m = htmlspecialchars($img_m,ENT_QUOTES) ;
	$title = htmlspecialchars($title,ENT_QUOTES);

	echo "
	<div style='text-align:center;'>
	<a href='$mydirurl/'><img src='$mydirurl/images/malogo.gif' /></a>
	<h4>"._MD_MINIAMAZON_ITEMDEL."</h4>
		$title<br />
		<img src='$img_m' /><br />
		<form action='index.php?act=edit&amp;lid=$lid' method='post'>
			".$xoopsGTicket->getTicketHtml( __LINE__ )."
			<input type='submit' name='do_delete' value='"._YES."' />
			<input type='submit' name='cancel_delete' value="._NO." />
		</form>
	</div>
	\n" ;

	include  XOOPS_ROOT_PATH . '/footer.php' ;
	exit();
}


//編集権限チェック
if( !$deleteperm ){
	list($itemuid) = $xoopsDB->fetchRow($xoopsDB->query("SELECT uid FROM $table_items WHERE stats>0 AND lid=$lid")) ;
	if( !( $editperm && $itemuid==$uid ) ){
		redirect_header( $mydirurl.'/' , 3 , _NOPERM );
		exit();
	}
}

//再問合後・保存
if( ! empty($_POST['REQ']) && ! empty($_POST['newItem']) ) {
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header( $mydirurl.'/' ,3,$xoopsGTicket->getErrors());
		exit();
	}
	//Amazon Requery
	$asin = isset( $_POST['asin'] ) ? preg_replace( '/[^a-zA-Z0-9]/' , '' , $_POST['asin'] ) : '' ;
	$amazon = new miniAmazon( $xoopsModuleConfig['associate_id'] );
	list( $error, $title, $creator, $manufacturer, $img_m, $pgroup, $dpURL, $isadult ) = $amazon->query($asin);
	if( $error ) redirect_header( $mydirurl.'/' , 3 , htmlspecialchars($error,ENT_QUOTES) );
	$title = addslashes($title);
	$creator = addslashes($creator);
	$manufacturer = addslashes($manufacturer);
	$pgroup = addslashes($pgroup);
	$dpURL = addslashes($dpURL);
	$img_m = addslashes($img_m);
	$isadult = intval($isadult);

	$desc = isset( $_POST['desc'] ) ? addslashes($myts->stripSlashesGPC($_POST['desc'])) : '' ;
	$cid = isset( $_POST['cid'] ) ? intval($_POST['cid']) : '' ;
	$stats = ( $edit_certifi ) ? 1 : 0 ;	//編集承認がいる場合：0
	$regdate = "";
	if( isset($_POST['update']) ) $regdate = ",regdate='".time()."'";

	$xoopsDB->query("UPDATE $table_items SET cid='$cid',description='$desc',stats='$stats',title='$title',Creator='$creator', Manufacturer='$manufacturer', ProductGroup='$pgroup', DetailPageURL='$dpURL', MediumImage='$img_m', IsAdult=$isadult $regdate WHERE lid=$lid") ;
	redirect_header( $mydirurl."/index.php?lid=$lid" , 2 , _MD_MINIAMAZON_SUCCESS ) ;	//act=item&amp;
	exit();
}

//編集の保存
if( ! empty( $_POST['newItem'] ) ) {
	if ( ! $xoopsGTicket->check() ) {	// Ticket Check
		redirect_header( $mydirurl.'/' ,3,$xoopsGTicket->getErrors());
		exit();
	}
	$desc = isset( $_POST['desc'] ) ? addslashes($myts->stripSlashesGPC($_POST['desc'])) : '' ;
	$cid = isset( $_POST['cid'] ) ? intval($_POST['cid']) : '' ;
	//$uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0 ;
	$stats = ( $edit_certifi ) ? 1 : 0 ;	//編集承認がいる場合：0
	$regdate = "";
	if( isset($_POST['update']) ) $regdate = ",regdate='".time()."'";

	$xoopsDB->query("UPDATE $table_items SET cid='$cid',description='$desc',stats='$stats' $regdate WHERE lid='$lid'") ;
	redirect_header( $mydirurl."/index.php?lid=$lid" , 2 , _MD_MINIAMAZON_SUCCESS ) ;	//act=item&amp;
	exit();
}


//---------------------------------------------------------------------------------
//テンプレート
$xoopsOption['template_main'] = $mydirname."_submit.html";

require XOOPS_ROOT_PATH.'/header.php';

//===============================
switch( $op )
{
	case 'requery':
		if ( ! $xoopsGTicket->check() ) {	// Ticket Check
			redirect_header( $mydirurl.'/' , 3 , $xoopsGTicket->getErrors() );
		}
		$asin = isset( $_POST['asin'] ) ? preg_replace( '/[^a-zA-Z0-9]/' , '' , $_POST['asin'] ) : '' ;
		$amazon = new miniAmazon( $xoopsModuleConfig['associate_id'] );
		list( $error2, $title2, $creator2, $manufacturer2, $img_m2, $pgroup2, $dpURL2, $isadult2 ) = $amazon->query($asin);
		if( $error2 ) $error2 = 1;
		$xoopsTpl->assign( 'error2' ,        intval($error2) );
		$xoopsTpl->assign( 'title2' ,        htmlspecialchars($title2,ENT_QUOTES) );
		$xoopsTpl->assign( 'creator2' ,      htmlspecialchars($creator2,ENT_QUOTES) );
		$xoopsTpl->assign( 'manufacturer2' , htmlspecialchars($manufacturer2,ENT_QUOTES) );
		$xoopsTpl->assign( 'img_m2' ,        htmlspecialchars($img_m2,ENT_QUOTES) );
		$xoopsTpl->assign( 'pgroup2' ,       htmlspecialchars($pgroup2,ENT_QUOTES) );
		$xoopsTpl->assign( 'dpurl2' ,        htmlspecialchars($dpURL2,ENT_QUOTES) );
		$xoopsTpl->assign( 'isadult2' ,      intval($isadult2) );
		$xoopsTpl->assign( 'requery' ,       1 );
		//requery 処理後スルー
	case 'edit':
	default:
		$sqlstat = ( $deleteperm ) ? "" : "stats>0 AND" ;
		$sql = "SELECT * FROM $table_items WHERE $sqlstat lid=$lid";
		$rs = $xoopsDB->fetchArray($xoopsDB->query($sql)) ;

		//MZZZZZZZ.jpg, THUMBZZZ.jpg
		$image_url = "http://images-jp.amazon.com/images/P/". $rs['ASIN'] .".09.MZZZZZZZ.jpg";
		if (! check_Image_URL($image_url)) {
			$image_url = FALSE;
		} else {
			$imgsize = @getimagesize($image_url);
			if( $imgsize != false && $imgsize[0] == 1 && $imgsize[1] == 1 ){
				$image_url = FALSE;
			}
		}

		$xoopsTpl->assign( 'regdate' ,      date( 'Y-n-j H:i' , $rs['regdate'] ) );
		$xoopsTpl->assign( 'title' ,        htmlspecialchars($rs['title'],ENT_QUOTES) );
		$xoopsTpl->assign( 'creator' ,      htmlspecialchars($rs['Creator'],ENT_QUOTES) );
		$xoopsTpl->assign( 'manufacturer' , htmlspecialchars($rs['Manufacturer'],ENT_QUOTES) );
		$xoopsTpl->assign( 'img_m' ,        htmlspecialchars($rs['MediumImage'],ENT_QUOTES) );
		$xoopsTpl->assign( 'img_m_url' ,    $image_url);
		$xoopsTpl->assign( 'pgroup' ,       htmlspecialchars($rs['ProductGroup'],ENT_QUOTES) );
		$xoopsTpl->assign( 'dpurl' ,        htmlspecialchars($rs['DetailPageURL'],ENT_QUOTES) );
		$xoopsTpl->assign( 'isadult' ,      $rs['IsAdult'] );
		$xoopsTpl->assign( 'asin_no' ,      htmlspecialchars($rs['ASIN'],ENT_QUOTES) );
		$desc = new XoopsFormDhtmlTextArea( "" , "desc" ,  $myts->makeTareaData4Edit($rs['description']) , 6 , 60 ) ;
		$desc_render = $desc->render();
		$xoopsTpl->assign( 'desc' , $desc_render );
		$xoopsTpl->assign( 'lid' , $lid );

		$xoopsTpl->assign( 'gt' , $GLOBALS['xoopsGTicket']->getTicketHtml( __LINE__ ) );	// Ticket
		$xoopsTpl->assign( 'edit' , 1 );
}
//===============================





//カテゴリーセレクタ
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php" ;
$cattree = new XoopsTree( $table_cat , "cid" , "pid" ) ;
ob_start();
$cattree->makeMySelBox( 'ctitle' , 'corder' , $rs['cid'] , 1 , 'cid' , '' );
$catselbox = ob_get_contents();
ob_end_clean();

$xoopsTpl->assign( 'catsel' , $catselbox );
$xoopsTpl->assign( $basic_assign );


$css_file = '<link rel="stylesheet" href="'. $mydirurl .'/?act=css" type="text/css" media="all" />';
$xoopsTpl->assign( 'xoops_module_header' , $css_file . $xoopsTpl->get_template_vars("xoops_module_header") );

require_once XOOPS_ROOT_PATH.'/footer.php';
?>