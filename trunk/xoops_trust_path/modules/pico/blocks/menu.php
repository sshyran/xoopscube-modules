<?php

function b_pico_menu_show( $options )
{
	global $xoopsUser ;

	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_menu.html' : trim( $options[2] ) ;

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

	$sql = "SELECT o.content_id,o.vpath,o.subject,o.created_time,o.modified_time,o.poster_uid,c.cat_id,c.cat_title,c.cat_depth_in_tree FROM ".$db->prefix($mydirname."_contents")." o LEFT JOIN ".$db->prefix($mydirname."_categories")." c ON o.cat_id=c.cat_id WHERE ($whr_read4content) AND ($whr_categories) AND o.visible AND o.created_time <= UNIX_TIMESTAMP() AND o.show_in_menu ORDER BY c.cat_order_in_tree,o.weight" ;
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

	$cat4assign = array() ;
	while( $content_row = $db->fetchArray( $result ) ) {
		$cat_id = intval( $content_row['cat_id'] ) ;
		$cat4assign[$cat_id]['id'] = intval( $content_row['cat_id'] ) ;
		$cat4assign[$cat_id]['link'] = pico_common_make_category_link4html( $configs , $content_row ) ;
		$cat4assign[$cat_id]['title'] = $myts->makeTboxData4Show( $content_row['cat_title'] ) ;
		$cat4assign[$cat_id]['depth_in_tree'] = intval( $content_row['cat_depth_in_tree'] ) ;
		$cat4assign[$cat_id]['contents'][] = array(
			'id' => intval( $content_row['content_id'] ) ,
			'link' => pico_common_make_content_link4html( $configs , $content_row ) ,
			'subject' => $myts->makeTboxData4Show( $content_row['subject'] ) ,
			'created_time' => $content_row['created_time'] ,
			'created_time_formatted' => formatTimestamp( $content_row['created_time'] ) ,
			'modified_time' => $content_row['modified_time'] ,
			'modified_time_formatted' => formatTimestamp( $content_row['modified_time'] ) ,
			'poster_uid' => $content_row['poster_uid'] ,
		) ;
	}
	$block['categories'] = $cat4assign ;

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



function b_pico_menu_edit( $options )
{
	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$categories = trim( @$options[1] ) === '' ? array() : array_map( 'intval' , explode( ',' , $options[1] ) ) ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_menu.html' : trim( $options[2] ) ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$tpl =& new XoopsTpl() ;
	$tpl->assign( array(
		'mydirname' => $mydirname ,
		'categories' => $categories ,
		'categories_imploded' => implode( ',' , $categories ) ,
		'order_options' => b_pico_list_allowed_order() ,
		'this_template' => $this_template ,
	) ) ;
	return $tpl->fetch( 'db:'.$mydirname.'_blockedit_menu.html' ) ;
}

?>