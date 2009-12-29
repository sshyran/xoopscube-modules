<?php
/**
 * @version $Id: import_manager.php 192 2007-10-11 14:20:17Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(__FILE__)).'/include/admin.inc.php';
require_once dirname(dirname(__FILE__)).'/include/gticket.php' ;

$myts =& MyTextSanitizer::getInstance();
$db =& Database::getInstance() ;

$module_handler =& xoops_gethandler( 'module' ) ;
$config_handler =& xoops_gethandler('config');

$mymid = $xoopsModule->getVar('mid');
$mod_config =& $config_handler->getConfigsByCat(0,$mymid);
unset($mod_config);

$modules =& $module_handler->getObjects() ;
$comment_handler =& xoops_gethandler( 'comment' ) ;

$importable_modules = array() ;
$comimportable_modules = array() ;
$importable_modules[0] = $comimportable_modules[0] = _MD_A_D3BLOG_LANG_SELECT_IMPORTMODULE;
foreach( $modules as $module ) {
    $mid = $module->getVar('mid') ;
    $dirname = $module->getVar('dirname') ;
    $dirpath = XOOPS_ROOT_PATH.'/modules/'.$dirname ;
    $mytrustdirname = '' ;
    $modconfig =& $config_handler->getConfigsByCat(0,$mid);
    if( file_exists( $dirpath.'/mytrustdirname.php' ) ) {
        require $dirpath.'/mytrustdirname.php' ;
        if( $mytrustdirname != '' && $dirname != $mydirname && isset($modconfig['trackback_approval']) ) {
            // d3blog type
            $importable_modules[$mid] = $mytrustdirname.'(d3blog):'.$module->getVar('name')." ($dirname)";
            if($module->getVar('hascomments')) {
                $comimportable_modules[ $mid ] = $mytrustdirname.'(d3blog):'. $module->getVar('name')." ($dirname)";
            }
        } elseif( $mytrustdirname != '' && $dirname != $mydirname && isset($modconfig['use_permissionsystem']) ) {
            // weblogD3 type
            $importable_modules[$mid] = $mytrustdirname.'(weblogD3):'.$module->getVar('name')." ($dirname)";
            if($module->getVar('hascomments')) {
                $comimportable_modules[ $mid ] = $mytrustdirname.'(weblogD3):'. $module->getVar('name')." ($dirname)";
            }
        }
    } elseif(preg_match('/^weblog(\d?)$/', $dirname, $matches)) {
        // weblog type
        $importable_modules[$mid] = "weblog:".$module->getVar('name')." ($dirname)";
        if($module->getVar('hascomments')) {
            $comimportable_modules[ $mid ] = "weblog:".$module->getVar('name')." ($dirname)";
        }
    } elseif(preg_match('/^xeblog$/', $dirname, $matches)) { 
        // xeblog type 
        $importable_modules[$mid] = "xeblog:".$module->getVar('name')." ($dirname)"; 
        if($module->getVar('hascomments')) { 
            $comimportable_modules[ $mid ] = "xeblog:".$module->getVar('name')." ($dirname)"; 
        } 
    }
}

if( !empty( $_POST['do_import'] ) && !empty( $_POST['import_mid'] ) ) {
    if(!(ini_get("safe_mode"))) {
        set_time_limit( 0 ) ;    /* invalid when safe_mode is on */
    }

    if ( ! $xoopsGTicket->check( true , 'd3blog_admin' ) ) {
        redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
    }

    $import_mid = intval( @$_POST['import_mid'] ) ;
    if( empty( $importable_modules[ $import_mid ] ) ) die( _MD_A_D3BLOG_ERROR_INVALIDMID ) ;
    list( $fromtype , $from_name) = explode( ':' , $importable_modules[ $import_mid ] ) ;
    preg_match('/([A-Za-z0-9_-]+)\)$/i', $from_name, $matches);
    $import_dirname = $matches[1];

    if($fromtype=='weblog') {
        import_from_weblog( $import_dirname , $import_mid );
    } elseif($fromtype=='xeblog') { 
        import_from_xeblog( $import_dirname , $import_mid );
    } elseif(preg_match('/\(([A-Za-z0-9_-]+)\)$/i', $fromtype, $matches)) {
        $from_type = $matches[1];
        if($from_type=='weblogD3') {
            import_from_weblogD3( $import_dirname , $import_mid );
        } elseif($from_type=='d3blog') {
            import_from_d3blog( $import_dirname , $import_mid );
    //rewrite_linkpath("modules/$import_dirname", "modules/$mydirname");
        }
    }

    redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import_manager" , 3 , _MD_A_D3BLOG_MESSAGE_IMPORTDONE._MD_A_D3BLOG_MESSAGE_MIGHT_REWRITE_LINKPATH );
    exit ;
}

if( ! empty( $_POST['do_comimport'] ) && ! empty( $_POST['comimport_mid'] ) ) {
    if(!(ini_get("safe_mode"))) {
        set_time_limit( 0 );    /* invalid when safe_mode is on */
    }

    if ( ! $xoopsGTicket->check( true , 'd3blog_admin' ) ) {
        redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
    }

    $import_mid = intval( @$_POST['comimport_mid'] ) ;
    if( !in_array( $import_mid, array_keys($comimportable_modules)) ) die( _MD_A_D3BLOG_ERROR_INVALIDMID );
    list( $fromtype , $from_name) = explode( ':', $comimportable_modules[ $import_mid ] ) ;

    preg_match('/([A-Za-z0-9_-]+)\)$/i', $from_name, $matches);
    $import_dirname = $matches[1];

    import_comments($mymid, $import_mid);
    synchronizeComments($mydirname.'_entry', $mymid);
    if($fromtype == 'weblog') synchronizeComments($import_dirname, $import_mid, $fromtype);
    else synchronizeComments($import_dirname.'_entry', $import_mid, $fromtype);
    rewrite_compath("/modules/$import_dirname/", "/modules/$mydirname/");
    import_notifications($mymid, $import_mid, $fromtype);

    redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import_manager" , 3 , _MD_A_D3BLOG_MESSAGE_IMPORTDONE );
    exit ;
}

if( !empty( $_POST['do_synchronize'] ) ) {
    if(!(ini_get("safe_mode"))) {
        set_time_limit( 0 );    /* invalid when safe_mode is on */
    }

    if ( ! $xoopsGTicket->check( true , 'd3blog_admin' ) ) {
        redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
    }

    synchronizeComments($mydirname.'_entry', $mymid);
    synchronizeTrackbacks($mydirname);

    redirect_header( XOOPS_URL."/modules/$mydirname/admin/index.php?page=import_manager" , 3 , _MD_A_D3BLOG_MESSAGE_IMPORTDONE );
    exit ;
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
    'mymid' => $mymid,
	'myname' => $myModule->module_name,
    'mydirname' => htmlspecialchars($mydirname, ENT_QUOTES) ,
    'mod_url' => XOOPS_URL.'/modules/'.htmlspecialchars($mydirname, ENT_QUOTES) ,
    'import_from_options' => $importable_modules ,
    'comimport_from_options' => $comimportable_modules ,
    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3blog_admin') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_importmanager.html' ) ;
xoops_cp_footer();

?>