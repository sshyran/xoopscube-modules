<?php
/**
 * @version $Id: oninstall.php 442 2008-05-24 02:12:53Z hodaka $
 */

eval( ' function xoops_module_install_'.$mydirname.'( $module ) { return d3blog_oninstall_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'd3blog_oninstall_base' ) ) {

function d3blog_oninstall_base( $module , $mydirname )
{
    // transations on module install

    global $ret ; // TODO :-D

    // for Cube 2.1
    if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
        $root =& XCube_Root::getSingleton();
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($mydirname) . '.Success' , 'd3blog_message_append_oninstall' ) ;
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($mydirname) . '.Fail' , 'd3blog_message_append_oninstall' ) ;
        $ret = array() ;
    } else {
        if( ! is_array( $ret ) ) $ret = array() ;
    }

    $db =& Database::getInstance() ;
    $mid = $module->getVar('mid') ;

    // to keep config setting more stable.
    // xoops config_title is too short, especially for d3-modules.
    $sql = "SHOW COLUMNS FROM ".$db->prefix("config")." LIKE 'conf_title'" ;
    if($result = $db->query($sql)) {
        if($row = $db->fetchArray($result)) {
            $sql = "ALTER TABLE ".$db->prefix("config")." MODIFY `conf_title` varchar(255) NOT NULL default '', MODIFY `conf_desc` varchar(255) NOT NULL default ''";
            if(!$res = $db->queryF($sql)) {
                $ret[] = '<span style="color:#FC0;font-weight:bold">FAILED TO ALTER AND MODIFY XOOPS CONFIG TABLE.</span><br />';
                return false ;
            }
            else {
            	$ret[] = 'Database table <strong>xoops config</strong> was successfully altered and modified.';
            }
        }
    } 

    // TABLES (loading mysql.sql)
    $sql_file_path = dirname(__FILE__).'/sql/mysql.sql' ;
    $prefix_mod = $db->prefix() . '_' . $mydirname ;
    if( file_exists( $sql_file_path ) ) {
        $ret[] = "SQL file found at <b>".htmlspecialchars($sql_file_path)."</b>.<br /> Creating tables...";

        if( file_exists( XOOPS_ROOT_PATH.'/class/database/oldsqlutility.php' ) ) {
            include_once XOOPS_ROOT_PATH.'/class/database/oldsqlutility.php' ;
            $sqlutil = new OldSqlUtility ;
        } else {
            include_once XOOPS_ROOT_PATH.'/class/database/sqlutility.php' ;
            $sqlutil = new SqlUtility ;
        }

        $sql_query = trim( file_get_contents( $sql_file_path ) ) ;
        $sqlutil->splitMySqlFile( $pieces , $sql_query ) ;
        $created_tables = array() ;
        foreach( $pieces as $piece ) {
            $prefixed_query = $sqlutil->prefixQuery( $piece , $prefix_mod ) ;
            if( ! $prefixed_query ) {
                $ret[] = "Invalid SQL <b>".htmlspecialchars($piece)."</b><br />";
                return false ;
            }
            if( ! $db->query( $prefixed_query[0] ) ) {
                $ret[] = '<strong>'.htmlspecialchars( $db->error() ).'</strong><br />' ;
                //var_dump( $db->error() ) ;
                return false ;
            } else {
                if( ! in_array( $prefixed_query[4] , $created_tables ) ) {
                    $ret[] = 'Table <strong>'.htmlspecialchars($prefix_mod.'_'.$prefixed_query[4]).'</strong> created.<br />';
                    $created_tables[] = $prefixed_query[4];
                } else {
                    $ret[] = 'Data inserted to table <strong>'.htmlspecialchars($prefix_mod.'_'.$prefixed_query[4]).'</strong>.</br />';
                }
            }
        }
    }

    // TEMPLATES
    $tplfile_handler =& xoops_gethandler( 'tplfile' ) ;
    $tpl_path = dirname(__FILE__).'/templates' ;
    if( $handler = @opendir( $tpl_path . '/' ) ) {
        while( ( $file = readdir( $handler ) ) !== false ) {
            if( substr( $file , 0 , 1 ) == '.' ) continue ;
            $file_path = $tpl_path . '/' . $file ;
            if( is_file( $file_path ) && in_array( strrchr( $file , '.' ) , array( '.xml', '.html' , '.css' , '.js' ) ) ) {
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
                    $ret[] = '<span style="color:#ff0000;">ERROR: Could not insert template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b> to the database.</span><br />';
                } else {
                    $tplid = $tplfile->getVar( 'tpl_id' ) ;
                    $ret[] = 'Template <strong>'.htmlspecialchars($mydirname.'_'.$file).'</strong> added to the database. (ID: <b>'.$tplid.'</b>)<br />';
                    // generate compiled file
                    include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
                    include_once XOOPS_ROOT_PATH.'/class/template.php' ;
                    if( ! xoops_template_touch( $tplid ) ) {
                        $ret[] = '<span style="color:#ff0000;">ERROR: Failed compiling template <b>'.htmlspecialchars($mydirname.'_'.$file).'</b>.</span><br />';
                    } else {
                        $ret[] = 'Template <strong>'.htmlspecialchars($mydirname.'_'.$file).'</strong> compiled.</span><br />';
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

function d3blog_message_append_oninstall( &$module_obj , &$log )
{
    if( is_array( @$GLOBALS['ret'] ) ) {
        foreach( $GLOBALS['ret'] as $message ) {
            $log->add( strip_tags( $message ) ) ;
        }
    }

    // use mLog->addWarning() or mLog->addError() if necessary
}

}

?>
