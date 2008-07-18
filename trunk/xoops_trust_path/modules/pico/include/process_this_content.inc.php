<?php

// $content_id check
if( empty( $content_id ) ) {
	redirect_header( XOOPS_URL.'/' , 2 , _MD_PICO_ERR_READCONTENT ) ;
	exit ;
}

// permission check "can_readfull"
if( empty( $category_permissions[$cat_id]['can_readfull'] ) ) {
	if( is_object( $xoopsUser ) ) {
		redirect_header( XOOPS_URL.'/' , 2 , _MD_PICO_ERR_PERMREADFULL ) ;
	} else {
		redirect_header( XOOPS_URL.'/user.php' , 2 , _MD_PICO_ERR_LOGINTOREADFULL ) ;
	}
	exit ;
}

// visible check
$whr4visible = $isadminormod ? '1' : '(visible OR poster_uid='.intval($uid).' AND poster_uid>0) AND created_time <= UNIX_TIMESTAMP()' ;

// confirm this "content" exists from given $content_id
$sql = "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_contents")." WHERE content_id='$content_id' AND ($whr4visible)" ;
list( $count ) = $db->fetchRow( $db->query( $sql ) ) ;
if( $count <= 0 ) {
	redirect_header( XOOPS_URL."/modules/$mydirname/index.php" , 2 , _MD_PICO_ERR_READCONTENT ) ;
	exit ;
}

// assigning
$content4assign = pico_common_get_content4assign( $mydirname , $content_id , $xoopsModuleConfig , $category4assign , @$_GET['page'] == 'contentmanager' ? false : true ) ;

// locked check
if( ! empty( $content4assign['locked'] ) && ! $isadminormod ) {
	$content4assign['can_edit'] = false ;
	$content4assign['can_delete'] = false ;
}

// get next content of the category
list( $next_content_id ) = $xoopsDB->fetchRow( $xoopsDB->query( "SELECT o.content_id FROM ".$xoopsDB->prefix($mydirname."_contents")." o WHERE (o.weight>".$content4assign['weight']." OR o.content_id>$content_id AND o.weight=".$content4assign['weight'].") AND o.cat_id=$cat_id AND ($whr4visible) AND o.show_in_navi ORDER BY o.weight,o.content_id LIMIT 1" ) ) ;
if( empty( $next_content_id ) ) {
	$next_content4assign = array() ;
} else {
	$next_content4assign = pico_common_get_content4assign( $mydirname , $next_content_id , $xoopsModuleConfig , $category4assign , false ) ;
}

// get prev content of the category
list( $prev_content_id ) = $xoopsDB->fetchRow( $xoopsDB->query( "SELECT o.content_id FROM ".$xoopsDB->prefix($mydirname."_contents")." o WHERE (o.weight<".$content4assign['weight']." OR o.content_id<$content_id AND o.weight=".$content4assign['weight'].") AND o.cat_id=$cat_id AND ($whr4visible) AND o.show_in_navi ORDER BY o.weight DESC,o.content_id DESC LIMIT 1" ) ) ;
if( empty( $prev_content_id ) ) {
	$prev_content4assign = array() ;
} else {
	$prev_content4assign = pico_common_get_content4assign( $mydirname , $prev_content_id , $xoopsModuleConfig , $category4assign , false ) ;
}

// make link for "tell to a friend"
if( $xoopsModuleConfig['use_taf_module'] ) {
	$content4assign['tellafriend_uri'] = XOOPS_URL.'/modules/tellafriend/index.php?target_uri='.rawurlencode( XOOPS_URL."/modules/$mydirname/".pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign ) ).'&amp;subject='.rawurlencode(sprintf(_MD_PICO_FMT_TELLAFRIENDSUBJECT,$xoopsConfig['sitename'])) ;
} else {
	$content4assign['tellafriend_uri'] = 'mailto:?subject='.pico_main_escape4mailto(sprintf(_MD_PICO_FMT_TELLAFRIENDSUBJECT,$xoopsConfig['sitename'])).'&amp;body='.pico_main_escape4mailto(sprintf(_MD_PICO_FMT_TELLAFRIENDBODY, $content4assign['subject_raw'])).'%0A'.XOOPS_URL."/modules/$mydirname/".rawurlencode(pico_common_make_content_link4html( $xoopsModuleConfig , $content4assign )) ;
}

?>