<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xcat_tree
 * Version:  1.1
 * Date:     Mar 28, 2008 / Jul 11, 2008
 * Author:   HIKAWA Kilica
 * Purpose:  format xoopstree object
 * Input:    tree=xoopstree object
 *           control=bool   :display control(edit,delete,add child) or not
 * Examples: {xcat_tree tree=$cattree control=false}
 * -------------------------------------------------------------
 */
 
function smarty_function_xcat_tree($params, &$smarty)
{
	if(! $params['tree'][0]){
		return '<div class="xcat_tree"></div>';
	}
	$d = $params['tree'][0]->getDepth();	//depth of tree
	$treeHtml = '<div class="xcat_tree"><ul>';
	foreach(array_keys($params['tree']) as $key){
		if($d < $params['tree'][$key]->getDepth()){
			$treeHtml .= '<ul class="catL'. $params['tree'][$key]->getDepth() .'">';
			$treeHtml .= '<li><a href="./index.php?action=CatView&amp;cat_id='.$params['tree'][$key]->getShow('cat_id').'">'. $params['tree'][$key]->getShow('cat_title') .'</a>';
		}
		elseif($d == $params['tree'][$key]->getDepth()){
			$treeHtml .= '<li><a href="./index.php?action=CatView&amp;cat_id='.$params['tree'][$key]->getShow('cat_id').'">'. $params['tree'][$key]->getShow('cat_title') .'</a>';
		}
		elseif($d > $params['tree'][$key]->getDepth()){
			for($i=0; $i < $d-$params['tree'][$key]->getDepth();$i++){
				$treeHtml .= '</ul>';
			}
			$treeHtml .= '<li><a href="./index.php?action=CatView&amp;cat_id='.$params['tree'][$key]->getShow('cat_id').'">'. $params['tree'][$key]->getShow('cat_title') .'</a>';
		}
		//create content list html if exist
		if($params['control']==true){
			$treeHtml .= ' &nbsp; <a href="'. XOOPS_URL .'/modules/xcat/index.php?action=CatEdit&amp;cat_id='.$params['tree'][$key]->getShow('cat_id').'"><img src="'. XOOPS_URL .'/images/icons/edit.gif" alt="'. _EDIT .'" /></a> <a href="'. XOOPS_URL .'/modules/xcat/index.php?action=CatDelete&amp;cat_id='.$params['tree'][$key]->getShow('cat_id').'"><img src="'. XOOPS_URL .'/images/icons/delete.gif" alt="'. _DELETE .'" /></a> [<a href="'. XOOPS_URL .'/modules/xcat/index.php?action=CatEdit&amp;p_id='.$params['tree'][$key]->getShow('cat_id').'">+ CHILD</a>]';
		}
		$treeHtml .= '</li>';
		$d = $params['tree'][$key]->getDepth();
	}
	for($i=0; $i < $params['tree'][$key]->getDepth()-$params['tree'][0]->getDepth();$i++){
		$treeHtml .= '</ul>';
	}

	$treeHtml .= '</ul></div>';

	echo $treeHtml;
}


?>
