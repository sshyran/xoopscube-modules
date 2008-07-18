<?php
// $Id: search.inc.php,v 1.2 2008/07/05 16:57:40 ohwada Exp $

//=========================================================
// webphoto module
// 2008-04-02 K.OHWADA
//=========================================================

//---------------------------------------------------------
// change log
// 2008-07-01 K.OHWADA
// added config.php
//---------------------------------------------------------

//---------------------------------------------------------
// $MY_DIRNAME WEBPHOTO_TRUST_PATH are set by caller
//---------------------------------------------------------

if( ! defined( 'WEBPHOTO_TRUST_PATH' ) ) die( 'not permit' ) ;

include_once WEBPHOTO_TRUST_PATH.'/class/d3/optional.php';
include_once WEBPHOTO_TRUST_PATH.'/include/optional.php';

webphoto_include_once( 'class/inc/handler.php',  $MY_DIRNAME );
webphoto_include_once( 'class/inc/config.php' ,  $MY_DIRNAME );
webphoto_include_once( 'class/inc/search.php' ,  $MY_DIRNAME );
webphoto_include_once( 'preload/search.php' ,    $MY_DIRNAME  );

//=========================================================
// search functions
//=========================================================
// --- eval begin ---
eval( '

function '.$MY_DIRNAME.'_search( $query_array , $andor , $limit , $offset , $uid )
{
	return webphoto_search_base( "'.$MY_DIRNAME.'" , $query_array , $andor , $limit , $offset , $uid ) ;
}

' );
// --- eval end ---


// === function begin ===
if( !function_exists( 'webphoto_search_base' ) ) 
{

function webphoto_search_base( $dirname, $query_array, $andor, $limit, $offset, $uid )
{
	$inc_class =& webphoto_inc_search::getInstance();
	return $inc_class->search( $dirname, $query_array, $andor, $limit, $offset, $uid );
}

// === function end ===
}

?>