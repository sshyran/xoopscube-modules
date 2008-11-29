<?php

eval( ' function xoops_module_update_'.$mydirname.'( $module ) { return myxcmodule_onupdate_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'myxcmodule_onupdate_base' ) ) {

function myxcmodule_onupdate_base( $module , $mydirname )
{
	// transations on module update

	global $msgs ;
	global $xoopsDB ;
    

	// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'myxcmodule_message_append_onupdate' ) ;
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
    
	// BLOCKS
	$tpl_path = dirname(__FILE__).'/templates/blocks' ;
	if( $handler = @opendir( $tpl_path . '/' ) ) {
		while( ( $file = readdir( $handler ) ) !== false ) {
			if( substr( $file , 0 , 1 ) == '.' ) continue ;
			$file_path = $tpl_path . '/' . $file ;
			if( is_file( $file_path ) && substr( $file , -5 ) == '.html' ) {
				$mtime = intval( @filemtime( $file_path ) ) ;
				$tpl_file = $mydirname . '_' . $file;
				$tpl_source = file_get_contents( $file_path );
				$sql = "SELECT tpl_id, tpl_refid FROM ".$db->prefix('tplfile')." WHERE tpl_module='$mydirname' AND tpl_file='".mysql_escape_string($tpl_file)."'";
				list($tpl_id, $block_id) = $db->fetchRow($db->query($sql));
				if( empty($tpl_id) && empty($block_id)){
					$blocks_info = $module->getInfo('blocks');
					$show_func = '';
					foreach($blocks_info as $oneblock){
						if($tpl_file == $oneblock['template']){
							$show_func = $oneblock['show_func'];
							break;
						}
					}
					if( $show_func != ''){
						$sql = sprintf("SELECT bid FROM %s WHERE dirname=%s AND show_func=%s", $db->prefix("newblocks"), $db->quoteString($mydirname), $db->quoteString($show_func) ) ;
						list($block_id) = $xoopsDB->fetchRow($xoopsDB->query($sql));
						if($block_id){
							$tplfile =& $tplfile_handler->create();
							$tplfile->setVar('tpl_module', $mydirname);
							$tplfile->setVar('tpl_refid', $block_id);
							$tplfile->setVar('tpl_source', $tpl_source, true);
							$tplfile->setVar('tpl_tplset', 'default');
							$tplfile->setVar('tpl_file', $tpl_file, true);
							$tplfile->setVar('tpl_type', 'block');
							$tplfile->setVar('tpl_lastimported', 0);
							$tplfile->setVar('tpl_lastmodified', time());
							$tplfile->setVar('tpl_desc', '', true);
							if (!$tplfile_handler->insert($tplfile)) {
								$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not insert template <b>'.$tpl_file.'</b> to the database.</span>';
							} else {
								$newid = $tplfile->getVar('tpl_id');
								$msgs[] = '&nbsp;&nbsp;Template <b>'.$tpl_file.'</b> added to the database.';
								if ($xoopsConfig['template_set'] == 'default') {
									if (!xoops_template_touch($block_id)) {
										$msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Template <b>'.$tpl_file.'</b> recompile failed.</span>';
									} else {
										$msgs[] = '&nbsp;&nbsp;Template <b>'.$tpl_file.'</b> recompiled.';
									}
								}
							}
							$sql = "UPDATE ".$db->prefix("newblocks")." SET template='".mysql_escape_string($tpl_file)."', last_modified=".time()." WHERE bid=".$block_id;
							if( !$result = $db->query($sql) ) {
								$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
							}else{
								$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$newid.'</b>)';
							}
						}
					}
				}
				elseif (!empty($tpl_id) && isset($tpl_source) && $tpl_source != '') {
					$sql = "SELECT COUNT(*) FROM ".$db->prefix('tplsource')." WHERE tpl_id='$tpl_id'";
					list($count) = $xoopsDB->fetchRow($xoopsDB->query($sql));
					if($count==0){
						$sql = sprintf("INSERT INTO %s (tpl_id, tpl_source) VALUES (%u, %s)", $db->prefix('tplsource'), $tpl_id, $db->quoteString($tpl_source));
					}else{
						$sql = "UPDATE ".$db->prefix("tplsource")." SET tpl_source='".mysql_escape_string($tpl_source)."' WHERE tpl_id=".$tpl_id;
					}
					if( !$result = $db->query($sql) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
					} else {
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tpl_id.'</b>)';
						// generate compiled file
						include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
						include_once XOOPS_ROOT_PATH.'/class/template.php';
						if( ! xoops_template_touch( $tpl_id ) ) {
							$msgs[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span>';
						} else {
							$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> compiled.</span>';
						}
					}
					$sql = "UPDATE ".$db->prefix("newblocks")." SET template='".mysql_escape_string($tpl_file)."', last_modified=".time()." WHERE bid=".$block_id;
					if( !$result = $db->query($sql) ) {
						$msgs[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span>';
					}else{
						$msgs[] = 'Template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> added to the database. (ID: <b>'.$tpl_id.'</b>)';
					}
				}
			}
		}
		closedir( $handler ) ;
	}

	return true ;
}

function myxcmodule_message_append_onupdate( &$module_obj , &$log )
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
