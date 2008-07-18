<?php

// this file can be included from transaction procedures

// delete a content
function pico_delete_content( $mydirname , $content_id )
{
	$db =& Database::getInstance() ;

	// backup the content, first
	pico_transact_backupcontent( $mydirname , $content_id , true ) ;

	// delete content
	if( ! $db->query( "DELETE FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".intval($content_id) ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return true ;
}


// delete a category
function pico_delete_category( $mydirname , $cat_id , $delete_also_contents = true )
{
	global $xoopsModule ;

	$db =& Database::getInstance() ;

	$cat_id = intval( $cat_id ) ;
	if( $cat_id <= 0 ) return false ;

	// delete contents
	if( $delete_also_contents ) {
		$sql = "SELECT content_id FROM ".$db->prefix($mydirname."_contents")." WHERE cat_id=$cat_id" ;
		if( ! $result = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
		while( list( $content_id ) = $db->fetchRow( $result ) ) {
			pico_delete_content( $mydirname , $content_id ) ;
		}
	}

	// delete notifications about this category
	$notification_handler =& xoops_gethandler( 'notification' ) ;
	$notification_handler->unsubscribeByItem( $xoopsModule->getVar( 'mid' ) , 'category' , $cat_id ) ;

	// delete category
	if( ! $db->query( "DELETE FROM ".$db->prefix($mydirname."_categories")." WHERE cat_id=$cat_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

	// delete category_permissions
	if( ! $db->query( "DELETE FROM ".$db->prefix($mydirname."_category_permissions")." WHERE cat_id=$cat_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return true ;
}


// store tree informations of categories
function pico_sync_cattree( $mydirname )
{
	$db =& Database::getInstance() ;

	// rebuild tree informations
	list( $tree_array , $subcattree , $contents_total , $subcategories_total ) = pico_makecattree_recursive( $mydirname , 0 ) ;
	//array_shift( $tree_array ) ;
	$paths = array() ;
	$previous_depth = 0 ;

	if( ! empty( $tree_array ) ) foreach( $tree_array as $key => $val ) {
		// build the absolute path of the category
		$depth_diff = $val['depth'] - $previous_depth ;
		$previous_depth = $val['depth'] ;
		if( $depth_diff > 0 ) {
			for( $i = 0 ; $i < $depth_diff ; $i ++ ) {
				$paths[ $val['cat_id'] ] = $val['cat_title'] ;
			}
		} else if( $val['cat_id'] !== 0 ) {
			for( $i = 0 ; $i < - $depth_diff + 1 ; $i ++ ) {
				array_pop( $paths ) ;
			}
			$paths[ $val['cat_id'] ] = $val['cat_title'] ;
		}

		// redundant array
		$redundants = array(
			'cat_id' => $val['cat_id'] ,
			'depth' => $val['depth'] ,
			'cat_title' => $val['cat_title'] ,
			'contents_count' => $val['contents_count'] ,
			'contents_total' => $val['contents_total'] ,
			'subcategories_count' => $val['subcategories_count'] ,
			'subcategories_total' => $val['subcategories_total'] ,
			'subcattree_raw' => $val['subcattree_raw'] ,
		) ;

		$db->queryF( "UPDATE ".$db->prefix($mydirname."_categories")." SET cat_depth_in_tree=".intval($val['depth']).", cat_order_in_tree=".($key).", cat_path_in_tree='".mysql_real_escape_string(serialize($paths))."', cat_redundants='".mysql_real_escape_string(serialize($redundants))."' WHERE cat_id=".$val['cat_id'] ) ;
	}
}


function pico_makecattree_recursive( $mydirname , $cat_id , $order = 'cat_weight' , $parray = array() , $depth = 0 , $cat_title = '' )
{
	$db =& Database::getInstance() ;

	// get number of contents of this category
	list( $contents_count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_contents")." WHERE cat_id=$cat_id AND visible" ) ) ;

	$sql = "SELECT cat_id,cat_title FROM ".$db->prefix($mydirname."_categories")." WHERE pid=$cat_id ORDER BY $order" ;
	$result = $db->query( $sql ) ;
/*	if( $db->getRowsNum( $result ) == 0 ) {
		return array( $parray , $parray[ $myindex ]['contents_total'] , $parray[ $myindex ]['subcategories_total'] ) ;
	} */
	$myindex = sizeof( $parray ) ;
	$myarray = array( 'cat_id' => $cat_id , 'depth' => $depth , 'cat_title' => $cat_title , 'contents_count' => intval( $contents_count ) , 'contents_total' => 0 , 'subcategories_count' => $db->getRowsNum( $result ) , 'subcategories_total' => 0 , 'subcattree_raw' => array() ) ;
	$parray[ $myindex ] = $myarray ;
//	$parray[ $myindex ]['subcattree_raw'][] = $parray ;

	$contents_total = intval( $myarray['contents_count'] ) ;
	$subcategories_total = intval( $myarray['subcategories_count'] ) ;

	while( list( $new_cat_id , $new_cat_title ) = $db->fetchRow( $result ) ) {
		list( $parray , $subarray , $contents_smallsum , $subcategories_smallsum ) = pico_makecattree_recursive( $mydirname , $new_cat_id , $order , $parray , $depth + 1 , $new_cat_title ) ;
		$myarray['subcattree_raw'][] = $subarray ;
		$contents_total += $contents_smallsum ;
		$subcategories_total += $subcategories_smallsum ;
	}

	$parray[ $myindex ]['contents_total'] = $contents_total ;
	$myarray['contents_total'] = $contents_total ;
	$parray[ $myindex ]['subcategories_total'] = $subcategories_total ;
	$myarray['subcategories_total'] = $subcategories_total ;

	$parray[ $myindex ]['subcattree_raw'] = $myarray['subcattree_raw'] ;

	return array( $parray , $myarray , $parray[ $myindex ]['contents_total'] , $parray[ $myindex ]['subcategories_total'] ) ;
}


// store redundant informations to a content from its content_votes
function pico_sync_content_votes( $mydirname , $content_id )
{
	$db =& Database::getInstance() ;

	$content_id = intval( $content_id ) ;

	$sql = "SELECT cat_id FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=$content_id" ;
	if( ! $result = $db->query( $sql ) ) die( "ERROR SELECT content in sync content_votes" ) ;
	list( $cat_id ) = $db->fetchRow( $result ) ;

	$sql = "SELECT COUNT(*),SUM(vote_point) FROM ".$db->prefix($mydirname."_content_votes")." WHERE content_id=$content_id" ;
	if( ! $result = $db->query( $sql ) ) die( "ERROR SELECT content_votes in sync content_votes" ) ;
	list( $votes_count , $votes_sum ) = $db->fetchRow( $result ) ;

	if( ! $db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET votes_count=".intval($votes_count).",votes_sum=".intval($votes_sum)." WHERE content_id=$content_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

	return true ;
}


// sync content_votes and category's tree
function pico_sync_all( $mydirname )
{
	$db =& Database::getInstance() ;

	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($mydirname);
	$config_handler =& xoops_gethandler('config');
	$configs = $config_handler->getConfigList( $module->mid() ) ;

	// sync contents <- content_votes
	$result = $db->query( "SELECT content_id FROM ".$db->prefix($mydirname."_contents") ) ;
	while( list( $content_id ) = $db->fetchRow( $result ) ) {
		pico_sync_content_votes( $mydirname , intval( $content_id ) ) ;
	}

	// d3forum comment integration
	if( ! empty( $configs['comment_dirname'] ) && $configs['comment_forum_id'] > 0 ) {
		$target_module =& $module_handler->getByDirname($configs['comment_dirname']);
		if( is_object( $target_module ) ) {
			$target_dirname = $target_module->getVar('dirname') ;
			$forum_id = intval( $configs['comment_forum_id'] ) ;
			$result = $db->query( "SELECT topic_external_link_id,COUNT(*) FROM ".$db->prefix($target_dirname."_topics")." WHERE topic_external_link_id>0 AND forum_id=$forum_id AND ! topic_invisible GROUP BY topic_external_link_id" ) ;
			while( list( $content_id , $comments_count ) = $db->fetchRow( $result ) ) {
				$db->query( "UPDATE ".$db->prefix($mydirname."_contents")." SET comments_count=$comments_count WHERE content_id=$content_id" ) ;
			}
		}
	}

	// fix null and '' confusion
	$db->queryF( "UPDATE ".$db->prefix($mydirname."_categories")." SET cat_vpath=null WHERE cat_vpath=''" ) ;
	$db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET vpath=null WHERE vpath=''" ) ;

	// sync category's tree
	pico_sync_cattree( $mydirname ) ;
}


// get requests for category's sql (parse options)
function pico_get_requests4category( $mydirname , $cat_id = null )
{
	$myts =& MyTextSanitizer::getInstance() ;
	$db =& Database::getInstance() ;

	include dirname(dirname(__FILE__)).'/include/configs_can_override.inc.php' ;
	$cat_options = array() ;
	foreach( $GLOBALS['xoopsModuleConfig'] as $key => $val ) {
		if( empty( $pico_configs_can_be_override[ $key ] ) ) continue ;
		foreach( explode( "\n" , @$_POST['cat_options'] ) as $line ) {
			if( preg_match( '/^'.$key.'\:(.{1,100})$/' , $line , $regs ) ) {
				switch( $pico_configs_can_be_override[ $key ] ) {
					case 'text' :
						$cat_options[ $key ] = trim( $regs[1] ) ;
						break ;
					case 'int' :
						$cat_options[ $key ] = intval( $regs[1] ) ;
						break ;
					case 'bool' :
						$cat_options[ $key ] = intval( $regs[1] ) > 0 ? 1 : 0 ;
						break ;
				}
			}
		}
	}

	if( $cat_id === 0 ) {
		// top category
		$cat_vpath = null ;
		$pid = 0xffff ;
	} else {
		// normal category
		$cat_vpath = trim( $myts->stripSlashesGPC( @$_POST['cat_vpath'] ) ) ;
		$pid = intval( @$_POST['pid'] ) ;
		// check $pid
		if( $pid ) {
			$sql = "SELECT * FROM ".$db->prefix($mydirname."_categories")." c WHERE c.cat_id=$pid" ;
			if( ! $crs = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
			if( $db->getRowsNum( $crs ) <= 0 ) die( _MD_PICO_ERR_READCATEGORY ) ;
		}
	}

	return array( 
		'cat_title' => $myts->stripSlashesGPC( @$_POST['cat_title'] ) ,
		'cat_desc' => $myts->stripSlashesGPC( @$_POST['cat_desc'] ) ,
		'cat_weight' => intval( @$_POST['cat_weight'] ) ,
		'cat_vpath' => $cat_vpath ,
		'pid' => $pid ,
		'cat_options' => serialize( $cat_options ) ,
	) ;
}


// create a category
function pico_makecategory( $mydirname )
{
	$db =& Database::getInstance() ;

	$requests = pico_get_requests4category( $mydirname ) ;
	$set = '' ;
	foreach( $requests as $key => $val ) {
		if( $key == 'cat_vpath' && empty( $val ) ) {
			$set .= "`$key`=null," ;
		} else {
			$set .= "`$key`='".mysql_real_escape_string( $val )."'," ;
		}
	}

	list( $new_cat_id ) = $db->fetchRow( $db->query( "SELECT MAX(cat_id)+1 FROM ".$db->prefix($mydirname."_categories") ) ) ;
	if( ! $db->query( "INSERT INTO ".$db->prefix($mydirname."_categories")." SET $set `cat_path_in_tree`='',`cat_unique_path`='',cat_id=$new_cat_id" ) ) die( _MD_PICO_ERR_DUPLICATEDVPATH . ' or ' . _MD_PICO_ERR_SQL.__LINE__ ) ;

	// permissions are set same as the parent category. (also moderator)
	$sql = "SELECT uid,groupid,permissions FROM ".$db->prefix($mydirname."_category_permissions")." WHERE cat_id={$requests['pid']}" ;
	if( ! $result = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
	while( $row = $db->fetchArray( $result ) ) {
		$uid4sql = empty( $row['uid'] ) ? 'null' : intval( $row['uid'] ) ;
		$groupid4sql = empty( $row['groupid'] ) ? 'null' : intval( $row['groupid'] ) ;
		$sql = "INSERT INTO ".$db->prefix($mydirname."_category_permissions")." (cat_id,uid,groupid,permissions) VALUES ($new_cat_id,$uid4sql,$groupid4sql,'".mysql_real_escape_string($row['permissions'])."')" ;
		if( ! $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
	}

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return $new_cat_id ;
}


// update category
function pico_updatecategory( $mydirname , $cat_id )
{
	$db =& Database::getInstance() ;

	$requests = pico_get_requests4category( $mydirname , $cat_id ) ;
	$set = '' ;
	foreach( $requests as $key => $val ) {
		if( $key == 'cat_vpath' && empty( $val ) ) {
			$set .= "`$key`=null," ;
		} else {
			$set .= "`$key`='".mysql_real_escape_string( $val )."'," ;
		}
	}

	// get children
	include_once XOOPS_ROOT_PATH."/class/xoopstree.php" ;
	$mytree = new XoopsTree( $db->prefix($mydirname."_categories") , "cat_id" , "pid" ) ;
	$children = $mytree->getAllChildId( $cat_id ) ;
	$children[] = $cat_id ;

	// loop check
	if( in_array( $requests['pid'] , $children ) ) die( _MD_PICO_ERR_PIDLOOP ) ;

	if( ! $db->query( "UPDATE ".$db->prefix($mydirname."_categories")." SET ".substr($set,0,-1)." WHERE cat_id=$cat_id" ) ) die( _MD_PICO_ERR_DUPLICATEDVPATH ) ;

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return $cat_id ;
}


// get requests for content's sql (parse options)
function pico_get_requests4content( $mydirname , &$errors , $auto_approval = true , $isadminormod = false , $content_id = 0 )
{
	global $xoopsUser ;

	$myts =& MyTextSanitizer::getInstance() ;
	$db =& Database::getInstance() ;

	// get config
	$module_handler =& xoops_gethandler('module') ;
	$module =& $module_handler->getByDirname( $mydirname ) ;
	if( ! is_object( $module ) ) return array() ;
	$config_handler =& xoops_gethandler('config') ;
	$mod_config =& $config_handler->getConfigsByCat( 0 , $module->getVar('mid') ) ;

	// check $cat_id
	$cat_id = intval( @$_POST['cat_id'] ) ;
	if( $cat_id ) {
		$sql = "SELECT * FROM ".$db->prefix($mydirname."_categories")." c WHERE c.cat_id=$cat_id" ;
		if( ! $crs = $db->query( $sql ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
		if( $db->getRowsNum( $crs ) <= 0 ) die( _MD_PICO_ERR_READCATEGORY ) ;
	}

	// build filters
	$filters = array() ;
	foreach( $_POST as $key => $val ) {
		if( substr( $key , 0 , 15 ) == 'filter_enabled_' && $val ) {
			$name = str_replace( '..' , '' , substr( $key , 15 ) ) ;
			$constpref = '_MD_PICO_FILTERS_' . strtoupper( $name ) ;
			$filter_file = dirname(dirname(__FILE__)).'/filters/pico_'.$name.'.php' ;
			if( ! file_exists( $filter_file ) ) continue ;
			require_once $filter_file ;
			if( ! $isadminormod && defined( $constpref.'ISINSECURE' ) ) continue ;			$filters[ $name ] = intval( @$_POST['filter_weight_'.$name] ) ;
		}
	}
	asort( $filters ) ;

	// forced filters
	$filters_forced = array_map( 'trim' , explode( ',' , $mod_config['filters_forced'] ) ) ;
	foreach( $filters_forced as $filter_forced ) {
		$regs = explode( ':' , $filter_forced ) ;
		if( stristr( $filter_forced , ':LAST' ) ) {
			$filters[ $regs[0] ] = 0 ;
		} else {
			$filters = array( $regs[0] => 0 ) + $filters ;
		}
	}

	// prohibited filters
	$filters_prohibited = array_map( 'trim' , explode( ',' , $mod_config['filters_prohibited'] ) ) ;
	foreach( $filters_prohibited as $filter_prohibited ) {
		unset( $filters[ $filter_prohibited ] ) ;
	}

	$ret = array( 
		'cat_id' => $cat_id ,
		'vpath' => trim( $myts->stripSlashesGPC( @$_POST['vpath'] ) ) ,
		'subject' => $myts->stripSlashesGPC( @$_POST['subject'] ) ,
		'htmlheader' => $myts->stripSlashesGPC( @$_POST['htmlheader'] ) ,
		'body' => $myts->stripSlashesGPC( @$_POST['body'] ) ,
		'filters' => implode( '|' , array_keys( $filters ) ) ,
		'weight' => intval( @$_POST['weight'] ) ,
		'use_cache' => empty( $_POST['use_cache'] ) ? 0 : 1 ,
		'show_in_navi' => empty( $_POST['show_in_navi'] ) ? 0 : 1 ,
		'show_in_menu' => empty( $_POST['show_in_menu'] ) ? 0 : 1 ,
		'allow_comment' => empty( $_POST['allow_comment'] ) ? 0 : 1 ,
	) ;

	// vpath duplication check
	if( $ret['vpath'] ) while( 1 ) {
		list( $count ) = $db->fetchRow( $db->query( "SELECT COUNT(*) FROM ".$db->prefix($mydirname."_contents")." WHERE vpath='".mysql_real_escape_string($ret['vpath'])."' AND content_id<>".intval($content_id) ) ) ;
		if( empty( $count ) ) break ;
		$ext = strrchr( $ret['vpath'] , '.' ) ;
		if( $ext ) $ret['vpath'] = str_replace( $ext , '.1'.$ext , $ret['vpath'] ) ;
		else $ret['vpath'] .= '.1' ;
		$errors[] = _MD_PICO_ERR_DUPLICATEDVPATH ;
	}

	// approval
	if( $auto_approval ) {
		$ret += array(
			'subject_waiting' => '' ,
			'htmlheader_waiting' => '' ,
			'body_waiting' => '' ,
			'visible' => empty( $_POST['visible'] ) ? 0 : 1 ,
			'approval' => 1 ,
		) ;
	} else {
		$ret += array(
			'subject_waiting' => $myts->stripSlashesGPC( @$_POST['subject'] ) ,
			'htmlheader_waiting' => $myts->stripSlashesGPC( @$_POST['htmlheader'] ) ,
			'body_waiting' => $myts->stripSlashesGPC( @$_POST['body'] ) ,
			'visible' => 0 ,
			'approval' => 0 ,
		) ;
	}

	// created_time,modified_time,poster_uid,modifier_uid,locked
	if( $isadminormod ) {
		$ret['specify_created_time'] = empty( $_POST['specify_created_time'] ) ? 0 : 1 ;
		$ret['specify_modified_time'] = empty( $_POST['specify_modified_time'] ) ? 0 : 1 ;
		if( $ret['specify_created_time'] && strtotime( @$_POST['created_time'] ) != -1 ) {
			$created_time_safe = preg_replace( '#[^0-9a-zA-Z:+/-]#' , '' , $_POST['created_time'] ) ;
			$ret['created_time_formatted'] = $created_time_safe ;
			$ret['created_time'] = pico_common_get_server_timestamp( strtotime( $_POST['created_time'] ) ) ;
		}
		if( $ret['specify_modified_time'] && strtotime( @$_POST['modified_time'] ) != -1 ) {
			$modified_time_safe = preg_replace( '#[^0-9a-zA-Z:+/-]#' , '' , $_POST['modified_time'] ) ;
			$ret['modified_time_formatted'] = $modified_time_safe ;
			$ret['modified_time'] = pico_common_get_server_timestamp( strtotime( $_POST['modified_time'] ) ) ;
		}
		$ret['locked'] = empty( $_POST['locked'] ) ? 0 : 1 ;
		if( ! empty( $_POST['poster_uid'] ) ) $ret['poster_uid'] = pico_main_get_uid( $_POST['poster_uid'] ) ;
		if( ! empty( $_POST['modifier_uid'] ) ) $ret['modifier_uid'] = pico_main_get_uid( $_POST['modifier_uid'] ) ;
	}

	// HTML Purifier in Protector (only for PHP5)
	//'htmlpurify_except' ,
	if( substr( PHP_VERSION , 0 , 1 ) != 4 && file_exists( XOOPS_TRUST_PATH.'/modules/protector/library/HTMLPurifier.auto.php' ) ) {
		if( is_object( $xoopsUser ) ) {
			$purifier_enable = sizeof( array_intersect( $xoopsUser->getGroups() , @$mod_config['htmlpurify_except'] ) ) == 0 ;
		} else {
			$purifier_enable = true ;
		}
		$purifier_enable = $purifier_enable && ! isset( $filters['htmlspecialchars'] ) ;
		if( $purifier_enable ) {
			require_once XOOPS_TRUST_PATH.'/modules/protector/library/HTMLPurifier.auto.php' ;
			$config = HTMLPurifier_Config::createDefault();
			$config->set('Cache', 'SerializerPath', XOOPS_TRUST_PATH.'/modules/protector/configs');
			$config->set('Core', 'Encoding', _CHARSET);
			//$config->set('HTML', 'Doctype', 'HTML 4.01 Transitional');
			$purifier = new HTMLPurifier($config);
			$ret['body'] = $purifier->purify( $ret['body'] ) ;
		}
	}

	return $ret ;
}


// get uid from free form (numeric=uid, not numeric=uname)
function pico_main_get_uid( $text )
{
	$user_handler =& xoops_gethandler( 'user' ) ;

	$text = trim( $text ) ;
	if( is_numeric( $text ) ) {
		$uid = intval( $text ) ;
		$user =& $user_handler->get( $uid ) ;
		if( is_object( $user ) ) return $uid ;
		else return '' ;
	} else {
		$users =& $user_handler->getObjects( new Criteria( 'uname' , addslashes( $text ) ) ) ; // ???
		if( is_object( @$users[0] ) ) return $users[0]->getVar('uid') ;
		else return '' ;
	}
}


// create content
function pico_makecontent( $mydirname , $auto_approval = true , $isadminormod = false )
{
	global $xoopsUser ;

	$db =& Database::getInstance() ;
	$uid = is_object( $xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;

	$requests = pico_get_requests4content( $mydirname , $errors = array() , $auto_approval , $isadminormod ) ;
	$requests += array( 'poster_uid' => $uid , 'modifier_uid' => $uid ) ;
	unset( $requests['specify_created_time'] , $requests['specify_modified_time'] , $requests['created_time_formatted'] , $requests['modified_time_formatted'] ) ;
	$ignore_requests = $auto_approval ? array() : array( 'subject' , 'htmlheader' , 'body' , 'visible' ) ;
	// only adminormod can set htmlheader
	if( ! $isadminormod ) {
		$requests['htmlheader_waiting'] = $requests['htmlheader'] ;
		$ignore_requests[] = 'htmlheader' ;
	}
	$set = $auto_approval ? '' : "visible=0,subject='"._MD_PICO_WAITINGREGISTER."',htmlheader='',body=''," ;
	foreach( $requests as $key => $val ) {
		if( in_array( $key , $ignore_requests ) ) continue ;
		if( $key == 'vpath' && empty( $val ) ) {
			$set .= "`$key`=null," ;
		} else {
			$set .= "`$key`='".mysql_real_escape_string( $val )."'," ;
		}
	}

	// some patches about times
	$time4sql = '' ;
	if( empty( $requests['created_time'] ) ) $time4sql .= "created_time=UNIX_TIMESTAMP()," ;
	if( empty( $requests['modified_time'] ) ) $time4sql .= "modified_time=UNIX_TIMESTAMP()," ;

	// do insert
	$sql = "INSERT INTO ".$db->prefix($mydirname."_contents")." SET $set $time4sql poster_ip='".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."',modifier_ip='".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."',body_cached=''" ;
	if( ! $db->query( $sql ) ) die( _MD_PICO_ERR_DUPLICATEDVPATH . ' or ' . _MD_PICO_ERR_SQL.__LINE__ ) ;
	$new_content_id = $db->getInsertId() ;
	pico_transact_reset_body_cached( $mydirname , $new_content_id ) ;

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return $new_content_id ;
}


// update content
function pico_updatecontent( $mydirname , $content_id , $auto_approval = true , $isadminormod )
{
	global $xoopsUser ;

	$db =& Database::getInstance() ;

	$requests = pico_get_requests4content( $mydirname , $errors = array() , $auto_approval , $isadminormod , $content_id ) ;
	unset( $requests['specify_created_time'] , $requests['specify_modified_time'] , $requests['created_time_formatted'] , $requests['modified_time_formatted'] ) ;
	$ignore_requests = $auto_approval ? array() : array( 'subject' , 'htmlheader' , 'body' , 'visible' , 'filters' , 'show_in_navi' , 'show_in_menu' , 'allow_comment' , 'use_cache' , 'weight' , 'cat_id' ) ;
	if( ! $isadminormod ) {
		// only adminormod can set htmlheader
		$requests['htmlheader_waiting'] = $requests['htmlheader'] ;
		$ignore_requests[] = 'htmlheader' ;
	}
	$set = '' ;
	foreach( $requests as $key => $val ) {
		if( in_array( $key , $ignore_requests ) ) continue ;
		if( $key == 'vpath' && empty( $val ) ) {
			$set .= "`$key`=null," ;
		} else {
			$set .= "`$key`='".mysql_real_escape_string( $val )."'," ;
		}
	}

	// some patches about times
	$time4sql = '' ;
	if( empty( $requests['modified_time'] ) ) $time4sql .= "modified_time=UNIX_TIMESTAMP()," ;

	// backup the content, first
	pico_transact_backupcontent( $mydirname , $content_id ) ;

	// do update
	$uid = is_object( $xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
	$sql = "UPDATE ".$db->prefix($mydirname."_contents")." SET modifier_uid='$uid', $set $time4sql modifier_ip='".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."',body_cached='' WHERE content_id=$content_id" ;
	if( ! $db->query( $sql ) ) die( _MD_PICO_ERR_DUPLICATEDVPATH . ' or ' . _MD_PICO_ERR_SQL.__LINE__ ) ;
	pico_transact_reset_body_cached( $mydirname , $content_id ) ;

	// rebuild category tree
	pico_sync_cattree( $mydirname ) ;

	return $content_id ;
}


// sync body_cached as body (HTML tags are stripped) for searching
function pico_transact_reset_body_cached( $mydirname , $content_id )
{
	$db =& Database::getInstance() ;
	list( $use_cache , $body ) = $db->fetchRow( $db->query( "SELECT use_cache,body FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=$content_id" ) ) ;
	if( empty( $body ) ) return ;
	$body4sql = $use_cache ? '' : mysql_real_escape_string( strip_tags( $body ) ) ;
	$db->query( "UPDATE ".$db->prefix($mydirname."_contents")." SET body_cached='$body4sql' WHERE content_id=$content_id" ) ;
}


// register a file of "wraps/dirname/$path" into contents table automatically
function pico_auto_register_wrapped_file( $mydirname , $path , $cat_id = 0 )
{
	$db =& Database::getInstance() ;

	$file_info = pico_main_read_wrapped_file( $mydirname , $path ) ;
	$cat_id = intval( $cat_id ) ;

	$content_row = $db->fetchArray( $db->query( "SELECT content_id,cat_id,modified_time FROM ".$db->prefix($mydirname."_contents")." WHERE `vpath`='".mysql_real_escape_string($path)."'" ) ) ;
	if( empty( $content_row ) ) {
		// insert a new record into the category
		list( $weight ) = $db->fetchRow( $db->query( "SELECT MAX(weight) FROM ".$db->prefix($mydirname."_contents")." WHERE `cat_id`=$cat_id" ) ) ;
	
		if( ! $db->queryF( "INSERT INTO ".$db->prefix($mydirname."_contents")." SET `cat_id`=$cat_id,`vpath`='".mysql_real_escape_string($path)."',`subject`='".mysql_real_escape_string($file_info['subject'])."',`body`='',`created_time`={$file_info['created_time']},`modified_time`={$file_info['created_time']},poster_uid=0,modifier_uid=0,poster_ip='',modifier_ip='',use_cache=1,weight=".($weight+1).",filters='wraps',show_in_navi=1,show_in_menu=1,allow_comment=0,visible=1,approval=1,htmlheader='',htmlheader_waiting='',body_waiting='',body_cached=''" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
		$content_id = $db->getInsertId() ;

		// rebuild category tree
		pico_sync_cattree( $mydirname ) ;
	} else if( $content_row['modified_time'] < $file_info['created_time'] ) {
		// clear body_cache
		$content_id = intval( $content_row['content_id'] ) ;
		if( ! $db->queryF( "UPDATE ".$db->prefix($mydirname."_contents")." SET `modified_time`={$file_info['created_time']},body_cached='' WHERE content_id=$content_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
	} else {
		$content_id = 0 ;
	}

	return $content_id ;
}


// register files under "wraps/dirname/$cat_vpath" automatically
function pico_auto_register_from_cat_vpath( $mydirname , $category_row )
{
	$db =& Database::getInstance() ;

	if( ord( @$category_row['cat_vpath'] ) == 0x2f ) {
		$wrap_dir = XOOPS_TRUST_PATH._MD_PICO_WRAPBASE.'/'.$mydirname.str_replace('..','',$category_row['cat_vpath']) ;
		if( is_dir( $wrap_dir ) && filemtime( $wrap_dir ) > $category_row['cat_vpath_mtime'] ) {
			$dh = opendir( $wrap_dir ) ;
			$files = array() ;
			while( ( $file = readdir( $dh ) ) !== false ) {
				if( preg_match( _MD_PICO_AUTOREGIST4PREGEX , $file ) ) {
					$files[] = $file ;
				}
			}
			closedir( $dh ) ;

			sort( $files ) ;
			foreach( $files as $file ) {
				pico_auto_register_wrapped_file( $mydirname , $category_row['cat_vpath'].'/'.$file , intval( $category_row['cat_id'] ) ) ;
			}

			if( ! $db->queryF( "UPDATE ".$db->prefix($mydirname."_categories")." SET `cat_vpath_mtime`=UNIX_TIMESTAMP() WHERE cat_id=".intval($category_row['cat_id']) ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
		}
	}
}


// copy from waiting fields
function pico_transact_copyfromwaitingcontent( $mydirname , $content_id )
{
	global $xoopsUser ;

	$db =& Database::getInstance() ;

	// backup the content, first
	pico_transact_backupcontent( $mydirname , $content_id ) ;

	$uid = is_object( $xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
	if( ! $db->query( "UPDATE ".$db->prefix($mydirname."_contents")." SET body=body_waiting, subject=subject_waiting, htmlheader=htmlheader_waiting, visible=1, approval=1 WHERE content_id=$content_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
	if( ! $db->query( "UPDATE ".$db->prefix($mydirname."_contents")." SET body_waiting='',subject_waiting='',htmlheader_waiting='' /*,`modified_time`=UNIX_TIMESTAMP(),modifier_uid='$uid',modifier_ip='".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."'*/ ,body_cached='' WHERE content_id=$content_id" ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;

	return $content_id ;
}


// store a content into history table (before delete or update)
function pico_transact_backupcontent( $mydirname , $content_id , $forced = false )
{
	global $xoopsUser , $xoopsModuleConfig ;

	$db =& Database::getInstance() ;

	$histories_per_content = intval( @$xoopsModuleConfig['histories_per_content'] ) ;
	$minlifetime_per_history = intval( @$xoopsModuleConfig['minlifetime_per_history'] ) ;

	// fetch the latest history first
	list( $last_ch_id ) = $db->fetchRow( $db->query( "SELECT MAX(content_history_id) FROM ".$db->prefix($mydirname."_content_histories")." WHERE content_id=".intval($content_id) ) ) ;
	list( $last_ch_modified , $last_ch_md5bodies ) = $db->fetchRow( $db->query( "SELECT modified_time,MD5(concat(subject,htmlheader,body)) FROM ".$db->prefix($mydirname."_content_histories")." WHERE content_history_id=".intval($last_ch_id) ) ) ;	list( $current_md5bodies ) = $db->fetchRow( $db->query( "SELECT MD5(concat(subject,htmlheader,body)) FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".intval($content_id) ) ) ;

	// compare MD5 of subject,htmlheader,body (it is not saved if identical)
	if( ! $forced && $current_md5bodies == $last_ch_md5bodies ) return ;

	// min life time of each history
	if( $minlifetime_per_history > 0 && $last_ch_modified > time() - $minlifetime_per_history ) return ;

	// max histories
	if( $histories_per_content > 0 ) {
		do {
			list( $ch_count , $min_ch_id ) = $db->fetchRow( $db->query( "SELECT COUNT(*),MIN(content_history_id) FROM ".$db->prefix($mydirname."_content_histories")." WHERE content_id=".intval($content_id) ) ) ;
			if( $ch_count >= $histories_per_content ) {
				$db->query( "DELETE FROM ".$db->prefix($mydirname."_content_histories")." WHERE content_history_id=".intval($min_ch_id) ) ;
			}
		} while( $ch_count >= $histories_per_content ) ;
	}

	$uid = is_object( $xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;
	if( ! $db->query( "INSERT INTO ".$db->prefix($mydirname."_content_histories")." (content_id,vpath,cat_id,created_time,modified_time,poster_uid,poster_ip,modifier_uid,modifier_ip,subject,htmlheader,body,filters) SELECT content_id,vpath,cat_id,modified_time,UNIX_TIMESTAMP(),modifier_uid,modifier_ip,$uid,'".mysql_real_escape_string(@$_SERVER['REMOTE_ADDR'])."',subject,htmlheader,body,filters FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".intval($content_id) ) ) die( _MD_PICO_ERR_SQL.__LINE__ ) ;
}


?>