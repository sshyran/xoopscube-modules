<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xcat_info
 * Version:  1.0
 * Date:     May 27, 2008
 * Author:   HIKAWA Kilica
 * Purpose:  get category info from category id
 * Input:    id, item
 * Examples: {xcat_info id=$cat_id}
 * -------------------------------------------------------------
 */
 
function smarty_modifier_xcat_info($id, $item='cat_title')
{
	$handler =& xoops_getmodulehandler('cat', 'xcat');
	$cat =& $handler->get(intval($id));

	if(is_object($cat)) {
		return $cat->getShow($item);
	}
	return null;
}
?>
