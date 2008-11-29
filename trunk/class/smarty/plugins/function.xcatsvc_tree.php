<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     xcatsvc_tree
 * Version:  1.0
 * Date:     Mar 28, 2008
 * Author:   HIKAWA Kilica
 * Purpose:  
 * Input:    tree=xoopstree object
 *           content=array(cat_id, link_url, link_title)	:must be sanitized
 * Examples: {xcatsvc_tree tree=$cattree url="./index.php?action=CatView&amp;cat_id=" content=$contentList count=$countByCat}
 * -------------------------------------------------------------
 */
 
function smarty_function_xcatsvc_tree($params, &$smarty)
{
	if(! $params['tree'][0]){
		return '<div class="xcat_tree"></div>';
	}
	$d = $params['tree'][0]['cat_depth'];	//depth of tree
	$treeHtml = '<div class="xcat_tree"><ul class="catL1">';
	$catUrl = $params['url'];
	
	foreach(array_keys($params['tree']) as $key){
		if($d < $params['tree'][$key]['cat_depth']){
			$treeHtml .= '<ul class="catL'. $params['tree'][$key]['cat_depth'] .'">';
			//create content list html if exist
			if($params['content']){
				$html = createContentListHtml($html, $params['content'], $params[$tree][$key]['cat_id']);
			}
		}
		elseif($d > $params['tree'][$key]['cat_depth']){
			for($i=0; $i < $d-$params['tree'][$key]['cat_depth'];$i++){
				$treeHtml .= '</ul>';
			}
		}
		$treeHtml .= '<li>';
		if($params['tree'][$key]['permit']==1&&$catUrl!=""){
			$treeHtml .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">';
			$treeHtml .= $params['tree'][$key]['cat_title'];
			if(isset($params['count'])){
				$treeHtml .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
			}
			$treeHtml .= '</a>';
		}
		//if deleted by permission reasons, don't make a link.
		else{
			$treeHtml .= $params['tree'][$key]['cat_title'];
			if(isset($params['count'])){
				$treeHtml .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
			}
		}
		$treeHtml .= '</li>';

		$d = $params['tree'][$key]['cat_depth'];
	}
	for($i=0; $i < $params['tree'][$key]['cat_depth']-$params['tree'][0]['cat_depth'];$i++){
		$treeHtml .= '</ul>';
	}

	$treeHtml .= '</ul></div>';

	echo $treeHtml;
}

function createContentListHtml($html, $contentArr, $catId)
{
	$catIds = array_keys($contentArr['cat_id'], $catId);
	if(count($catIds)>0){
		$html .= '<ul class="catContent">';
		foreach(array_keys($catIds) as $key){
			$html .= '<li><a href="'. $contentArr['link_url'][$catIds[$key]] .'">' . $contentArr['link_title'][$catIds[$key]] .'</a></li>';
		}
		$html .= '</ul>';
	}
	return $html;
}

?>
