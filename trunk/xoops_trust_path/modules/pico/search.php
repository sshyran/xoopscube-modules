<?php

include_once dirname(__FILE__).'/include/common_functions.php' ;

eval( '

function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $uid )
{
	return pico_global_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $uid ) ;
}

' ) ;


if( ! function_exists( 'pico_global_search_base' ) ) {

function pico_global_search_base( $mydirname , $keywords , $andor , $limit , $offset , $uid )
{
	$db =& Database::getInstance() ;

	// get this module's config
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($mydirname);
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	// check xmobile or not
	$is_xmobile = false ;
	if( function_exists( 'debug_backtrace' ) && ( $backtrace = debug_backtrace() ) ) {
		if( strstr( $backtrace[2]['file'] , '/xmobile/actions/' ) ) {
			$is_xmobile = true ;
		}
	}

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "o.`body_cached` AS text" : "'' AS text" ;

	// categories can be read by current viewer (check by category_permissions)
	$whr_read4content = 'o.`cat_id` IN (' . implode( "," , pico_common_get_categories_can_read( $mydirname ) ) . ')' ;

	// where by uid
	if( ! empty( $uid ) ) {
		if( empty( $configs['search_by_uid'] ) ) {
			return array() ;
		}
		$whr_uid = 'o.poster_uid='.intval($uid) ;
	} else {
		$whr_uid = '1' ;
	}

	// where by keywords
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		switch( strtolower( $andor ) ) {
			case "and" :
				$whr_kw = "" ;
				foreach( $keywords as $keyword ) {
					$whr_kw .= "(o.`subject` LIKE '%$keyword%' OR o.`body_cached` LIKE '%$keyword%') AND " ;
				}
				$whr_kw .= "1" ;
				break ;
			case "or" :
				$whr_kw = "" ;
				foreach( $keywords as $keyword ) {
					$whr_kw .= "(o.`subject` LIKE '%$keyword%' OR o.`body_cached` LIKE '%$keyword%') OR " ;
				}
				$whr_kw .= "0" ;
				break ;
			default :
				$whr_kw = "(o.`subject` LIKE '%$keywords[0]%' OR o.`body_cached` LIKE '%{$keywords[0]}%')" ;
				break ;
		}
	} else {
		$whr_kw = 1 ;
	}

	$sql = "SELECT o.`content_id`,o.`cat_id`,o.`vpath`,o.`subject`,o.`created_time`,o.`poster_uid`,$select4con FROM ".$db->prefix($mydirname."_contents")." o WHERE ($whr_kw) AND ($whr_uid) AND ($whr_read4content) AND o.visible AND o.created_time <= UNIX_TIMESTAMP() ORDER BY o.created_time DESC" ;
	$result = $db->query( $sql , $limit , $offset ) ;
	$ret = array() ;
	$context = '' ;
	while( $content_row = $db->fetchArray( $result ) ) {

		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( @$content_row['text'] ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

		$ret[] = array(
			'image' => '' ,
			'link' => $is_xmobile ? 'index.php?cat_id='.$content_row['cat_id'].'&content_id='.$content_row['content_id'] : pico_common_make_content_link4html( $configs , $content_row ) ,
			'title' => $content_row['subject'] ,
			'time' => $content_row['created_time'] ,
			'uid' => empty( $configs['search_by_uid'] ) ? 0 : $content_row['poster_uid'] ,
			'context' => $context ,
		) ;
	}

	return $ret ;
}

}


?>