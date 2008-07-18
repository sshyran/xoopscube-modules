<?php
/**
 * @version $Id: onupdate.php 445 2008-05-30 08:21:20Z hodaka $
 */

eval( ' function xoops_module_update_'.$mydirname.'( $module ) { return d3blog_onupdate_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'd3blog_onupdate_base' ) ) {

function d3blog_onupdate_base( $module , $mydirname )
{
    // transations on module update

    global $msgs ; // TODO :-D

    // for Cube 2.1
    if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
        $root =& XCube_Root::getSingleton();
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Success', 'd3blog_message_append_onupdate' ) ;
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($mydirname) . '.Fail' , 'd3blog_message_append_onupdate' ) ;
        $msgs = array() ;
    } else {
        if( ! is_array( $msgs ) ) $msgs = array() ;
    }

    $db =& Database::getInstance() ;
    $mid = $module->getVar('mid') ;

    if( !class_exists( $mydirname )) {
        require dirname(__FILE__).'/class/global.class.php';
    }

    // TABLES (write here ALTER TABLE etc. if necessary)

    // v0.9.8.2 -> v0.9.9
    $sql = "SHOW COLUMNS FROM ".$db->prefix($mydirname.'_entry')." LIKE 'groups'";
    if($res = $db->query($sql)) {
        if(!$row =$db->fetchRow($res)) {
            $asql = "ALTER TABLE ".$db->prefix($mydirname.'_entry')." ADD `groups` text NOT NULL AFTER `dobr`";
            if($db->queryF($asql)) {
                $msgs[] = 'Database table <strong>entry</strong> succefully altered.</span>';
                
                $entry_handler = call_user_func(array($mydirname, 'getHandler'), 'entry');
                $objs =& $entry_handler->getObjects();
                if(count($objs)) {
                    foreach($objs as $obj) {
                        $obj->setDefaultGroups();
                        if(!$entry_handler->insert($obj, true)) {
                            $msgs[] = '<span style="color:#ff0000;">ERROR: Failed to update default groups of entry table.</span>';
                            break;
                        }
                    }
                    $msgs[] = 'Database table <strong>entry</strong>, default value of groups succefully updated.</span>';
                }
            } else {
                $msgs[] = '<span style="color:#ff0000;">ERROR: Failed to alter entry table structure.</span>';
            }
        } else {    // ->v1.02
        	$sql = "DESCRIBE ".$db->prefix($mydirname.'_entry')." `groups`";
            if($res = $db->query($sql)) {
                if($row = $db->fetchRow($res)) {
                    if(preg_match("/^varchar(.*)$/", $row[1])) {
                        $asql = "ALTER TABLE ".$db->prefix($mydirname.'_entry')." CHANGE `groups` `groups` text NOT NULL";
                        if($db->queryF($asql)) {
                            $entry_handler = call_user_func(array($mydirname, 'getHandler'), 'entry');
                            $objs =& $entry_handler->getObjects();
                            if(count($objs)) {
                                foreach($objs as $obj) {
                                    if($obj->resetGroups()) {
                                        if(!$entry_handler->insert($obj, true)) {
                                            $msgs[] = '<span style="color:#ff0000;">ERROR: Failed to update groups of entry table.</span>';
                                            break;
                                        }
                                    }
                                }
                            }
                            $msgs[] = 'Database table <strong>entry</strong> succefully altered.</span>';
                        } else {
                        	$msgs[] = '<span style="color:#ff0000;">ERROR: Failed to alter entry table structure, groups.</span>';
                        }
                    }
                }
            }
        }
    }

    // -> 1.0.2
    $sql = "SHOW COLUMNS FROM ".$db->prefix($mydirname.'_entry')." LIKE 'doimage'";
    if($res = $db->query($sql)) {
    	if(!$row =$db->fetchRow($res)) {
            $altsql = "ALTER TABLE ".$db->prefix($mydirname."_entry")." ADD `doxcode` TINYINT( 1 ) UNSIGNED NOT NULL default '1' AFTER `dohtml`, ADD `doimage` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' AFTER `doxcode`";
            if(!$db->queryF($altsql)) {
            	$msgs[] = '<span style="color:#ff0000;">ERROR: Failed to alter entry table structure, doxcode and doimage.</span>';
            } else {
                $msgs[] = 'Database table <strong>entry</strong>, columns of doxcode and doimage succefully added.</span>';
            }
        }
    }
  
/*    // v1.0x -> v1.10
    $sql = "SHOW COLUMNS FROM ".$db->prefix($mydirname.'_comment')." LIKE 'user_name'";
    $res = $db->query($sql);
    if(!$res) {
    	// d3blog -> d3blogEx
    	$sql = "CREATE TABLE IF NOT EXISTS ".$db->prefix($mydirname.'_comment')."(";
    	$sql .= "`com_id` INT( 10 ) NOT NULL AUTO_INCREMENT,";
    	$sql .= "`com_bid` INT( 8 ) NOT NULL DEFAULT '0',";
    	$sql .= "`com_rootid` INT( 10 ) NOT NULL DEFAULT '0',";
    	$sql .= "`com_pid` INT( 10 ) NOT NULL DEFAULT '0',";
    	$sql .= "`com_tid` INT( 8 ) NOT NULL DEFAULT '0',";
    	$sql .= "`com_type` ENUM( '1', '2' ) NOT NULL DEFAULT '1',";
    	$sql .= "`com_status` ENUM( '1', '2', '3' ) NOT NULL DEFAULT '1',";
    	$sql .= "`com_title` VARCHAR( 255 ) NOT NULL ,";
    	$sql .= "`com_text` TEXT NOT NULL ,";
    	$sql .= "`user_id` INT( 11 ) NOT NULL DEFAULT '0',";
    	$sql .= "`user_name` VARCHAR( 60 ) NOT NULL ,";
    	$sql .= "`user_email` varchar( 60 ) NOT NULL,";
    	$sql .= "`user_url` varchar( 100 ) NOT NULL,";
    	$sql .= "`user_host` varchar( 60 ) NOT NULL,";
    	$sql .= "`dohtml` INT( 1 ) NOT NULL DEFAULT '0',";
    	$sql .= "`doimage` INT( 1 ) NOT NULL DEFAULT '0',";
    	$sql .= "`dobr` INT( 1 ) NOT NULL DEFAULT '1',";
    	$sql .= "`created` int( 10 ) NOT NULL default '0',";
    	$sql .= "`modified` int( 10 ) NOT NULL default '0',";
    	$sql .= "PRIMARY KEY (com_id),KEY com_bid (com_bid),KEY com_rootid (com_rootid),KEY com_pid (com_pid)";
    	$sql .= ") TYPE=MyISAM;";

    	if($res = $db->queryF($sql)) {
        	$msgs[] = 'Database table <strong>comment</strong> succefully created.</span>';
    	} else {
        	$msgs[] = '<span style="color:#ff0000;">ERROR: Failed to create comment table structure.</span>';
    	}
    }*/

    // TEMPLATES (all templates have been already removed by modulesadmin)
    $tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
    $tpl_path = dirname(__FILE__).'/templates' ;
    if( $handler = @opendir( $tpl_path . '/' ) ) {
        while( ( $file = readdir( $handler ) ) !== false ) {
            if( substr( $file , 0 , 1 ) == '.' ) continue ;
            $file_path = $tpl_path . '/' . $file ;
            if( is_file( $file_path ) && in_array( strrchr( $file , '.' ) , array( '.xml', '.html' , '.css' , '.js') ) ) {
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

function d3blog_message_append_onupdate( &$module_obj , &$log )
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