<?php
include_once $mytrustdirpath .'/class/groupperm.php';
include_once $mytrustdirpath .'/include/gtickets.php' ;
include_once $mytrustdirpath .'/include/xml.php' ;
include_once $mytrustdirpath .'/class/amazon.php' ;
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php' ;
include_once $mytrustdirpath . '/include/functions.php';
include_once $mytrustdirpath . '/include/version.php';

//DB table
$table_items = $xoopsDB->prefix( $mydirname."_items" ) ;
$table_cat = $xoopsDB->prefix( $mydirname."_cat" ) ;

//サニタイザ
$myts = & MyTextSanitizer :: getInstance();


//投稿権限:1 承認不要:2　、編集権限:3 承認不要:4
$gperm = new maGroupPermission;
$postperm     = ( $gperm->group_perm(1) ) ? true : false ;
$post_certifi = ( $gperm->group_perm(2) ) ? true : false ;
$editperm     = ( $gperm->group_perm(3) && is_object($xoopsUser) ) ? true : false ;
$edit_certifi = ( $gperm->group_perm(4) && is_object($xoopsUser) ) ? true : false ;
$uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0 ;

//削除できるのはモジュール管理者権限を持っているもの
$moduleperm_handler =& xoops_gethandler('groupperm');
$deleteperm = false;
if ( $xoopsUser ) $deleteperm = $xoopsUser->isAdmin( $xoopsModule->getVar('mid') ) ;

//xoops_breadcrumbs
$bread[] = array( 'name'=> $xoopsModule->getVar('name') , 'url'=>$mydirurl.'/' );
if( $act == 'submit' ){
	$bread[] = array( 'name'=> _MD_MINIAMAZON_REGI );
}elseif( $act == 'edit' ){
	$bread[] = array( 'name'=> _EDIT );
}

//Basic assign
$basic_assign = array(
	'myurl' 			=> $mydirurl ,
  //'lang_search'		=> _MD_MINIAMAZON_QUERY ,
	'lang_asin'			=> _MD_MINIAMAZON_ASIN ,
	'lang_register'		=> _REGISTER ,
	'lang_regi' 		=> _MD_MINIAMAZON_REGI ,
	'lang_img' 			=> _IMAGE ,
	'lang_title' 		=> _MD_MINIAMAZON_TITLE ,
	'lang_creator' 		=> _MD_MINIAMAZON_CREATOR ,
	'lang_manufacturer'	=> _MD_MINIAMAZON_MANUFACTURER ,
	'lang_pgroup'		=> _MD_MINIAMAZON_PGROUP ,
	'lang_comments'		=> _COMMENTS ,
	'lang_cat'			=> _MD_MINIAMAZON_CAT ,
	'lang_nomatch'		=> _MD_MINIAMAZON_NOMATCH,
	'lang_isadult'		=> _MD_MINIAMAZON_ISADULT,
	'miniamazon_ver'    => $miniamazon_version ,
	'lang_warning'		=> _MD_MINIAMAZON_WARNING . _MD_MINIAMAZON_WARNING3,
	'lang_clicks'		=> _MD_MINIAMAZON_CLICKS,
	'lang_toamazon'		=> _MD_MINIAMAZON_TOAMAZON,
	'lang_detail'		=> _MD_MINIAMAZON_DETAIL,
	'lang_update_date'	=> _MD_MINIAMAZON_UPDATE,
	'lang_regdate'		=> _MD_MINIAMAZON_REGDATE,
	'lang_catsel'		=> _MD_MINIAMAZON_CATSEL,
	'lang_moresubcat'	=> _MD_MINIAMAZON_MORESUBCAT,
	'lang_total'		=> _MD_MINIAMAZON_TOTAL,
	'postperm'			=> $postperm,
	'post_certifi'		=> $post_certifi,
	'editperm'			=> $editperm,
	'edit_certifi'		=> $edit_certifi,
	'lang_postperm'		=> _MD_MINIAMAZON_POSTPERM,
	'lang_post_certifi'	=> _MD_MINIAMAZON_POST_CERTIFI,
	'lang_editperm'		=> _MD_MINIAMAZON_EDITPERM,
	'lang_edit_certifi'	=> _MD_MINIAMAZON_EDIT_CERTIFI,
	'lang_requery'		=> _MD_MINIAMAZON_REQUERY,
	'deleteperm'		=> $deleteperm,
	'lang_about_req'	=> _MD_MINIAMAZON_ABOUT_REQ,
	'mydirname'			=> $mydirname,
	'lang_comment'      => _COMMENTS,
	'xoops_breadcrumbs' => $bread ,
);





if( !function_exists('assign_get_breadcrumbs_by_tree') ){
	function assign_get_breadcrumbs_by_tree( $table , $id_col , $pid_col , $name_col , $id_val , $url_fmt , $paths = array() )
	{
		$db =& Database::getInstance() ;

		$sql = "SELECT `$pid_col`,`$name_col` FROM ".$table." WHERE `$id_col`=".intval($id_val) ;
		$result = $db->query( $sql ) ;
		if( $db->getRowsNum( $result ) == 0 ) return $paths ;
		list( $pid , $name ) = $db->fetchRow( $result ) ;
		$paths = array_merge( array( array(
			'name' => htmlspecialchars( $name , ENT_QUOTES ) ,
			'url' => sprintf( $url_fmt , $id_val ) ,
		) ) , $paths ) ;

		return assign_get_breadcrumbs_by_tree( $table , $id_col , $pid_col , $name_col , $pid , $url_fmt , $paths ) ;
	}
}
?>