<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     coupons
 * Version:  1.0
 * Date:     2008.2.25
 * Author:   wye
 * Purpose:  
 * Input:    
 * 
 * Examples: {coupons cp_dir=coupons embed_dir=links item_field=lid item_id=1 mode=(display or form)}
 * -------------------------------------------------------------
 */

function smarty_function_coupons($params, &$smarty)
{
  $cp_dir     = isset( $params['cp_dir'] )     ? $params['cp_dir'] : '' ;
  $embed_dir  = isset( $params['embed_dir'] )  ? $params['embed_dir'] : '' ;
  $item_field = isset( $params['item_field'] ) ? $params['item_field'] : '' ;
  $item_id    = isset( $params['item_id'] )    ? intval($params['item_id']) : 0 ;
  $mode       = isset( $params['mode'] )       ? $params['mode'] : 0 ;

  if( $item_id==0 || ! preg_match( '/^[0-9a-zA-Z_-]+$/' , $cp_dir ) || ! preg_match( '/^[0-9a-zA-Z_-]+$/' , $embed_dir ) || ($mode!='display'&&$mode!='form') ) {
    echo "<p>coupons does not set properly.</p>" ;
  } else {
    if( file_exists(XOOPS_TRUST_PATH."/modules/$cp_dir/include/embed.php") ){
      require_once XOOPS_TRUST_PATH."/modules/$cp_dir/include/embed.php" ;
      if( $mode=='display' ){
        coupons_embed_display( $cp_dir , $embed_dir , $item_field , $item_id ) ;
      }elseif( $mode=='form' ){
        coupons_embed_form( $cp_dir , $embed_dir , $item_field , $item_id ) ;
      }
    }

  }
}

?>