<?php

$db =& Database::getInstance();
global $xoopsUser ;

include XOOPS_ROOT_PATH.'/header.php';

include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mydownload.php' ;
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
$user_access = new user_access( $mydirname ) ;

// 閲覧・投稿可能なカテゴリ取得の準備
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;
$whr_cat4read = "d.".$whr_cat ;
$whr_cat4post = "cid IN (".implode(",", $user_access->can_post() ).")" ;

if( is_object( $xoopsUser ) ) {
	$xoops_isuser = TRUE ;
	$xoops_userid = $xoopsUser->getVar('uid') ;
	$xoops_uname = $xoopsUser->getVar('uname') ;
	$xoops_isadmin = $xoopsUserIsAdmin ;
} else {
	$xoops_isuser = FALSE ;
	$xoops_userid = 0 ;
	$xoops_uname = '' ;
	$xoops_isadmin = FALSE ;
}

// DELETE NULLBYTE
$_GET = d3download_delete_nullbyte( $_GET );

if( ! empty( $_GET['orderby'] ) ) {
  $orderby = d3download_convertorderbyin( trim( $_GET['orderby'] ) );
} else {
  $orderby = "d.title ASC";
}

$xoopsTpl->assign('lang_cursortedby', sprintf( _MD_D3DOWNLOADS_CURSORTBY, d3download_convertorderbytrans( $orderby ) ) );

$can_post4cid = FALSE ;
$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;

$mydownload = new MyDownload( $mydirname );

// CID を取得した場合の処理
if ( isset( $_GET['cid'] ) ) {
	$cid = intval( $_GET['cid'] );
	$xoopsTpl->assign( 'select_id', $cid ) ; 

	// カテゴリ毎の登録件数を取得
	$total = $mydownload->Total_Num( $whr_cat, $cid );
	$total_num = sprintf( _MD_D3DOWNLOADS_CATEGORY_NUM , $total );

	// ページタイトルをアサイン
	include_once dirname( dirname(__FILE__) ).'/class/mycategory.php' ;
	$mycategory = new MyCategory( $mydirname, 'Show', $cid, $whr_cat ) ;
	$pagetitle4assign = $mycategory->return_title() ;

	// 閲覧できないカテゴリはリダイレクト
	$canread = $user_access->user_access_for_cat( $cid, $whr_cat );
	if( empty( $canread ) ) {
		redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/',3, _MD_D3DOWNLOADS_NOREADPERM );
		exit();
	}

	// 投稿可能なカテゴリのみ投稿フォームへのリンクを表示
	$can_post4cid = $user_access->user_access_for_cat( $cid, $whr_cat4post ) ;

	// パンくず部分の処理
	if( ! empty( $xoopsModuleConfig['show_breadcrumbs'] ) ){
		$pathstring = d3download_pathstring( $mytree, $cid, $whr_cat );
		$xoopsTpl->assign( 'category_path', $pathstring );
	}
	$bc_arr =  $mytree->getNicePathArrayFromId( $cid, "title", $whr_cat, "index.php?" );
	foreach( $bc_arr as $bc ) {
		$breadcrumbs[] = array(
			'name' => $bc['name'] ,
			'url' => $bc['url'] ,
		) ;
	}

	// ページナビの処理
	$perpage4assign = d3download_items_perpage();
	$items_perpage = isset( $_GET['perpage'] ) ? intval( $_GET['perpage'] ) : intval( $xoopsModuleConfig['perpage'] );
	if ( isset( $_GET['perpage'] ) ){
		$select_perpage = intval( $_GET['perpage'] );
	} elseif( ! empty( $items_perpage ) ){
		$select_perpage = $items_perpage;
	} else {
		$select_perpage = intval( $xoopsModuleConfig['perpage'] ) ;
	}

	$xoopsTpl->assign( 'category_id', $cid );
	$current_start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
	require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
	$orderby4pagenav = d3download_convertorderbyout( $orderby );
	$pagenav = new XoopsPageNav( $total, $select_perpage, $current_start , 'start' , "&amp;cid=$cid&amp;orderby=$orderby4pagenav&amp;perpage=$select_perpage" ) ;
	$pagenav4assign = $pagenav->renderNav( 5 ) ;
	$xoopsTpl->assign( 'perpage' , $perpage4assign ) ; 
	$xoopsTpl->assign( 'select_perpage' , $select_perpage ) ; 
	$xoopsTpl->assign( 'pagenav' , $pagenav4assign ) ; 
} else {
	// CID がない場合の処理
	$cid = 0;

	// ページタイトルをアサイン
	$pagetitle4assign = $xoopsModule->getVar('name') ;

	// 全体登録件数を取得
	$total = $mydownload->Total_Num( $whr_cat );
	$total_num = sprintf( _MD_D3DOWNLOADS_TOTAL_NUM , $total );
}

// CID を取得した場合はテンプレートを分ける
if( empty( $cid ) ){
	$xoopsOption['template_main'] = $mydirname.'_main_viewcontent.html' ;
} else {
	$xoopsOption['template_main'] = $mydirname.'_main_viewcat.html' ;
}

// カテゴリと登録件数をアサイン
$xoopsTpl->assign( 'subcategories' , d3download_getsub_categories( $mydirname, $cid , $mytree , $whr_cat ) ) ; 
$xoopsTpl->assign( 'download_total_num' , $total_num  ) ;

// 閲覧可能なカテゴリのリストを SELECTボックス用に取得
$category4assin = array();
$category4assin = d3download_makecache_for_selbox( $mydirname, $mytree, $whr_cat, 0, 1 );

// 閲覧可能な登録データを取得
$download4assign = array() ;
if( ! empty( $cid ) ){
	$download4assign = $mydownload->get_downdata_for_catview( $cid, $whr_cat4read, $orderby, $select_perpage, $current_start );
} else {
	$limit = $xoopsModuleConfig['newdownloads'];
	$download4assign = $mydownload->get_downdata_for_topview( $whr_cat4read, $limit );
}

$mod_url = XOOPS_URL.'/modules/'.$mydirname ;
$lang_directcatsel = _MD_D3DOWNLOADS_SEL_CATEGORY;

// スクリーンショット画像を使用するかどうか
$canuseshots = ! empty( $xoopsModuleConfig['useshots'] ) ? 1 : 0 ;

// 投稿可能なカテゴリリストのみ取得(管理者用)
$category4post = array() ;
$post_cid = '' ;
$category4post = d3download_categories_selbox( $mydirname, $mytree, $whr_cat4post );
if( ! empty( $_GET['file_post'] ) && ! empty( $_GET['category_select_admin'] ) ) {
	$post_cid = intval( $_GET['category_select_admin']);
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=submit&amp;cid=$post_cid", 2, _MD_D3DOWNLOADS_REDIRECT_NEWSUBMIT);
	exit ;
}

if( ! empty( $_GET['cat_edit'] ) && ! empty( $_GET['category_select_admin'] ) ) {
	$edit_cid = intval( $_GET['category_select_admin'] );
	redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=categoryedit&amp;cid=$edit_cid", 2, _MD_D3DOWNLOADS_REDIRECT_NEWSUBMIT);
	exit ;
}

$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));

// assign
$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => $mod_url ,
	'file' => $download4assign ,
	'category' => $category4assin ,
	'lang_directcatsel' => $lang_directcatsel ,
	'can_post' => $can_post4cid ,
	'xoops_isuser' => $xoops_isuser ,
	'xoops_userid' => $xoops_userid ,
	'xoops_uname' => $xoops_uname ,
	'xoops_isadmin' => $xoops_isadmin ,
	'xoops_config' => $xoopsConfig ,
	'mod_config' => $xoopsModuleConfig ,
	'canuseshots' => $canuseshots ,
	'category_for_post' => $category4post ,
	'post_cid' => $post_cid ,
	'xoops_pagetitle' => $pagetitle4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
) ) ;
// display
include XOOPS_ROOT_PATH.'/footer.php';

?>