<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type   :  function
 * Name   :  flatdata
 * Version:  1.24 ( 1 + flatdata Ver. )
 * Date   :  2008.4.7-2008.7.23
 * Author :  wye
 * Purpose:  plugin to embed data in flatdata
 * Input  :  
 * Examples: {flatdata fd_dir=flatdata embed_dir=links item_field=lid item_id=$link.id mode=display|form}
 *             fd_dir     : directory name of flatdata on ROOT side
 *             embed_dir  : directory name of module to embed data
 *             item_field : item's name to specify displayed page
 *             item_id    : item's id nubmer to specify displayed page
 *             mode       : form / display
 *             preload    : (form option) submit using preload, 1 / 0
 *             count      : (display option) number of data , 1 
 *             post       : (form option)  , multi
 * -------------------------------------------------------------
 */

function smarty_function_flatdata($params, &$smarty)
{
	$fd_dir     = isset( $params['fd_dir'] )     ? $params['fd_dir'] : '' ;
	$embed_dir  = isset( $params['embed_dir'] )  ? $params['embed_dir'] : '' ;
	$item_field = isset( $params['item_field'] ) ? $params['item_field'] : '' ;
	$item_id    = isset( $params['item_id'] )    ? intval($params['item_id']) : 0 ;
	$mode       = isset( $params['mode'] )       ? $params['mode'] : 0 ;
	$preload    = isset( $params['preload'] )    ? intval($params['preload']) : 0 ;

	$mode_arr = array('form','display') ;
	$sp_embed_dir = array('userinfo.php','edituser.php','register.php') ;

	//for X2, Guest
	if( $embed_dir=='userinfo.php' && !defined('XOOPS_CUBE_LEGACY') && isset($_GET['uid']) && $item_id==0 ){
		$item_id = intval($_GET['uid']) ;
	}
	
	if( ( $mode=='display' && $item_id==0 ) || 
	  !preg_match( '/^[0-9a-zA-Z_-]+$/' , $fd_dir ) || 
	  ( !in_array($embed_dir,$sp_embed_dir) && !preg_match('/^[0-9a-zA-Z_-]+$/',$embed_dir) ) || 
	  !preg_match( '/^[0-9a-zA-Z_-]+$/' , $item_field ) || 
	  !in_array($mode,$mode_arr) ) 
	{
		echo "<p>flatdata does not set properly.</p>" ;
	} else {
		if( file_exists(XOOPS_TRUST_PATH."/modules/flatdata/include/embed.php") ){
			require_once XOOPS_TRUST_PATH."/modules/flatdata/include/embed.php" ;
			if ($mode == 'display') {
				flatdata_embed_display($fd_dir, $embed_dir, $item_field, $item_id, $params);
			} else if ( $mode=='form' ) {
				flatdata_embed_form($fd_dir, $embed_dir, $item_field, $item_id, $preload, $params);
			}
		}
	}
}

