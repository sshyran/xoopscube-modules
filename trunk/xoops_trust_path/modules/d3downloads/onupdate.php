<?php

eval( ' function xoops_module_update_'.$mydirname.'( $module ) { return d3downloads_onupdate_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'd3downloads_onupdate_base' ) ) {

function d3downloads_onupdate_base( $module , $mydirname )
{
	// transations on module update

	global $msgs ; // TODO :-D

	// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'd3downloads_message_append_onupdate' ) ;
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Fail' , 'd3downloads_message_append_onupdate' ) ;
		$msgs = array() ;
	} else {
		if( ! is_array( $msgs ) ) $msgs = array() ;
	}

	$db =& Database::getInstance() ;
	$mid = $module->getVar('mid') ;

	// TABLES (write here ALTER TABLE etc. if necessary)

	// configs (Though I know it is not a recommended way...)
	$check_sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
	if( ( $result = $db->query( $check_sql ) ) && ( $myrow = $db->fetchArray( $result ) ) && @$myrow['Type'] == 'varchar(30)' ) {
		$db->queryF( "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''" ) ;
	}

	// 0.01
	$check_sql = "SELECT date FROM ".$db->prefix($mydirname."_downloads_history") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_downloads_history")." ADD date int(10) NOT NULL default '0' AFTER description" ) ;
	}

	// 0.01 -> 0.02
	$check_sql = "SELECT html FROM ".$db->prefix($mydirname."_downloads") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_downloads")." ADD html tinyint(1) NOT NULL default '0' AFTER description,ADD smiley tinyint(1) NOT NULL default '0' AFTER html,ADD br tinyint(1) NOT NULL default '0' AFTER smiley,ADD xcode tinyint(1) NOT NULL default '0' AFTER br" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_unapproval")." ADD html tinyint(1) NOT NULL default '0' AFTER description,ADD smiley tinyint(1) NOT NULL default '0' AFTER html,ADD br tinyint(1) NOT NULL default '0' AFTER smiley,ADD xcode tinyint(1) NOT NULL default '0' AFTER br" ) ;
	}

	// 0.01 -> 0.02
	$check_sql = "SELECT mail FROM ".$db->prefix($mydirname."_downloads") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_downloads")."  ADD mail varchar(250) NOT NULL default '' AFTER submitter,ADD kanrisya text AFTER comments" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_unapproval")." ADD mail varchar(250) NOT NULL default '' AFTER submitter,ADD kanrisya text AFTER notify" ) ;
	}

	// 0.02 -> 0.03
	$check_sql = "SELECT shotsdir FROM ".$db->prefix($mydirname."_cat") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_cat")."  ADD shotsdir varchar(250) NOT NULL default '' AFTER imgurl" ) ;
	}

	// 0.10 -> 0.20
	$check_sql = "SELECT filename FROM ".$db->prefix($mydirname."_downloads") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_downloads")."  ADD filename varchar(50) NOT NULL default '' AFTER url,ADD ext varchar(10) NOT NULL default '' AFTER filename" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_unapproval")."  ADD filename varchar(50) NOT NULL default '' AFTER url,ADD ext varchar(10) NOT NULL default '' AFTER filename" ) ;
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_downloads_history")."  ADD filename varchar(50) NOT NULL default '' AFTER url,ADD ext varchar(10) NOT NULL default '' AFTER filename" ) ;
	}

	// 0.70 -> 0.80
	$check_sql = "SELECT upload FROM ".$db->prefix($mydirname."_user_access") ;
	if( ! $db->query( $check_sql ) ) {
		$db->queryF( "ALTER TABLE ".$db->prefix($mydirname."_user_access")."  ADD upload tinyint(1) NOT NULL default 0 AFTER html" ) ;
	}

	// configs (Though I know it is not a recommended way...)
	$check_sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
	if( ( $result = $db->query( $check_sql ) ) && ( $myrow = $db->fetchArray( $result ) ) && @$myrow['Type'] == 'varchar(30)' ) {
		$db->queryF( "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''" ) ;
	}

	// configs (Though I know it is not a recommended way...)
	$check_sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
	if( ( $result = $db->query( $check_sql ) ) && ( $myrow = $db->fetchArray( $result ) ) && @$myrow['Type'] == 'varchar(30)' ) {
		$db->queryF( "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''" ) ;
	}

	// TEMPLATES (all templates have been already removed by modulesadmin)
	$tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
	$tpl_path = dirname(__FILE__).'/templates' ;
	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) ) {
				$mtime = intval( @filemtime( $file_path ) ) ;
				$tplfile =& $tplfile_handler->create() ;
				$tplfile->setVar( 'tpl_source' , file_get_contents( $file_path ) , true ) ;
				$tplfile->setVar( 'tpl_refid' , $mid ) ;
				$tplfile->setVar( 'tpl_tplset' , 'default' ) ;
				$tplfile->setVar( 'tpl_file' , $mydirname . '_' . $file ) ;
				$tplfile->setVar( 'tpl_desc' , '' , true ) ;
				$tplfile->setVar( 'tpl_module' , $mydirname ) ;
				$tplfile->setVar( 'tpl_lastmodified' , $mtime ) ;
				$tplfile->setVar( 'tpl_lastimported' , 0 ) ;
				$tplfile->setVar( 'tpl_type' , 'module' ) ;
				if( ! $tplfile_handler->insert( $tplfile ) ) {
					$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
				} else {
					$tplid = $tplfile->getVar( 'tpl_id' ) ;
					$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tplid.'</b>)';
					// generate compiled file
					include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
					include_once XOOPS_ROOT_PATH.'/class/template.php' ;
					if( ! xoops_template_touch( $tplid ) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
					} else {
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
					}
				}
			}
		}
		closedir( $handler ) ;
	}
	include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
	include_once XOOPS_ROOT_PATH.'/class/template.php' ;
	xoops_template_clear_module_cache( $mid ) ;

	return true ;
}

function d3downloads_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

}

?>