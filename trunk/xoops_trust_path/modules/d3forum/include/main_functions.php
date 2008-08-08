<?php

// this file can be included only from main or admin (not from blocks)


// add fields for tree structure into $posts or $categories
function d3forum_make_treeinformations( $data )
{
	$previous_depth = -1 ;
	$path_to_i = array() ;

	for( $i = 0 ; $i < sizeof( $data ) ; $i ++ ) {
		$unique_path = $data[$i]['unique_path'] ;
		$path_to_i[ $unique_path ] = $i ;
		$parent_path = substr( $unique_path , 0 , strrpos( $unique_path , '.' ) ) ;
		if( $parent_path && isset( $path_to_i[ $parent_path ] ) ) {
			$data[ $path_to_i[ $parent_path ] ]['f1s'][ $data[$i]['id'] ] = strrchr( $data[$i]['unique_path'] , '.' ) ;
		}

		$depth_diff = $data[$i]['depth_in_tree'] - @$previous_depth ;
		$previous_depth = $data[$i]['depth_in_tree'] ;
		$data[$i]['ul_in'] = '' ;
		$data[$i]['ul_out'] = '' ;
		if( $depth_diff > 0 ) {
			if( $i > 0 ) {
				$data[$i-1]['first_child_id'] = $data[$i]['id'] ;
			}
			for( $j = 0 ; $j < $depth_diff ; $j ++ ) {
				$data[$i]['ul_in'] .= '<ul><li>' ;
			}
		} else if( $depth_diff < 0 ) {
			for( $j = 0 ; $j < - $depth_diff ; $j ++ ) {
				$data[$i-1]['ul_out'] .= '</li></ul>' ;
			}
			$data[$i-1]['ul_out'] .= '</li>' ;
			$data[$i]['ul_in'] = '<li>' ;
		} else {
			$data[$i-1]['ul_out'] .= '</li>' ;
			$data[$i]['ul_in'] = '<li>' ;
		}
		if( $i > 0 ) {
			$data[$i-1]['next_id'] = $data[$i]['id'] ;
			$data[$i]['prev_id'] = $data[$i-1]['id'] ;
		}
	}
	$data[ sizeof( $data ) - 1 ]['ul_out'] = str_repeat( '</li></ul>' , $previous_depth + 1 ) ;

	return $data ;
}


// check done
function d3forum_get_forum_permissions_of_current_user( $mydirname )
{
	global $xoopsUser ;

	$db =& Database::getInstance() ;

	if( is_object( $xoopsUser ) ) {
		$uid = intval( $xoopsUser->getVar('uid') ) ;
		$groups = $xoopsUser->getGroups() ;
		if( ! empty( $groups ) ) $whr = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
		else $whr = "`uid`=$uid" ;
	} else {
		$whr = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
	}

	$sql = "SELECT forum_id,SUM(can_post) AS can_post,SUM(can_edit) AS can_edit,SUM(can_delete) AS can_delete,SUM(post_auto_approved) AS post_auto_approved,SUM(is_moderator) AS is_moderator FROM ".$db->prefix($mydirname."_forum_access")." WHERE ($whr) GROUP BY forum_id" ;
	$result = $db->query( $sql ) ;
	if( $result ) while( $row = $db->fetchArray( $result ) ) {
		$ret[ $row['forum_id'] ] = $row ;
	}

	if( empty( $ret ) ) return array( 0 => array() ) ;
	else return $ret ;
}


// check done
function d3forum_get_category_permissions_of_current_user( $mydirname )
{
	global $xoopsUser ;

	$db =& Database::getInstance() ;

	if( is_object( $xoopsUser ) ) {
		$uid = intval( $xoopsUser->getVar('uid') ) ;
		$groups = $xoopsUser->getGroups() ;
		if( ! empty( $groups ) ) $whr = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
		else $whr = "`uid`=$uid" ;
	} else {
		$whr = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
	}

	$sql = "SELECT cat_id,SUM(can_makeforum) AS can_makeforum,SUM(is_moderator) AS is_moderator FROM ".$db->prefix($mydirname."_category_access")." WHERE ($whr) GROUP BY cat_id" ;
	$result = $db->query( $sql ) ;
	if( $result ) while( $row = $db->fetchArray( $result ) ) {
		$ret[ $row['cat_id'] ] = $row ;
	}

	if( empty( $ret ) ) return array( 0 => array() ) ;
	else return $ret ;
}


// check done
function d3forum_get_users_can_read_forum( $mydirname , $forum_id , $cat_id )
{
	$db =& Database::getInstance() ;
	$forum_id = intval( $forum_id ) ;
	$forum_uids = array() ;
	$cat_uids = array() ;

	$sql = "SELECT `uid` FROM ".$db->prefix($mydirname."_category_access")." WHERE `cat_id`=$cat_id AND `uid` IS NOT NULL" ;
	$result = $db->query( $sql ) ;
	while( list( $uid ) = $db->fetchRow( $result ) ) {
		$cat_uids[] = $uid ;
	}
	$sql = "SELECT distinct g.uid FROM ".$db->prefix($mydirname."_category_access")." x , ".$db->prefix("groups_users_link")." g WHERE x.groupid=g.groupid AND x.`cat_id`=$cat_id AND x.`groupid` IS NOT NULL" ;
	$result = $db->query( $sql ) ;
	while( list( $uid ) = $db->fetchRow( $result ) ) {
		$cat_uids[] = $uid ;
	}
	$cat_uids = array_unique( $cat_uids ) ;

	$sql = "SELECT `uid` FROM ".$db->prefix($mydirname."_forum_access")." WHERE `forum_id`=$forum_id AND `uid` IS NOT NULL" ;
	$result = $db->query( $sql ) ;
	while( list( $uid ) = $db->fetchRow( $result ) ) {
		$forum_uids[] = $uid ;
	}
	$sql = "SELECT distinct g.uid FROM ".$db->prefix($mydirname."_forum_access")." x , ".$db->prefix("groups_users_link")." g WHERE x.groupid=g.groupid AND x.`forum_id`=$forum_id AND x.`groupid` IS NOT NULL" ;
	$result = $db->query( $sql ) ;
	while( list( $uid ) = $db->fetchRow( $result ) ) {
		$forum_uids[] = $uid ;
	}
	$forum_uids = array_unique( $forum_uids ) ;

	return array_intersect( $forum_uids , $cat_uids ) ;
}


// check done
function d3forum_get_forum_moderate_groups4show( $mydirname , $forum_id )
{
	$db =& Database::getInstance() ;

	$forum_id = intval( $forum_id ) ;

	$ret = array() ;
	$sql = 'SELECT g.groupid, g.name FROM '.$db->prefix($mydirname.'_forum_access').' fa LEFT JOIN '.$db->prefix('groups').' g ON fa.groupid=g.groupid WHERE fa.groupid IS NOT NULL AND fa.is_moderator AND forum_id='.$forum_id ;
	$mrs = $db->query( $sql ) ;
	while( list( $mod_gid , $mod_gname ) = $db->fetchRow( $mrs ) ) {
		$ret[] = array(
			'gid' => $mod_gid ,
			'gname' => htmlspecialchars( $mod_gname , ENT_QUOTES ) ,
		) ;
	}

	return $ret ;
}


// check done
function d3forum_get_forum_moderate_users4show( $mydirname , $forum_id )
{
	$db =& Database::getInstance() ;

	$forum_id = intval( $forum_id ) ;

	$ret = array() ;
	$sql = 'SELECT u.uid, u.uname FROM '.$db->prefix($mydirname.'_forum_access').' fa LEFT JOIN '.$db->prefix('users').' u ON fa.uid=u.uid WHERE fa.uid IS NOT NULL AND fa.is_moderator AND forum_id='.$forum_id ;
	$mrs = $db->query( $sql ) ;
	while( list( $mod_uid , $mod_uname ) = $db->fetchRow( $mrs ) ) {
		$ret[] = array(
			'uid' => $mod_uid ,
			'uname' => htmlspecialchars( $mod_uname , ENT_QUOTES ) ,
		) ;
	}

	return $ret ;
}


// check done
function d3forum_get_category_moderate_groups4show( $mydirname , $cat_id )
{
	$db =& Database::getInstance() ;

	$cat_id = intval( $cat_id ) ;

	$ret = array() ;
	$sql = 'SELECT g.groupid, g.name FROM '.$db->prefix($mydirname.'_category_access').' ca LEFT JOIN '.$db->prefix('groups').' g ON ca.groupid=g.groupid WHERE ca.groupid IS NOT NULL AND ca.is_moderator AND cat_id='.$cat_id ;
	$mrs = $db->query( $sql ) ;
	while( list( $mod_gid , $mod_gname ) = $db->fetchRow( $mrs ) ) {
		$ret[] = array(
			'gid' => $mod_gid ,
			'gname' => htmlspecialchars( $mod_gname , ENT_QUOTES ) ,
		) ;
	}

	return $ret ;
}


// check done
function d3forum_get_category_moderate_users4show( $mydirname , $cat_id )
{
	$db =& Database::getInstance() ;

	$cat_id = intval( $cat_id ) ;

	$ret = array() ;
	$sql = 'SELECT u.uid, u.uname FROM '.$db->prefix($mydirname.'_category_access').' ca LEFT JOIN '.$db->prefix('users').' u ON ca.uid=u.uid WHERE ca.uid IS NOT NULL AND ca.is_moderator AND cat_id='.$cat_id ;
	$mrs = $db->query( $sql ) ;
	while( list( $mod_uid , $mod_uname ) = $db->fetchRow( $mrs ) ) {
		$ret[] = array(
			'uid' => $mod_uid ,
			'uname' => htmlspecialchars( $mod_uname , ENT_QUOTES ) ,
		) ;
	}

	return $ret ;
}


// select box for jumping into a specified forum
function d3forum_make_jumpbox_options( $mydirname , $whr4cat , $whr4forum , $forum_selected = 0 )
{
	global $myts ;

	$db =& Database::getInstance() ;

	$ret = "" ;
	$sql = "SELECT c.cat_id, c.cat_title, c.cat_depth_in_tree, f.forum_id, f.forum_title FROM ".$db->prefix($mydirname."_categories")." c LEFT JOIN ".$db->prefix($mydirname."_forums")." f ON f.cat_id=c.cat_id WHERE ($whr4cat) AND ($whr4forum) ORDER BY c.cat_order_in_tree, f.forum_weight" ;
	if( $result = $db->query( $sql ) ) {
		while( list( $cat_id , $cat_title , $cat_depth , $forum_id , $forum_title ) = $db->fetchRow( $result ) ) {
			$selected = $forum_id == $forum_selected ? 'selected="selected"' : '' ;
			$ret .= "<option value='$forum_id' $selected>".str_repeat('--',$cat_depth).$myts->makeTboxData4Show($cat_title)." - ".$myts->makeTboxData4Show($forum_title)."</option>\n" ;
		}
	} else {
		$ret = "<option value=\"-1\">ERROR</option>\n";
	}

	return $ret ;
}


// select box for jumping into a specified category
function d3forum_make_cat_jumpbox_options( $mydirname , $whr4cat , $cat_selected = 0 )
{
	global $myts ;

	$db =& Database::getInstance() ;

	$ret = "" ;
	$sql = "SELECT c.cat_id, c.cat_title, c.cat_depth_in_tree FROM ".$db->prefix($mydirname."_categories")." c WHERE ($whr4cat) ORDER BY c.cat_order_in_tree" ;
	if( $result = $db->query( $sql ) ) {
		while( list( $cat_id , $cat_title , $cat_depth ) = $db->fetchRow( $result ) ) {
			$selected = $cat_id == $cat_selected ? 'selected="selected"' : '' ;
			$ret .= "<option value='$cat_id' $selected>".str_repeat('--',$cat_depth).$myts->makeTboxData4Show($cat_title)."</option>\n" ;
		}
	} else {
		$ret = "<option value=\"-1\">ERROR</option>\n";
	}

	return $ret ;
}


function d3forum_trigger_event( $category , $item_id , $event , $extra_tags=array() , $user_list=array() , $omit_user_id=null )
{
	global $xoopsModule , $xoopsConfig , $mydirname , $mydirpath , $mytrustdirname , $mytrustdirpath ;

	$notification_handler =& xoops_gethandler('notification') ;

	$mid = $xoopsModule->getVar('mid') ;

	// language file
	$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
	if( file_exists( "$mydirpath/language/$language/mail_template/" ) ) {
		// user customized language file
		$mail_template_dir = "$mydirpath/language/$language/mail_template/" ;
	} else if( file_exists( "$mytrustdirpath/language/$language/mail_template/" ) ) {
		// default language file
		$mail_template_dir = "$mytrustdirpath/language/$language/mail_template/";
	} else {
		// fallback english
		$mail_template_dir = "$mytrustdirpath/language/english/mail_template/";
	}

	// Check if event is enabled
	$config_handler =& xoops_gethandler('config');
	$mod_config =& $config_handler->getConfigsByCat(0,$mid);
	if (empty($mod_config['notification_enabled'])) {
		return false;
	}
	$category_info =& notificationCategoryInfo ($category, $mid);
	$event_info =& notificationEventInfo ($category, $event, $mid);
	if (!in_array(notificationGenerateConfig($category_info,$event_info,'option_name'),$mod_config['notification_events']) && empty($event_info['invisible'])) {
		return false;
	}

	if (!isset($omit_user_id)) {
		global $xoopsUser;
		if (!empty($xoopsUser)) {
			$omit_user_id = $xoopsUser->getVar('uid');
		} else {
			$omit_user_id = 0;
		}
	}
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('not_modid', intval($mid)));
	$criteria->add(new Criteria('not_category', $category));
	$criteria->add(new Criteria('not_itemid', intval($item_id)));
	$criteria->add(new Criteria('not_event', $event));
	$mode_criteria = new CriteriaCompo();
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDALWAYS), 'OR');
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE), 'OR');
	$mode_criteria->add (new Criteria('not_mode', XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT), 'OR');
	$criteria->add($mode_criteria);
	if (!empty($user_list)) {
		$user_criteria = new CriteriaCompo();
		foreach ($user_list as $user) {
			$user_criteria->add (new Criteria('not_uid', $user), 'OR');
		}
		$criteria->add($user_criteria);
	}
	$notifications =& $notification_handler->getObjects($criteria);
	if (empty($notifications)) {
		return;
	}

	// Add some tag substitutions here
	$tags = array();
	// {X_ITEM_NAME} {X_ITEM_URL} {X_ITEM_TYPE} from lookup_func are disabled
	$tags['X_MODULE'] = $xoopsModule->getVar('name','n');
	$tags['X_MODULE_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/';
	$tags['X_NOTIFY_CATEGORY'] = $category;
	$tags['X_NOTIFY_EVENT'] = $event;

	$template = $event_info['mail_template'] . '.tpl';
	$subject = $event_info['mail_subject'];

	foreach ($notifications as $notification) {
		if (empty($omit_user_id) || $notification->getVar('not_uid') != $omit_user_id) {
			// user-specific tags
			//$tags['X_UNSUBSCRIBE_URL'] = 'TODO';
			// TODO: don't show unsubscribe link if it is 'one-time' ??
			$tags['X_UNSUBSCRIBE_URL'] = XOOPS_URL . '/notifications.php';
			$tags = array_merge ($tags, $extra_tags);

			$notification->notifyUser($mail_template_dir, $template, $subject, $tags);
		}
	}
}


// started from {XOOPS_URL} for conventional modules
function d3forum_get_comment_link( $external_link_format , $external_link_id )
{
	if( substr( $external_link_format , 0 , 11 ) != '{XOOPS_URL}' ) return '' ;

	$format = str_replace( '{XOOPS_URL}' , XOOPS_URL , $external_link_format ) ;
	return sprintf( $format , urlencode( $external_link_id ) ) ;
}


// started from class:: for native d3comment modules
function d3forum_get_comment_description( $mydirname , $external_link_format , $external_link_id )
{
	$d3com =& d3forum_main_get_comment_object( $mydirname , $external_link_format ) ;
	if( ! is_object( $d3com ) ) return '' ;

	$description = $d3com->fetchDescription( $external_link_id ) ;

	if( $description ) return $description ;
	else return $d3com->fetchSummary( $external_link_id ) ;
}


// get object for comment integration
function &d3forum_main_get_comment_object( $mydirname , $external_link_format )
{
	include_once dirname(dirname(__FILE__)).'/class/D3commentAbstract.class.php' ;
	@list( $external_dirname , $classname , $external_trustdirname ) = explode( '::' , $external_link_format ) ;
	if( empty( $classname ) ) {
		$obj =& new D3commentAbstract( $mydirname , '' ) ;
		return $obj ;
	}

	// search the class file
	$class_bases = array(
		XOOPS_ROOT_PATH.'/modules/'.$external_dirname.'/class' ,
		XOOPS_TRUST_PATH.'/modules/'.$external_trustdirname.'/class' ,
		XOOPS_TRUST_PATH.'/modules/d3forum/class' ,
	) ;

	foreach( $class_bases as $class_base ) {
		if( file_exists( $class_base.'/'.$classname.'.class.php' ) ) {
			require_once $class_base.'/'.$classname.'.class.php' ;
			break ;
		}
	}

	// check the class
	if( ! $classname || ! class_exists( $classname ) ) {
		$obj =& new D3commentAbstract( $mydirname , $external_dirname ) ;
		return $obj ;
	}

	$obj =& new $classname( $mydirname , $external_dirname ) ;
	return $obj ;
}


// get samples of category options
function d3forum_main_get_categoryoptions4edit( $d3forum_configs_can_be_override )
{
	global $xoopsModuleConfig ;

	$lines = array() ;
	foreach( $d3forum_configs_can_be_override as $key => $type ) {
		if( isset( $xoopsModuleConfig[ $key ] ) ) {
			$val = $xoopsModuleConfig[ $key ] ;
			if( $type == 'int' || $type == 'bool' ) {
				$val = intval( $val ) ;
			}
			$lines[] = htmlspecialchars( $key . ':' . $val , ENT_QUOTES ) ;
		}
	}
	return implode( '<br />' , $lines ) ;
}


// hook topic_id/external_link_id into $_POST['mode'] = 'reply' , $_POST['post_id']
function d3forum_main_posthook_sametopic( $mydirname )
{
	$db =& Database::getInstance() ;

	if( ! empty( $_POST['external_link_id'] ) ) {
		// search the first post of the latest topic with the external_link_id
		$external_link_id4sql = addslashes( @$_POST['external_link_id'] ) ;
		$forum_id = intval( @$_POST['forum_id'] ) ;
		$result = $db->query( "SELECT topic_first_post_id,topic_locked FROM ".$db->prefix($mydirname."_topics")." WHERE topic_external_link_id='$external_link_id4sql' AND forum_id=$forum_id AND ! topic_invisible ORDER BY topic_last_post_time DESC LIMIT 1" ) ;
	} else if( ! empty( $_POST['topic_id'] ) ) {
		// search the first post of the topic with the topic_id
		$topic_id = intval( @$_POST['topic_id'] ) ;
		$result = $db->query( "SELECT topic_first_post_id,topic_locked FROM ".$db->prefix($mydirname."_topics")." WHERE topic_id=$topic_id AND ! topic_invisible" ) ;
	}

	if( empty( $result ) ) return ;

	list( $pid , $topic_locked ) = $db->fetchRow( $result ) ;
	if( $pid > 0 && ! $topic_locked ) {
		// hook to reply
		$_POST['mode'] = 'reply' ;
		$_POST['pid'] = $pid ;
	}
}


?>