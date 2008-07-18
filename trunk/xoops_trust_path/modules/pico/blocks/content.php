<?php

function b_pico_content_show( $options )
{
	global $xoopsUser ;

	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$content_id = intval( @$options[1] ) ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_content.html' : trim( $options[2] ) ;

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

	$sql = "SELECT o.content_id FROM ".$db->prefix($mydirname."_contents")." o WHERE ($whr_read4content) AND o.content_id='$content_id' /* AND o.visible */ AND o.created_time <= UNIX_TIMESTAMP()" ;
	if( ! $result = $db->query( $sql ) ) return array() ;
	if( ! $db->getRowsNum( $result ) ) return array() ;

	$constpref = '_MB_' . strtoupper( $mydirname ) ;

	list( $content_id ) = $db->fetchRow( $result ) ;

	// assigning
	$content4assign = pico_common_get_content4assign( $mydirname , $content_id , $configs , array() , true ) ;

	// convert links from relative to absolute (wraps mode only)
	if( $configs['use_wraps_mode'] ) {
		$content_url = XOOPS_URL.'/modules/'.$mydirname.'/'.$content4assign['link'] ;
		$wrap_base_url = substr( $content_url , 0 , strrpos( $content_url , '/' ) ) ;
		$pattern = "/(\s+href|\s+src)\=(\"|\')?(?![a-z]+:|\/|\#)([^, \r\n\"\(\)'<>]+)/i" ;
		$replacement = "\\1=\\2$wrap_base_url/\\3" ;
		$content4assign['body'] = preg_replace( $pattern , $replacement , $content4assign['body'] ) ;
	}

	$block = array( 
		'mydirname' => $mydirname ,
		'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
		'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$configs['images_dir'] ,
		'mod_config' => $configs ,
		'content' => $content4assign ,
	) ;

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



function b_pico_content_edit( $options )
{
	$mydirname = empty( $options[0] ) ? 'pico' : $options[0] ;
	$content_id = intval( @$options[1] ) ;
	$this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_content.html' : trim( $options[2] ) ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	// get content_title
	$contents = array( 0 => '--' ) ;
	$result = $db->query( "SELECT content_id,subject,c.cat_depth_in_tree FROM ".$db->prefix($mydirname."_contents")." o LEFT JOIN ".$db->prefix($mydirname."_categories")." c ON o.cat_id=c.cat_id ORDER BY c.cat_order_in_tree,o.weight" ) ;
	while( list( $id , $sbj , $depth ) = $db->fetchRow( $result ) ) {
		$contents[ $id ] = sprintf('%06d',$id).': '.str_repeat('--',$depth).$myts->makeTboxData4Show( $sbj ) ;
	}

	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$tpl =& new XoopsTpl() ;
	$tpl->assign( array(
		'mydirname' => $mydirname ,
		'contents' => $contents ,
		'content_id' => $content_id ,
		'this_template' => $this_template ,
	) ) ;
	return $tpl->fetch( 'db:'.$mydirname.'_blockedit_content.html' ) ;
}



?>