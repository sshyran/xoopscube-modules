<?php

$db =& Database::getInstance() ;

require_once dirname( dirname(__FILE__) ).'/class/history_download.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

// THIS PAGE CAN BE CALLED ONLY FROM D3DOWNLOADS
if( $xoopsModule->getVar('dirname') != $mydirname ) die( 'this page can be called only from '.$mydirname ) ;

// PERMISSION ERROR
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

// GET ID FROM $_GET
$id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : "";

$mod_url = XOOPS_URL.'/modules/'.$mydirname ;

// GET HISTORY DATA
$history = new history_download( $mydirname ) ;
$historydata = array() ;
$historydata = $history->get_history_data( $id );
$lid = $historydata['lid'];
$history4assign = $historydata['historydata'];

// GET HISTORY lIST
$historylist = array() ;
$historylist = $history->get_history_list( $lid, $id );

// GET DOWNLOADDATA
include_once dirname(dirname(__FILE__)).'/class/mydownload.php' ;
$mydownload = new MyDownload( $mydirname );
$download4assign = $mydownload->get_downdata_for_singleview( 0, $lid, 0, 0, 1 );

// display stage
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
require_once XOOPS_ROOT_PATH.'/class/template.php' ;
$tpl =& new XoopsTpl() ;
$tpl->assign( array(
	'mod_url' => $mod_url ,
	'page' => 'approvalmanager' ,
	'history' => $history4assign ,
	'historylist' => $historylist ,
	'down' => $download4assign ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_history.html' ) ;
xoops_cp_footer();

?>