<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xcatsvc_catselect
 * Version:  1.0
 * Date:     May 23, 2008
 * Author:   HIKAWA Kilica
 * Purpose:  format xoopstree object fot select
 * Input:    tree=xoopstree array
 *           selectedValue=selected category
 * Examples: {xcatsvc_catselect tree=$cattree selectedValue=$cat_id}
 * -------------------------------------------------------------
 */
 
function smarty_function_xcatsvc_catselect($params, &$smarty)
{
	$selectHtml = '';
	foreach(array_keys($params['tree']) as $key){
		if($params['tree'][$key]['permit']==1){
			$d = $params['tree'][$key]['cat_depth'];	//depth of tree
			if($params['selectedValue']==$params['tree'][$key]['cat_id']){
				$selectHtml .= '<option value="'.$params['tree'][$key]['cat_id'].'" selected="selected">';
			}
			else{
				$selectHtml .= '<option value="' .$params['tree'][$key]['cat_id']. '">';
			}
			for($i=0;$i<$d-1;$i++){
				$selectHtml .= '-';
			}
			$selectHtml .= $params['tree'][$key]['cat_title'] .'</option>';
		}
	}

	echo $selectHtml;
}
?>
