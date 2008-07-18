<?php
// $Id: oninstall.inc.php,v 1.2 2008/07/07 23:34:23 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-07-01 K.OHWADA
// use webphoto_include_once_trust()
//---------------------------------------------------------

//---------------------------------------------------------
// $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by caller
//---------------------------------------------------------

if( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) die( 'not permit' ) ;

//---------------------------------------------------------
// xoops system files
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php' ;
include_once XOOPS_ROOT_PATH.'/class/template.php' ;

//---------------------------------------------------------
// webphoto files
//---------------------------------------------------------
include_once WEBPHOTO_TRUST_PATH.'/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH.'/include/optional.php';

webphoto_include_once( 'include/constants.php',   $MY_DIRNAME );
webphoto_include_once( 'class/inc/handler.php',   $MY_DIRNAME );
webphoto_include_once( 'class/inc/oninstall.php', $MY_DIRNAME );

webphoto_include_once_trust( 'preload/constants.php' );

//=========================================================
// onInstall function
//=========================================================
// --- eval begin ---
eval( '

function xoops_module_install_'.$MY_DIRNAME.'( &$module ) 
{
	return webphoto_oninstall_base( $module ) ; 
} 

function xoops_module_update_'.$MY_DIRNAME.'( &$module ) {
	return webphoto_onupdate_base( $module ) ; 
} 

function xoops_module_uninstall_'.$MY_DIRNAME.'( &$module ) {
	return webphoto_onuninstall_base( $module ) ; 
} 

' ) ;
// --- eval end ---

// === function begin ===
if( ! function_exists( 'webphoto_oninstall_base' ) ) 
{

function webphoto_oninstall_base( &$module )
{
	$inc_class =& webphoto_inc_oninstall::getInstance();
	return $inc_class->install( WEBPHOTO_TRUST_DIRNAME , $module );
}

function webphoto_onupdate_base( &$module )
{
	$inc_class =& webphoto_inc_oninstall::getInstance();
	return $inc_class->update(  WEBPHOTO_TRUST_DIRNAME , $module );
}

function webphoto_onuninstall_base( &$module )
{
	$inc_class =& webphoto_inc_oninstall::getInstance();
	return  $inc_class->uninstall( WEBPHOTO_TRUST_DIRNAME , $module );
}

function webphoto_message_append_oninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

function webphoto_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

function webphoto_message_append_onuninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

// === function begin ===
}

?>