<?php
// $Id: blocks.php,v 1.2 2008/07/07 23:34:23 ohwada Exp $

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

if ( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) die( 'not permit' ) ;

//---------------------------------------------------------
// xoops system files
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/class/template.php' ;
include_once XOOPS_ROOT_PATH.'/class/xoopstree.php' ;

//---------------------------------------------------------
// webphoto files
//---------------------------------------------------------
include_once WEBPHOTO_TRUST_PATH.'/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH.'/include/optional.php';

webphoto_include_once( 'preload/debug.php',          $MY_DIRNAME );
webphoto_include_once( 'include/constants.php',      $MY_DIRNAME );
webphoto_include_once( 'class/xoops/base.php',       $MY_DIRNAME );
webphoto_include_once( 'class/lib/multibyte.php',    $MY_DIRNAME );
webphoto_include_once( 'class/inc/xoops_header.php', $MY_DIRNAME );
webphoto_include_once( 'class/inc/handler.php',      $MY_DIRNAME );
webphoto_include_once( 'class/inc/config.php',       $MY_DIRNAME );
webphoto_include_once( 'class/inc/blocks.php',       $MY_DIRNAME );
webphoto_include_once( 'blocks/functions.php',       $MY_DIRNAME );

webphoto_include_language( 'blocks.php', $MY_DIRNAME );

webphoto_include_once_trust( 'preload/constants.php' );

?>