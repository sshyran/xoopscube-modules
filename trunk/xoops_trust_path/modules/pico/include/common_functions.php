<?php

// this file can be included from d3forum's blocks or getSublink().

@include_once dirname(__FILE__).'/constants.php' ;
if( ! defined( '_MD_PICO_WRAPBASE' ) ) require_once dirname(__FILE__).'/constants.dist.php' ;



function pico_get_categories_can_read( $mydirname ) { return pico_common_get_categories_can_read( $mydirname ) ; }

function pico_common_get_categories_can_read( $mydirname , $uid = null )
{
	$db =& Database::getInstance() ;

	if( $uid > 0 ) {
		$user_handler =& xoops_gethandler( 'user' ) ;
		$user =& $user_handler->get( $uid ) ;
	} else {
		$user = @$GLOBALS['xoopsUser'] ;
	}

	if( is_object( $user ) ) {
		$uid = intval( $user->getVar('uid') ) ;
		$groups = $user->getGroups() ;
		if( ! empty( $groups ) ) {
			$whr4cat = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
		} else {
			$whr4cat = "`uid`=$uid" ;
		}
	} else {
		$whr4cat = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
	}

	// get categories
	$sql = "SELECT distinct cat_id FROM ".$db->prefix($mydirname."_category_permissions")." WHERE ($whr4cat)" ;
	$result = $db->query( $sql ) ;
	if( $result ) while( list( $cat_id ) = $db->fetchRow( $result ) ) {
		$cat_ids[] = intval( $cat_id ) ;
	}

	if( empty( $cat_ids ) ) return array(0) ;
	else return $cat_ids ;
}


function pico_common_filter_body( $mydirname , $content_row , $use_cache = false )
{
	$can_use_cache = $use_cache && $content_row['body_cached'] ;

	// wraps special check (compare filemtime with modified_time )
	if( strstr( $content_row['filters'] , 'wraps' ) && $content_row['vpath'] ) {
		$wrap_full_path = XOOPS_TRUST_PATH._MD_PICO_WRAPBASE.'/'.$mydirname.str_replace('..','',$content_row['vpath']) ;
		if( @filemtime( $wrap_full_path ) > @$content_row['modified_time'] ) {
			$can_use_cache = false ;
			$db =& Database::getInstance() ;
			$db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET modified_time='".filemtime( $wrap_full_path )."' WHERE content_id=".intval($content_row['content_id']) ) ;
		}
	}

	if( $can_use_cache ) {
		return $content_row['body_cached'] ;
	}

	// process each filters
	$text = $content_row['body'] ;
	$filters = explode( '|' , $content_row['filters'] ) ;
	foreach( array_keys( $filters ) as $i ) {
		$filter = trim( $filters[ $i ] ) ;
		if( empty( $filter ) ) continue ;
		// xcode special check
		if( $filter == 'xcode' ) {
			$nl2br = $smiley = 0 ;
			for( $j = $i + 1 ; $j < $i + 3 ; $j ++ ) {
				if( @$filters[ $j ] == 'nl2br' ) {
					$nl2br = 1 ;
					$filters[ $j ] = '' ;
				} else if( @$filters[ $j ] == 'smiley' ) {
					$smiley = 1 ;
					$filters[ $j ] = '' ;
				}
			}
			require_once dirname(dirname(__FILE__)).'/class/pico.textsanitizer.php' ;
			$myts =& PicoTextSanitizer::getInstance() ;
			$text = $myts->displayTarea( $text , 1 , $smiley , 1 , 1 , $nl2br ) ;
			continue ;
		}
		$func_name = 'pico_'.$filter ;
		$file_path = dirname(dirname(__FILE__)).'/filters/pico_'.$filter.'.php' ;
		if( function_exists( $func_name ) ) {
			$text = $func_name( $mydirname , $text , $content_row ) ;
		} else if( file_exists( $file_path ) ) {
			require_once $file_path ;
			$text = $func_name( $mydirname , $text , $content_row ) ;
		}
	}

	// store the result into body_cached field
	if( $use_cache ) {
		$db =& Database::getInstance() ;
		$db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET body_cached='".mysql_real_escape_string($text)."' WHERE content_id=".intval($content_row['content_id']) ) ;
	}

	return $text ;
}


function pico_make_content_link4html( $mod_config , $content_row , $mydirname = null ) { return pico_common_make_content_link4html( $mod_config , $content_row , $mydirname ) ; }

function pico_common_make_content_link4html( $mod_config , $content_row , $mydirname = null )
{
	if( ! empty( $mod_config['use_wraps_mode'] ) ) {
		// wraps mode 
		if( ! is_array( $content_row ) && ! empty( $mydirname ) ) {
			// specify content by content_id instead of content_row
			$db =& Database::getInstance() ;
			$content_row = $db->fetchArray( $db->query( "SELECT content_id,vpath FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".intval($content_row) ) ) ;
		}

		if( ! empty( $content_row['vpath'] ) ) {
			$ret = 'index.php'.htmlspecialchars($content_row['vpath'],ENT_QUOTES) ;
		} else {
			$ret = 'index.php' . sprintf( _MD_PICO_AUTONAME4SPRINTF , intval( $content_row['content_id'] ) ) ;
		}
		return empty( $mod_config['use_rewrite'] ) ? $ret : substr( $ret , 10 ) ;
	} else {
		// normal mode
		$content_id = is_array( $content_row ) ? intval( $content_row['content_id'] ) : intval( $content_row ) ;
		return empty( $mod_config['use_rewrite'] ) ? 'index.php?content_id='.$content_id : substr( sprintf( _MD_PICO_AUTONAME4SPRINTF , $content_id ) , 1 ) ;
	}
}


function pico_common_make_category_link4html( $mod_config , $cat_row , $mydirname = null )
{
	if( ! empty( $mod_config['use_wraps_mode'] ) ) {
		if( empty( $cat_row ) || is_array( $cat_row ) && $cat_row['cat_id'] == 0 ) return '' ;
		if( ! is_array( $cat_row ) && ! empty( $mydirname ) ) {
			// specify category by cat_id instead of cat_row
			$db =& Database::getInstance() ;
			$cat_row = $db->fetchArray( $db->query( "SELECT cat_id,cat_vpath FROM ".$db->prefix($mydirname."_categories")." WHERE cat_id=".intval($cat_row) ) ) ;
		}
		if( ! empty( $cat_row['cat_vpath'] ) ) {
			$ret = 'index.php'.htmlspecialchars($cat_row['cat_vpath'],ENT_QUOTES) ;
			if( substr( $ret , -1 ) != '/' ) $ret .= '/' ;
		} else {
			$ret = 'index.php' . sprintf( _MD_PICO_AUTOCATNAME4SPRINTF , intval( $cat_row['cat_id'] ) ) ;
		}
		return empty( $mod_config['use_rewrite'] ) ? $ret : substr( $ret , 10 ) ;
	} else {
		// normal mode
		$cat_id = is_array( $cat_row ) ? intval( $cat_row['cat_id'] ) : intval( $cat_row ) ;
		if( $cat_id ) return empty( $mod_config['use_rewrite'] ) ? 'index.php?cat_id='.$cat_id : substr( sprintf( _MD_PICO_AUTOCATNAME4SPRINTF , $cat_id ) , 1 ) ;
		else return '' ;
	}
}


function pico_common_get_submenu( $mydirname , $caller = 'xoops_version' )
{
	static $submenus_cache ;

	if( ! empty( $submenus_cache[$caller][$mydirname] ) ) return $submenus_cache[$caller][$mydirname] ;

	$module_handler =& xoops_gethandler('module') ;
	$module =& $module_handler->getByDirname( $mydirname ) ;
	if( ! is_object( $module ) ) return array() ;
	$config_handler =& xoops_gethandler('config') ;
	$mod_config =& $config_handler->getConfigsByCat( 0 , $module->getVar('mid') ) ;

	$db =& Database::getInstance() ;
	$myts =& MyTextSanitizer::getInstance();

	$whr_read = '`cat_id` IN (' . implode( "," , pico_common_get_categories_can_read( $mydirname ) ) . ')' ;
	$categories = array( 0 => array( 'pid' => -1 , 'name' => '' , 'url' => '' , 'sub' => array() ) ) ;

	// categories query
	$sql = "SELECT cat_id,pid,cat_title,cat_vpath FROM ".$db->prefix($mydirname."_categories")." WHERE ($whr_read) ORDER BY cat_order_in_tree" ;
	$crs = $db->query( $sql ) ;
	if( $crs ) while( $cat_row = $db->fetchArray( $crs ) ) {
		$cat_id = intval( $cat_row['cat_id'] ) ;
		$categories[ $cat_id ] = array(
			'name' => $myts->makeTboxData4Show( $cat_row['cat_title'] ) ,
			'url' => pico_common_make_category_link4html( $mod_config , $cat_row ) ,
			'is_category' => true ,
			'pid' => $cat_row['pid'] ,
		) ;
	}

	if( ! ( $caller == 'sitemap_plugin' && ! @$mod_config['sitemap_showcontents'] ) && ! ( $caller == 'xoops_version' && ! @$mod_config['submenu_showcontents'] ) ) {
		// contents query
		$ors = $db->query( "SELECT cat_id,content_id,vpath,subject FROM ".$db->prefix($mydirname."_contents" )." WHERE show_in_menu AND visible AND created_time <= UNIX_TIMESTAMP() AND $whr_read ORDER BY weight" ) ;
		if( $ors ) while( $content_row = $db->fetchArray( $ors ) ) {
			$cat_id = intval( $content_row['cat_id'] ) ;
			$categories[ $cat_id ]['sub'][] = array(
				'name' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
				'url' => pico_common_make_content_link4html( $mod_config , $content_row ) ,
				'is_category' => false ,
			) ;
		}
	}

	// restruct categories
	$top_sub = ! empty( $categories[0]['sub'] ) ? $categories[0]['sub'] : array() ;
	$submenus_cache[$caller][$mydirname] = array_merge( $top_sub , pico_common_restruct_categories( $categories , 0 ) ) ;
	return $submenus_cache[$caller][$mydirname] ;
}


function pico_common_restruct_categories( $categories , $parent )
{
	$ret = array() ;
	foreach( $categories as $cat_id => $category ) {
		if( $category['pid'] == $parent ) {
			if( empty( $category['sub'] ) ) $category['sub'] = array() ;
			$ret[] = array(
				'name' => $category['name'] ,
				'url' => $category['url'] ,
				'is_category' => $category['is_category'] ,
				'sub' => array_merge( $category['sub'] , pico_common_restruct_categories( $categories , $cat_id ) ) ,
			) ;
		}
	}

	return $ret ;
}


function pico_common_get_content4assign( $mydirname , $content_id , $mod_config , $category_row = null , $process_body = false )
{
	$content_id = intval( $content_id ) ;

	$myts =& MyTextSanitizer::getInstance() ;
	$db =& Database::getInstance() ;
	$user_handler =& xoops_gethandler( 'user' ) ;

	$content_row = $db->fetchArray( $db->query( "SELECT * FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".$content_id ) ) ;

	// poster & modifier uname
	$poster =& $user_handler->get( $content_row['poster_uid'] ) ;
	$poster_uname = is_object( $poster ) ? $poster->getVar('uname') : @_MD_PICO_REGISTERED_AUTOMATICALLY ;
	$modifier =& $user_handler->get( $content_row['modifier_uid'] ) ;
	$modifier_uname = is_object( $modifier ) ? $modifier->getVar('uname') : @_MD_PICO_REGISTERED_AUTOMATICALLY ;

	$content4assign = array(
		'id' => intval( $content_row['content_id'] ) ,
		'link' => pico_common_make_content_link4html( $mod_config , $content_row ) ,
		'created_time_formatted' => formatTimestamp( $content_row['created_time'] ) ,
		'modified_time_formatted' => formatTimestamp( $content_row['modified_time'] ) ,
		'poster_uname' => $poster_uname ,
		'modifier_uname' => $modifier_uname ,
		'votes_avg' => $content_row['votes_count'] ? $content_row['votes_sum'] / doubleval( $content_row['votes_count'] ) : 0 ,
		'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
		'subject_raw' => $content_row['subject'] ,
		// 'body' => $content_row['body'] ,
		'body_raw' => $content_row['body'] ,
		'can_edit' => @$category_row['can_edit'] ,
		'can_delete' => @$category_row['can_delete'] ,
		'can_vote' => ( is_object( $GLOBALS['xoopsUser'] ) || $mod_config['guest_vote_interval'] ) ? true : false ,
	) + $content_row ;

	// only 'body' is parsed after creating new content_row (for xoopstpl filter)
	return array( 'body' => $process_body ? pico_common_filter_body( $mydirname , $content4assign , $content_row['use_cache'] ) : $content_row['body_cached'] ) + $content4assign ;
}


function pico_common_utf8_encode_recursive( &$data )
{
	if( is_array( $data ) ) {
		foreach( array_keys( $data ) as $key ) {
			pico_common_utf8_encode_recursive( $data[ $key ] ) ;
		}
	} else if( ! is_numeric( $data ) ) {
		if( XOOPS_USE_MULTIBYTES == 1 ) {
			if( function_exists( 'mb_convert_encoding' ) ) {
				$data = mb_convert_encoding( $data , 'UTF-8' , mb_internal_encoding() ) ;
			}
		} else {
			$data = utf8_encode( $data ) ;
		}
	}
}


// create category options as array
function pico_common_get_cat_options( $mydirname )
{
	$db =& Database::getInstance() ;

	$crs = $db->query( "SELECT c.cat_id,c.cat_title,c.cat_depth_in_tree,COUNT(o.content_id) FROM ".$db->prefix($mydirname."_categories")." c LEFT JOIN ".$db->prefix($mydirname."_contents")." o ON c.cat_id=o.cat_id GROUP BY c.cat_id ORDER BY c.cat_order_in_tree" ) ;
	$cat_options = array( 0 => _MD_PICO_TOP ) ;
	while( list( $id , $title , $depth , $contents_num ) = $db->fetchRow( $crs ) ) {
		$cat_options[ $id ] = str_repeat( '--' , $depth ) . htmlspecialchars( $title , ENT_QUOTES ) . " ($contents_num)" ;
	}

	return $cat_options ;
}


// convert timezone user -> server
function pico_common_get_server_timestamp( $time )
{
	global $xoopsConfig, $xoopsUser;

	$offset = is_object( @$xoopsUser ) ? $xoopsUser->getVar('timezone_offset') : $xoopsConfig['default_TZ'] ;

	return $time - ( $offset - $xoopsConfig['server_TZ'] ) * 3600 ;
}


// reverse filter function of htmlspecialchars( , ENT_QUOTES ) ;
function pico_common_unhtmlspecialchars( $data )
{
	if( is_array( $data ) ) {
		return array_map( 'pico_common_unhtmlspecialchars' , $data ) ;
	} else {
		return str_replace(
			array( '&lt;' , '&gt;' , '&amp;' , '&quot;' , '&#039;' ) ,
			array( '<' , '>' , '&' , '"' , "'" ) ,
			$data ) ;
	}
}


if( ! function_exists( 'htmlspecialchars_ent' ) ) {
function htmlspecialchars_ent( $string )
{
	return htmlspecialchars( $string , ENT_QUOTES ) ;
}
}

?>