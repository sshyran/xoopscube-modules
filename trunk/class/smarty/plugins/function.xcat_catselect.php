<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xcat_catselect
 * Version:  1.0
 * Date:     May 23, 2008
 * Author:   HIKAWA Kilica
 * Purpose:  format xoopstree object fot select
 * Input:    tree=xoopstree object
 *           selectedValue=selected category
 * Examples: {xcat_catselect tree=$cattree selectedValue=$cat_id}
 * -------------------------------------------------------------
 */
 
function smarty_function_xcat_catselect($params, &$smarty)
{
	$selectHtml = '';
	foreach(array_keys($params['tree']) as $key){
		if($params['tree'][$key]->mDelFlag==false){
			$d = $params['tree'][$key]->getDepth();	//depth of tree
			if($params['selectedValue']==$d){
				$selectHtml .= '<option value="'.$params['tree'][$key]->get('cat_id').'" selected="selected">';
			}
			else{
				$selectHtml .= '<option value="' .$params['tree'][$key]->get('cat_id'). '">';
			}
			for($i=0;$i<$d-1;$i++){
				$selectHtml .= '-';
			}
			$selectHtml .= $params['tree'][$key]->get('cat_title') .'</option>';
		}
	}

	echo $selectHtml;
}
?>
