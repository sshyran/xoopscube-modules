<?php

$whr_cid = empty( $cat_id ) ? '1' : 'o.cat_id='.intval($cat_id) ;

$sql = "SELECT o.*,c.cat_id,c.cat_title FROM ".$db->prefix($mydirname."_contents")." o LEFT JOIN ".$db->prefix($mydirname."_categories")." c ON o.cat_id=c.cat_id WHERE ($whr_read4content) AND ($whr_cid) AND o.visible AND o.created_time <= UNIX_TIMESTAMP() ORDER BY o.modified_time DESC,o.content_id LIMIT 10" ;
if( ! $result = $db->query( $sql ) ) {
	echo $db->logger->dumpQueries() ;
	exit ;
}

$contents4assign = array() ;
while( $content_row = $db->fetchArray( $result ) ) {
	$content4assign_tmp = array(
		'id' => intval( $content_row['content_id'] ) ,
		'link' => pico_common_make_content_link4html( $xoopsModuleConfig , $content_row ) ,
		'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
//		'body4rss' => htmlspecialchars( xoops_substr( strip_tags( pico_common_filter_body( $mydirname , $content_row , $content_row['use_cache'] ) ) , 0 , 255 ) , ENT_QUOTES ) ,
		'body4rss' => htmlspecialchars( xoops_substr( strip_tags( $content_row['body_cached'] ) , 0 , 255 ) , ENT_QUOTES ) ,
		'created_time_formatted' => formatTimestamp( $content_row['created_time'] ) ,
		'created_time4rss' => date( 'r' , $content_row['created_time'] ) ,
		'modified_time_formatted' => formatTimestamp( $content_row['modified_time'] ) ,
		'modified_time4rss' => date( 'r' , $content_row['modified_time'] ) ,
		'cat_id' => intval( $content_row['cat_id'] ) ,
		'cat_title' => $myts->makeTboxData4Show( $content_row['cat_title'] ) ,
	) ;
	$contents4assign[] = $content4assign_tmp + $content_row ;
}

?>