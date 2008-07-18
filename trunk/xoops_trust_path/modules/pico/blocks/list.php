<?php

function b_pico_list_allowed_order()
{
	return array(
		'o.weight' ,
		'o.weight DESC' ,
		'o.created_time' ,
		'o.created_time DESC' ,
		'o.modified_time' ,
		'o.modified_time DESC' ,
		'o.viewed' ,
		'o.viewed DESC' ,
		'o.votes_sum' ,
		'o.votes_sum DESC' ,
		'o.votes_count' ,
		'o.votes_count DESC' ,
	) ;
}


function b_pico_list_show( $options )
{
	global $xoopsUser ;

	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
	$selected_order = empty( $options[2] ) || ! in_array( $options[2] , b_pico_list_allowed_order() ) ? 'o.created_time DESC' : $options[2] ;
	$contents_num = empty( $options[3] ) ? 10 : intval( $options[3] ) ;
	$this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_list.html' : trim( $options[4] ) ;
	$display_body = empty( $options[5] ) ? false : true ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();
	$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;

	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($mydirname);
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	// categories can be read by current viewer (check by category_permissions)
	$whr_read4content = 'o.`cat_id` IN (' . implode( "," , pico_common_get_categories_can_read( $mydirname ) ) . ')' ;

	// categories
	if( $categories === array() ) {
		$whr_categories = '1' ;
		$categories4assign = '' ;
	} else {
		$whr_categories = 'o.cat_id IN ('.implode(',',$categories).')' ;
		$categories4assign = implode(',',$categories) ;
	}

	$sql = "SELECT o.content_id,o.vpath,o.subject,o.created_time,o.modified_time,o.poster_uid,o.use_cache,o.body_cached,o.body,o.filters,c.cat_id,c.cat_title FROM ".$db->prefix($mydirname."_contents")." o LEFT JOIN ".$db->prefix($mydirname."_categories")." c ON o.cat_id=c.cat_id WHERE ($whr_read4content) AND ($whr_categories) AND o.visible AND o.created_time <= UNIX_TIMESTAMP() ORDER BY $selected_order,o.content_id LIMIT $contents_num" ;
	if( ! $result = $db->query( $sql ) ) {
		echo $db->logger->dumpQueries() ;
		exit ;
	}

	$constpref = '_MB_' . strtoupper( $mydirname ) ;

	$block = array( 
		'mydirname' => $mydirname ,
		'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
		'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$configs['images_dir'] ,
		'mod_config' => $configs ,
		'categories' => $categories4assign ,
		'lang_category' => constant($constpref.'_CATEGORY') ,
		'lang_topcategory' => constant($constpref.'_TOPCATEGORY') ,
	) ;

	while( $content_row = $db->fetchArray( $result ) ) {
		$content4assign = array(
			'id' => intval( $content_row['content_id'] ) ,
			'link' => pico_common_make_content_link4html( $configs , $content_row ) ,
			'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
			'subject_raw' => $content_row['subject'] ,
//			'body' => $display_body ? pico_common_filter_body( $mydirname , $content_row , $content_row['use_cache'] ) : '' ,
			'body' => $display_body ? $content_row['body_cached'] : '' ,
			'created_time_formatted' => formatTimestamp( $content_row['created_time'] ) ,
			'modified_time_formatted' => formatTimestamp( $content_row['modified_time'] ) ,
			'cat_title' => $myts->makeTboxData4Show( $content_row['cat_title'] ) ,
		) ;
		$block['contents'][] = $content4assign + $content_row ;
	}

	if( empty( $options['disable_renderer'] ) ) {
		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( 'block' , $block ) ;
		$ret['content'] = $tpl->fetch( $this_template ) ;
		return $ret ;
	} else {
		return $block ;
	}
}



function b_pico_list_edit( $options )
{
	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
	$selected_order = empty( $options[2] ) || ! in_array( $options[2] , b_pico_list_allowed_order() ) ? 'o.created_time DESC' : $options[2] ;
	$contents_num = empty( $options[3] ) ? 10 : intval( $options[3] ) ;
	$this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_list.html' : trim( $options[4] ) ;
	$display_body = empty( $options[5] ) ? false : true ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$tpl =& new XoopsTpl() ;
	$tpl->assign( array(
		'mydirname' => $mydirname ,
		'categories' => $categories ,
		'categories_imploded' => implode( ',' , $categories ) ,
		'order_options' => b_pico_list_allowed_order() ,
		'selected_order' => $selected_order ,
		'contents_num' => $contents_num ,
		'this_template' => $this_template ,
		'display_body' => $display_body ,
	) ) ;
	return $tpl->fetch( 'db:'.$mydirname.'_blockedit_list.html' ) ;
}

?>