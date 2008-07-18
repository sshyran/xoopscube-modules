<?php

// init
$categories4assign = array() ;

// categories loop
$sql = "SELECT c.* FROM ".$db->prefix($mydirname."_categories")." c WHERE ($whr_read4cat) ORDER BY c.cat_order_in_tree" ;
if( ! $crs = $db->query( $sql ) ) {
	echo $db->logger->dumpQueries() ;
	exit ;
}
while( $cat_row = $db->fetchArray( $crs ) ) {
	$cat_id = intval( $cat_row['cat_id'] ) ;
	$isadminormod = ! empty( $category_permissions[ $cat_id ]['is_moderator'] ) || $isadmin ;
	$category4assign_tmp = array(
		'id' => intval( $cat_row['cat_id'] ) ,
		'link' => pico_common_make_category_link4html( $xoopsModuleConfig , $cat_row ) ,
		'title' => $myts->makeTboxData4Show( $cat_row['cat_title'] ) ,
		'depth_in_tree' => $cat_row['cat_depth_in_tree'] + 1 ,
		'isadminormod' => $isadminormod ,
		'can_post' => ( $isadminormod || @$category_permissions[ $cat_id ]['can_post'] ) ,
		'can_edit' => ( $isadminormod || @$category_permissions[ $cat_id ]['can_edit'] ) ,
		'can_delete' => ( $isadminormod || @$category_permissions[ $cat_id ]['can_delete'] ) ,
		'post_auto_approved' => ( $isadminormod || @$category_permissions[ $cat_id ]['post_auto_approved'] ) ,
		'can_makesubcategory' => ( $isadminormod || @$category_permissions[ $cat_id ]['can_makesubcategory'] ) ,
		'paths_raw' => unserialize( $cat_row['cat_path_in_tree'] ) ,
	) ;
	$categories4assign[ $cat_id ] = $category4assign_tmp + $cat_row ;
}

// auto-register
if( ! empty( $xoopsModuleConfig['wraps_auto_register'] ) ) {
	require_once dirname(__FILE__).'/transact_functions.php' ;
	foreach( $categories4assign as $category_tmp ) {
		pico_auto_register_from_cat_vpath( $mydirname , $category_tmp ) ;
	}
}

foreach( array_keys( $categories4assign ) as $cat_id ) {
	// contents loop
	$sql = "SELECT o.* FROM ".$db->prefix($mydirname."_contents")." o WHERE o.cat_id=$cat_id AND o.created_time <= UNIX_TIMESTAMP() ORDER BY o.weight" ;
	if( ! $ors = $db->query( $sql ) ) {
		echo $db->logger->dumpQueries() ;
		exit ;
	}
	$invisible_contents_counter = 0 ;
	while( $content_row = $db->fetchArray( $ors ) ) {
		if( ! $content_row['visible'] ) {
			$invisible_contents_counter ++ ;
			continue ;
		}
		if( ! $content_row['show_in_menu'] ) continue ;
		$content4assign = array(
			'id' => intval( $content_row['content_id'] ) ,
			'link' => pico_common_make_content_link4html( $xoopsModuleConfig , $content_row ) ,
			'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
			'created_time_formatted' => formatTimestamp( $content_row['created_time'] ) ,
			'modified_time_formatted' => formatTimestamp( $content_row['modified_time'] ) ,
		) ;
		$categories4assign[ $cat_id ]['contents'][] = $content4assign + $content_row ;
	}
	$categories4assign[ $cat_id ]['invisible_contents_counter'] = $invisible_contents_counter ;
}

?>