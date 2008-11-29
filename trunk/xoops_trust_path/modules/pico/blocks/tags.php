<?php

function b_pico_tags_show( $options )
{
	// options
	$mytrustdirname = basename(dirname(dirname(__FILE__))) ;
	$mydirname = empty( $options[0] ) ? $mytrustdirname : $options[0] ;
	$limit = empty( $options[1] ) ? 10 : intval( $options[1] ) ;
	$listorder = 'label' ;
	$sqlorder = 'count' ;
	$this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_tags.html' : trim( $options[4] ) ;

	// mydirname check
	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

	// sql
	$sql = "SELECT label,count FROM ".$db->prefix($mydirname."_tags")." ORDER BY $sqlorder DESC LIMIT $limit" ;
	$result = $db->query( $sql ) ;

	// tags4assign
	$tags = array() ;
	$rank = 0 ;
	while( list( $label , $count ) = $db->fetchRow( $result ) ) {
		$tags[ $label ] = array( 
			'label' => $label ,
			'count' => $count ,
			'rank' => $rank ++ ,
		) ;
	}
	//ksort( $tags , SORT_STRING ) ;
	$tags4assign = array_values( $tags ) ;

	// module config
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($mydirname);
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	// constpref
	$constpref = '_MB_' . strtoupper( $mydirname ) ;

	// make an array named 'block'
	$block = array( 
		'mytrustdirname' => $mytrustdirname ,
		'mydirname' => $mydirname ,
		'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
		'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$configs['images_dir'] ,
		'mod_config' => $configs ,
		'limit' => $limit ,
		'listorder' => $listorder ,
		'sqlorder' => $sqlorder ,
		'tagsnum' => sizeof( $tags4assign ) ,
		'tags' => $tags4assign ,
	) ;

	if( empty( $options['disable_renderer'] ) ) {
		// render it
		require_once XOOPS_ROOT_PATH.'/class/template.php' ;
		$tpl =& new XoopsTpl() ;
		$tpl->assign( 'block' , $block ) ;
		$ret['content'] = $tpl->fetch( $this_template ) ;
		return $ret ;
	} else {
		// just assign it
		return $block ;
	}
}



function b_pico_tags_edit( $options )
{
	// options
	$mytrustdirname = basename(dirname(dirname(__FILE__))) ;
	$mydirname = empty( $options[0] ) ? $mytrustdirname : $options[0] ;
	$limit = empty( $options[1] ) ? 10 : intval( $options[1] ) ;
	$listorder = 'label' ;
	$sqlorder = 'count' ;
	$this_template = empty( $options[4] ) ? 'db:'.$mydirname.'_block_tags.html' : trim( $options[4] ) ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$tpl =& new XoopsTpl() ;
	$tpl->assign( array(
		'mydirname' => $mydirname ,
		'limit' => $limit ,
		'listorder' => $listorder ,
		'sqlorder' => $sqlorder ,
		'this_template' => $this_template ,
	) ) ;
	return $tpl->fetch( 'db:'.$mydirname.'_blockedit_tags.html' ) ;
}

?>