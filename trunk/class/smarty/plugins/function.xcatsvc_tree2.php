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
 * Examples: {xcatsvc_tree tree=$cattree url="./index.php?action=CatView&amp;cat_id=" content=$contentList}
 * -------------------------------------------------------------
 * MOD     : wye 
 * Date    : 2008.7.5
 * Examples: {xcatsvc_tree2 tree=$cattree url="./index.php?action=CatView&amp;cat_id=" content=$contentList 
 *                          count=$coutByCat cols=3 next=5 }
 * -------------------------------------------------------------
 */
 
function smarty_function_xcatsvc_tree2($params, &$smarty)
{
	if(!(count($params['tree'])>0 && $params['url'])){
		return '<div class="xcat_tree"></div>';
	}
	$treeHtml = '' ;
	
	if(intval($params['cols'])>0){
		if(isset($params['next'])){
			$treeHtml = nextTreeHtml($params) ;
		}else{
			$treeHtml = colsTreeHtml($params) ;
		}
	}else{
		$treeHtml = basicTreeHtml($params) ;
	}

	echo $treeHtml;
}

function nextTreeHtml($params)
{
	$d = $params['tree'][0]['cat_depth'] ;
	$catUrl = $params['url'] ;
	$tempHTML = '<div class="xcat_tree">' ;
	$cols = $params['cols'] ;
	$next = $params['next'] ;
	$col_count = $temp_counter = $next_counter = 0 ;

	foreach(array_keys($params['tree']) as $key){
		if($d == $params['tree'][$key]['cat_depth']){
			$tempHTML .= '<ul class="catL1">';
		}

		if($params['tree'][$key]['cat_depth']-$d < 2){
			if($params['tree'][$key]['cat_depth']-$d==1){
				if($next_counter < $next){
					if($next_counter==0) $tempHTML .= '<ul class="catL2">' ;
					if($next_counter > 0 && $next_counter < $next) $tempHTML .= '<li>,&nbsp;</li>' ;
					$tempHTML .= '<li>' ;
				
					$tempHTML .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
					$tempHTML .= $params['tree'][$key]['cat_title'] ;
					$tempHTML .= '</a></li>' ;
				}elseif($next_counter == $next){
					$tempHTML .= '<li>..</li>' ;
				}
				$next_counter++ ;
			}else{
				$tempHTML .= '<li>' ;
				$tempHTML .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
				$tempHTML .= $params['tree'][$key]['cat_title'] ;
				if(isset($params['count'])){
					if($d == $params['tree'][$key]['cat_depth']) $tempHTML .= " (%%%%)" ;
				}
				$tempHTML .= '</a></li>' ;
			}
		}
		if(isset($params['count'])) $temp_counter += intval(@$params['count'][$params['tree'][$key]['cat_id']]) ;

		if(!isset($params['tree'][$key+1]['cat_depth']) || $d == intval($params['tree'][$key+1]['cat_depth'])){
			if($next_counter > 0) $tempHTML .= "</ul>" ;
			$tempHTML .= "</ul>" ;
			$col_count++ ;
			$tempHTML = str_replace('%%%%' , $temp_counter , $tempHTML);
			$temp_counter = $next_counter = 0 ;
		}
	}

	$tempHTML .= '</div><br style="clear:both;" />' ;
	return $tempHTML ;
}

function colsTreeHtml($params)
{
	$d = $params['tree'][0]['cat_depth'] ;
	$catUrl = $params['url'] ;
	$tempHTML = '<div class="xcat_tree"">' ;
	$cols = $params['cols'] ;
	$col_count = 0 ;
	$depth = array();
	
	foreach(array_keys($params['tree']) as $key){
		if($d == $params['tree'][$key]['cat_depth']){
			$tempHTML .= '<ul class="catL1">';
		}
		if($d < $params['tree'][$key]['cat_depth']){
			if(!isset($depth[$params['tree'][$key]['cat_depth']])){
				$tempHTML .= '<ul class="catL'.intval($params['tree'][$key]['cat_depth']-$d+1).'">';
				$depth[$params['tree'][$key]['cat_depth']] = true ;
			}
		}
		$tempHTML .= '<li><a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
		$tempHTML .= $params['tree'][$key]['cat_title'] ;
		if(isset($params['count'])){
			$tempHTML .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
		}
		$tempHTML .= '</a></li>' ;
		if(intval(@$params['tree'][$key+1]['cat_depth']) < $params['tree'][$key]['cat_depth']){
			$tempHTML .= "</ul>" ;
			$depth[$params['tree'][$key]['cat_depth']] = NULL ;
		}
		if($d == intval(@$params['tree'][$key+1]['cat_depth'])){
			$tempHTML .= "</ul>" ;
			$col_count++ ;
		}
	}

	$tempHTML .= '</div>' ;
	$tempHTML .= '<br style="clear:both;" />' ;
	return $tempHTML ;
}

function basicTreeHtml($params)
{
	$d = $params['tree'][0]['cat_depth'];	//start depth of tree
	$catUrl = $params['url'];
	$tempHTML = '<div class="xcat_tree"><ul class="catL1">';
	foreach(array_keys($params['tree']) as $key){
		if($d < $params['tree'][$key]['cat_depth']){
			$tempHTML .= '<ul class="catL'. $params['tree'][$key]['cat_depth'] .'">';
			//create content list html if exist
			if($params['content']){
				$html = createContentListHtml($html, $params['content'], $params[$tree][$key]['cat_id']);
			}
		}
		elseif($d > $params['tree'][$key]['cat_depth']){
			for($i=0; $i < $d-$params['tree'][$key]['cat_depth'];$i++){
				$tempHTML .= '</ul>';
			}
		}
		$tempHTML .= '<li>';
		if($params['tree'][$key]['permit']==1&&$catUrl!=""){
			$tempHTML .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">';
			$tempHTML .= $params['tree'][$key]['cat_title'];
			if(isset($params['count'])){
				$tempHTML .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
			}
			$tempHTML .= '</a>';
		}
		//if deleted by permission reasons, don't make a link.
		else{
			$tempHTML .= $params['tree'][$key]['cat_title'];
			if(isset($params['count'])){
				$tempHTML .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
			}
		}
		$tempHTML .= '</li>';

		$d = $params['tree'][$key]['cat_depth'];
	}
	for($i=0; $i < $params['tree'][$key]['cat_depth']-$params['tree'][0]['cat_depth'];$i++){
		$tempHTML .= '</ul>';
	}
	$tempHTML .= '</ul></div>';
	return $tempHTML ;
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
