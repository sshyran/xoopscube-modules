<?php

require_once XOOPS_TRUST_PATH.'/modules/pico/include/common_functions.php' ;
require_once XOOPS_TRUST_PATH.'/modules/pico/blocks/list.php' ;

function smarty_function_pico_list( $params , &$smarty )
{
	$mydirname = @$params['dir'] . @$params['dirname'] ;
	$cat_ids = @$params['id'] . @$params['cat_id'] ;
	$limit = intval( @$params['limit'] ) ;
	$template = @$params['template'] ;
	$var_name = @$params['item'] . @$params['assign'] ;

	if( empty( $mydirname ) ) $mydirname = $smarty->get_template_vars( 'mydirname' ) ;
	if( empty( $mydirname ) ) {
		echo 'error '.__FUNCTION__.' [specify dirname]';
		return ;
	}

	require_once XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/blocks/blocks.php' ;

	if( $var_name ) {
		// just assign
		$assigns = b_pico_list_show( array( $mydirname , $cat_ids , 'o.weight' , $limit > 0 ? $limit : 999 , $template , 'disable_renderer' => true ) ) ;
		$smarty->assign( $var_name , $assigns ) ;
	} else {
		// display
		$block = b_pico_list_show( array( $mydirname , $cat_ids , 'o.weight' , $limit > 0 ? $limit : 999 , $template ) ) ;
		echo @$block['content'] ;
	}
}

?>