<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;

// get content_id
$content_id = intval( @$_GET['content_id'] ) ;

// get and process $cat_id
$cat_id = $content_id ? pico_main_get_cat_id_from_content_id( $mydirname , $content_id ) : intval( @$_GET['cat_id'] ) ;

// check,fetch and assign the category (set $content_id if necessary)
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// check,fetch and assign the content
require dirname(dirname(__FILE__)).'/include/process_this_content.inc.php' ;

// check if "use_vote" is on
if( empty( $xoopsModuleConfig['use_vote'] ) ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign ) , 0 , _MD_PICO_MSG_VOTEDISABLED ) ;
	exit ;
}

// special check for vote_to_post
if( ! $uid && empty( $xoopsModuleConfig['guest_vote_interval'] ) ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign ) , 0 , _MD_PICO_ERR_VOTEPERM ) ;
	exit ;
}

// get remote_ip
$vote_ip = @$_SERVER['REMOTE_ADDR'] ;
if( ! $vote_ip ) die( _MD_PICO_ERR_VOTEINVALID.__LINE__ ) ;

// branch users and guests
if( $uid ) {
	$useridentity4select = "uid=$uid" ;
} else {
	$useridentity4select = "vote_ip='".mysql_real_escape_string($vote_ip)."' AND uid=0 AND vote_time>".( time() - @$xoopsModuleConfig['guest_vote_interval'] ) ;
}

// get POINT and validation
$point4vote = intval( @$_GET['point'] ) ;
if( $point4vote < 0 || $point4vote > 10 ) die( _MD_PICO_ERR_VOTEINVALID.__LINE__ ) ;

// check double voting
$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_content_votes")." WHERE content_id=$content_id AND ($useridentity4select)" ;
if( ! $result = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
list( $count ) = $db->fetchRow( $result ) ;
if( $count > 0 ) {
	if( $uid > 0 ) {
		// delete previous post
		$sql = "DELETE FROM ".$db->prefix($mydirname."_content_votes")." WHERE content_id=$content_id AND uid=$uid" ;
		if( ! $db->queryF( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
	} else {
		redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign ) , 0 , _MD_PICO_MSG_VOTEDOUBLE ) ;
		exit ;
	}
}

// transaction stage
$sql = "INSERT INTO ".$db->prefix($mydirname."_content_votes")." (content_id,vote_point,vote_time,vote_ip,uid) VALUES ($content_id,$point4vote,UNIX_TIMESTAMP(),'".mysql_real_escape_string($vote_ip)."',$uid)" ;
if( ! $db->queryF( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

require_once dirname(dirname(__FILE__)).'/include/transact_functions.php' ;
pico_sync_content_votes( $mydirname , $content_id ) ;

redirect_header( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign ) , 0 , _MD_PICO_MSG_VOTEACCEPTED ) ;
exit ;

?>