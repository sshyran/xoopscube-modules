<?php

include dirname(dirname(__FILE__)).'/include/common_prepend.inc.php' ;

// get content_id
$content_id = intval( @$_GET['content_id'] ) ;

if( empty( $content_id ) ) {
	// parse path_info
	if( $xoopsModuleConfig['use_wraps_mode'] ) list( $content_id , $cat_id , $pico_path_info ) = pico_main_parse_path_info( $mydirname ) ;
	// category view
	if( empty( $cat_id ) ) $cat_id = intval( @$_GET['cat_id'] ) ;
} else {
	// get $cat_id from $content_id
	$cat_id = pico_main_get_cat_id_from_content_id( $mydirname , $content_id ) ;
}

// check,fetch and assign the category (set $content_id if necessary)
require dirname(dirname(__FILE__)).'/include/process_this_category.inc.php' ;

// get $subcategories
require dirname(dirname(__FILE__)).'/include/listsubcategories.inc.php' ;

// make xoops_breadcrumbs
$parents = is_array( @$category4assign['paths_raw'] ) ? $category4assign['paths_raw'] : array() ;
foreach( $parents as $cat_id_tmp => $name_raw ) {
	$xoops_breadcrumbs[] = array(
		'url' => XOOPS_URL.'/modules/'.$mydirname.'/'.pico_common_make_category_link4html( $xoopsModuleConfig , $cat_id_tmp , $mydirname ) ,
		'name' => htmlspecialchars( $name_raw , ENT_QUOTES ) ,
	) ;
}

if( empty( $content_id ) ) {
	if( ! empty( $pico_path_info ) ) {
		// HTML wrapping without DB
		$xoopsOption['template_main'] = $mydirname.'_main_viewcontent.html' ;
		include XOOPS_ROOT_PATH.'/header.php';
		$content4assign = pico_main_read_wrapped_file( $mydirname , $pico_path_info ) ;
		$pagetitle4assign = $content4assign['subject'] ;
	} else if( @$_GET['page'] == 'rss' ) {
		// latest contents for rss
		$xoopsOption['template_main'] = $mydirname.'_independent_rss20.html' ;
		include XOOPS_ROOT_PATH.'/header.php';
		require dirname(dirname(__FILE__)).'/include/rss.inc.php' ;
		$pagetitle4assign = htmlspecialchars($xoopsModule->getVar('name','n'),ENT_QUOTES) ;
	} else if( empty( $cat_id ) && @$_GET['cat_id'] !== "0" && @$xoopsModuleConfig['show_menuinmoduletop'] || @$_GET['page'] == 'menu' ) {
		// auto-made menu
		$xoopsOption['template_main'] = $mydirname.'_main_menu.html' ;
		include XOOPS_ROOT_PATH.'/header.php';
		require dirname(dirname(__FILE__)).'/include/menu.inc.php' ;
		$pagetitle4assign = @$_GET['page'] == 'menu' ? _MD_PICO_MENU : $xoopsModule->getVar('name') ;
		if( @$_GET['page'] == 'menu' ) $xoops_breadcrumbs[] = array( 'name' => _MD_PICO_MENU ) ;
	} else if( ! @$xoopsModuleConfig['show_listasindex'] ) {
		// redirect to the top of the content
		$content_id = pico_main_get_top_content_id_from_cat_id( $mydirname , $cat_id ) ;
		if( $content_id ) {
			$redirect_uri = XOOPS_URL.'/modules/'.$mydirname.'/'.pico_common_make_content_link4html( $xoopsModuleConfig , $content_id , $mydirname ) ;
			if( headers_sent() ) {
				redirect_header( $redirect_uri , 0 , '&nbsp;' ) ;
			} else {
				header( 'Location: '.$redirect_uri ) ;
			}
		}
	}
	if( empty( $xoopsOption['template_main'] ) ) {
		// list contents of the category
		$xoopsOption['template_main'] = $mydirname.'_main_listcontents.html' ;
		include XOOPS_ROOT_PATH.'/header.php';
		require dirname(dirname(__FILE__)).'/include/listcontents.inc.php' ;
		$pagetitle4assign = $category4assign['title'] ;
		unset( $xoops_breadcrumbs[ sizeof( $xoops_breadcrumbs ) - 1 ]['url'] ) ;
	}
}

if( empty( $xoopsOption['template_main'] ) ) {
	// display the content with detail
	$xoopsOption['template_main'] = $mydirname.'_main_viewcontent.html' ;
	include XOOPS_ROOT_PATH.'/header.php';
	require dirname(dirname(__FILE__)).'/include/process_this_content.inc.php' ;
	$pagetitle4assign = $content4assign['subject'] ;
	$xoops_breadcrumbs[] = array( 'name' => $content4assign['subject'] ) ;
	// count up 'viewed'
	$db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET viewed=viewed+1 WHERE content_id='$content_id' AND modifier_ip<>'".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."'" ) ;
}


// assign
$xoopsTpl->assign(
	array(
		'mydirname' => $mydirname ,
		'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
		'mod_imageurl' => XOOPS_URL.'/modules/'.$mydirname.'/'.$xoopsModuleConfig['images_dir'] ,
		'xoops_config' => $xoopsConfig ,
		'mod_config' => $xoopsModuleConfig ,
		'uid' => $uid ,
		'category' => @$category4assign ,
		'categories' => @$categories4assign ,
		'subcategories' => @$subcategories4assign ,
		'contents' => @$contents4assign ,
		'content' => @$content4assign ,
		'next_content' => @$next_content4assign ,
		'prev_content' => @$prev_content4assign ,
		'cat_jumpbox_options' => pico_main_make_cat_jumpbox_options( $mydirname , $whr_read4cat , @$content_row['cat_id'] ) ,
		'xoops_breadcrumbs' => @$xoops_breadcrumbs ,
		'xoops_pagetitle' => @$pagetitle4assign ,
		'xoops_module_header' => pico_main_render_moduleheader( $mydirname , $xoopsModuleConfig , @$content4assign['htmlheader'] ) . $xoopsTpl->get_template_vars( "xoops_module_header" ) ,
	)
) ;

if( @$_GET['page'] == 'print' ) {
	// for printer
	$xoopsTpl->display( 'db:'.$mydirname.'_independent_print.html' ) ;
} else if( @$_GET['page'] == 'singlecontent' ) {
	// just display as a singlecontent
	$xoopsTpl->display( 'db:'.$mydirname.'_independent_singlecontent.html' ) ;
} else if( @$_GET['page'] == 'rss' && is_array( @$contents4assign ) ) {
	// RSS 2.0
	if( function_exists( 'mb_http_output' ) ) mb_http_output( 'pass' ) ;
	$data = $xoopsTpl->get_template_vars() ;
	pico_common_utf8_encode_recursive( $data ) ;
	$xoopsTpl->assign( $data ) ;
	header( 'Content-Type:text/xml; charset=utf-8' ) ;
	$xoopsTpl->display( 'db:'.$mydirname.'_independent_rss20.html' ) ;
} else {
	// for monitor
	include XOOPS_ROOT_PATH.'/footer.php';
}

?>