<?php
/**
 * @version $Id: onuninstall.php 630 2010-06-22 16:11:25Z hodaka $
 */

eval( ' function xoops_module_uninstall_'.$mydirname.'( $module ) { return d3blog_onuninstall_base( $module , "'.$mydirname.'" ) ; } ' ) ;


if( ! function_exists( 'd3blog_onuninstall_base' ) ) {

function d3blog_onuninstall_base( $module , $mydirname )
{
    // transations on module uninstall

    global $ret ; // TODO :-D

    // for Cube 2.1
    if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
        $root =& XCube_Root::getSingleton();
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUninstall.' . ucfirst($mydirname) . '.Success' , 'd3blog_message_append_onuninstall' ) ;
        $root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUninstall.' . ucfirst($mydirname) . '.Fail' , 'd3blog_message_append_onuninstall' ) ;
        $ret = array() ;
    } else {
        if( ! is_array( $ret ) ) $ret = array() ;
    }

    $db =& Database::getInstance() ;
    $mid = $module->getVar('mid') ;

    // PHOTOS
    // TODO we must delete photodir and photos if they are kept left before Database tables are dropped

    // TABLES (loading mysql.sql)
    $sql_file_path = dirname(__FILE__).'/sql/mysql.sql' ;
    $prefix_mod = $db->prefix() . '_' . $mydirname ;
    if( file_exists( $sql_file_path ) ) {
        $ret[] = "SQL file found at <strong>".htmlspecialchars($sql_file_path)."</strong>.<br  /> Deleting tables...<br />";
        $sql_lines = file( $sql_file_path ) ;
        foreach( $sql_lines as $sql_line ) {
            if( preg_match( '/^CREATE TABLE \`?([a-zA-Z0-9_-]+)\`? /i' , $sql_line , $regs ) ) {
                $sql = 'DROP TABLE '.addslashes($prefix_mod.'_'.$regs[1]);
                if (!$db->query($sql)) {
                    $ret[] = '<span style="color:#ff0000;">ERROR: Could not drop table <strong>'.htmlspecialchars($prefix_mod.'_'.$regs[1]).'</strong>.</span><br />';
                } else {
                    $ret[] = 'Table <strong>'.htmlspecialchars($prefix_mod.'_'.$regs[1]).'</strong> dropped.<br />';
                }
            }
        }
    }

    return true ;
}

function d3blog_message_append_onuninstall( &$module_obj , &$log )
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
