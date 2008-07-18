<?php

include XOOPS_ROOT_PATH.'/header.php';
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$db =& Database::getInstance() ;

$xoopsOption['template_main'] = $mydirname.'_main_ratedownload.html' ;

$user_access = new user_access( $mydirname ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

if ( isset( $_GET['cid'] ) ) {
	$cid = intval( $_GET['cid'] );
	include_once dirname(dirname(__FILE__)).'/class/mytree.php' ;
	$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
	if( ! empty( $xoopsModuleConfig['show_breadcrumbs'] ) ){
		$pathstring = d3download_pathstring( $mytree, $cid, $whr_cat );
		$xoopsTpl->assign('category_path', $pathstring);
	}
	$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;
	$bc_arr =  $mytree->getNicePathArrayFromId( $cid, "title", $whr_cat, "index.php?" );
	foreach( $bc_arr as $bc ) {
		$breadcrumbs[] = array(
			'name' => $bc['name'] ,
			'url' => $bc['url'] ,
		) ;
	}
}

$lid = empty( $_GET['lid'] ) ? 0 : intval( $_GET['lid'] ) ;
$download4assign = d3download_get_title( $mydirname, $lid, $whr_cat );
$title4assign = $download4assign['title'] ;

$breadcrumbs[] = array( 'name' => $title4assign ) ;

if( ! empty( $_POST['submit'] ) ) {

	if( empty( $xoopsUser ) ){
		$ratinguser = 0;
	} else {
		$ratinguser = $xoopsUser->getVar('uid');
	}

	//Make sure only 1 anonymous from an IP in a single day.
	$anonwaitdays = 1 ;
	$ip = getenv( "REMOTE_ADDR" ) ;
	$lid = intval( $_POST['lid'] ) ;
	$rating = intval( $_POST['rating'] ) ;
	// Check if rating is valid
	if( $rating <= 0 || $rating > 10 ) {
		redirect_header( XOOPS_URL."/modules/$mydirname/index.php?page=ratefile&amp;lid=$lid" , 4 , _MD_D3DOWNLOADS_NORATING ) ;
		exit ;
	}

	if( $ratinguser != 0 ) {

		// Check if Download POSTER is voting
		$rs = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_downloads" )." WHERE lid=$lid AND submitter=$ratinguser" ) ;
		list( $is_my_deta ) = $db->fetchRow( $rs ) ;
		if( $is_my_deta ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 4 , _MD_D3DOWNLOADS_CANTVOTEOWN ) ;
			exit ;
		}

		// Check if REG user is trying to vote twice.
		$rs = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_votedata" )." WHERE lid=$lid AND ratinguser=$ratinguser" ) ;
		list( $has_already_rated ) = $db->fetchRow( $rs ) ;
		if( $has_already_rated ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 4 , _MD_D3DOWNLOADS_VOTEONCE2 ) ;
			exit ;
		}

	} else {
		// Check if ANONYMOUS user is trying to vote more than once per day.
		$yesterday = ( time() - ( 86400 * $anonwaitdays ) ) ;
		$rs = $db->query( "SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_votedata" )." WHERE lid=$lid AND ratinguser=0 AND ratinghostname='$ip' AND ratingtimestamp > $yesterday");
		list( $anonvotecount ) = $db->fetchRow( $rs ) ;
		if( $anonvotecount ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/" , 4 , _MD_D3DOWNLOADS_VOTEONCE2 ) ;
			exit ;
		}
	}

	// All is well.  Add to Line Item Rate to DB.
	$newid = $db->genId($db->prefix( $mydirname."_votedata" )."_ratingid_seq");
	$datetime = time() ;
	$sql = sprintf( "INSERT INTO %s (ratingid, lid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $db->prefix( $mydirname."_votedata" ), $newid, $lid, $ratinguser, $rating, $ip, $datetime );
	$db->query($sql);

	//All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
	d3download_updaterating( $mydirname, $lid );
	d3download_delete_topview_cache( $mydirname );
	$ratemessage = _MD_D3DOWNLOADS_VOTEAPPRE."<br />".sprintf( _MD_D3DOWNLOADS_THANKURATE , $xoopsConfig['sitename'] ) ;
	if( ! empty( $_SESSION["{$mydirname}_uri4return"] ) ) {
		redirect_header( $_SESSION["{$mydirname}_uri4return"] , 2 , $ratemessage ) ;
		unset( $_SESSION["{$mydirname}_uri4return"] ) ;
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/" , 2 , $ratemessage ) ;
	}
	exit ;

}

// store the referer
if( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
	$_SESSION["{$mydirname}_uri4return"] = $_SERVER['HTTP_REFERER'] ;
}

$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'ratefile' ,
	'down' => $download4assign ,
	'lang_voteonce' => _MD_D3DOWNLOADS_VOTEONCE ,
	'lang_ratingscale' => _MD_D3DOWNLOADS_RATINGSCALE ,
	'lang_beobjective' => _MD_D3DOWNLOADS_BEOBJECTIVE ,
	'lang_donotvote' => _MD_D3DOWNLOADS_DONOTVOTE ,
	'lang_rateit' =>  _MD_D3DOWNLOADS_RATEIT ,
	'lang_cancel' => _CANCEL ,
	'xoops_pagetitle' => $title4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
	'mod_config' => $xoopsModuleConfig ,
) ) ;

include XOOPS_ROOT_PATH.'/footer.php';

?>