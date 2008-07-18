<?php

require_once dirname( dirname(__FILE__) ).'/include/upload_functions.php' ;

// this page can be called only from d3downloads
if( $xoopsModule->getVar('dirname') != $mydirname ) die( 'this page can be called only from '.$mydirname ) ;

// permission error
$module_handler =& xoops_gethandler( 'module' ) ;
$module =& $module_handler->getByDirname( $mydirname ) ;
$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
$mid = $module->getVar('mid') ;
if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $mid , $xoopsUser->getGroups() ) ) {
	die( 'Only administrator can use this feature.' ) ;
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;

echo '<h2>'._MD_D3DOWNLOADS_H2_CONFIG_CHECK.'</h2>';
echo '<ul>';

// config_check
$maxfilesize = ! empty( $GLOBALS['xoopsModuleConfig']['maxfilesize'] )? intval( $GLOBALS['xoopsModuleConfig']['maxfilesize'] ) * 1024  : 1000 * 1024;
$maxfilesize4assin = number_format( $maxfilesize );
echo '<li>'.sprintf( _MD_D3DOWNLOADS_MAXFILESIZE , $maxfilesize4assin );

// phpini_check
echo '<li>'._MD_D3DOWNLOADS_PHPINI_CHECK ;
echo '<ul style="margin-left:2em">';

// file_uploads
echo '<li>file_uploads';
echo ini_get('file_uploads')? '<span style="color:blue;padding-left:1em;">OK</span></li>' : '<span style="color:red;padding-left:1em;">NG</span></li>';

// upload_max_filesize
$upload_max_filesize = d3download_return_bytes( ini_get( 'upload_max_filesize' ) );
echo '<li>upload_max_filesize<span style="padding-left:1em">'. number_format( $upload_max_filesize ).' byte</span>';
echo ( $upload_max_filesize > $maxfilesize )? '<span style="color:blue;padding-left:1em;">OK</span></li>' : '<span style="color:red;padding-left:1em;">NG</span></li>';

// post_max_size
$post_max_size = d3download_return_bytes( ini_get( 'post_max_size' ) );
echo '<li>post_max_size<span style="padding-left:1em">';
echo number_format( $post_max_size ).' byte</span>';
echo ( $maxfilesize <= $post_max_size ) ? '<span style="color:blue;padding-left:1em;">OK</span></li>':'<span style="color:red;padding-left:1em;">NG</span></li>';

// memory_limit
$memory_limit = ini_get( 'memory_limit' );
if( ! empty( $memory_limit ) ){
	echo '<li>memory_limit<span style="padding-left:1em">';
	echo $memory_limit.'</span>';
}

// max_execution_time
$max_execution_time = ini_get( 'max_execution_time' );
echo '<li>max_execution_time<span style="padding-left:1em">';
echo $max_execution_time.'s</span>';

// safe_mode
$safe_mode = ini_get( 'safe_mode' );
echo '<li>safe_mode<span style="padding-left:1em">'.( ( $safe_mode ) ? "on" : "off").'</span></li>';
echo '</ul></li>';

// uploaddir_check
echo '<li>'._MD_D3DOWNLOADS_UPLOADDIR_CHECK ;
echo '<ul style="margin-left:2em">';
$upload_dir = XOOPS_TRUST_PATH.'/uploads/'.$mydirname.'/' ;
echo '<li>'._MD_D3DOWNLOADS_UPLOADDIR_CONFIFG.'<span style="padding-left:1em">'.htmlspecialchars( $upload_dir ).'</span>';
if( ! is_dir( $upload_dir ) ) {
	if( $safe_mode ) {
		echo '<br /><span style="color:red;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_DIR.'</span>';
	} elseif ( ! mkdir( $upload_dir , 0777 ) ) {
		echo '<br /><span style="color:red;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_MKDIR.'</span>';
	}
} elseif ( ! is_writeable( $upload_dir ) ) {
	if( ! chmod( $upload_dir , 0777 ) ) {
		echo '<br /><span style="color:red;padding-left:1em;">'._MD_D3DOWNLOADS_UPLOADDIR_NOT_IS_WRITEABLE.'</span>';
	}
} else {
	echo '<span style="color:blue;padding-left:1em;">OK</span></li>';
}

echo '</ul>';

xoops_cp_footer();

?>