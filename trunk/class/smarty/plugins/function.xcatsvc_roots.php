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
 * Examples: {xcatsvc_roots tree=$cattree url="./index.php?action=CatView&amp;cat_id=" content=$contentList 
 *                          count=$coutByCat topCat=3 secCat=5 }
 * -------------------------------------------------------------
 */
 
function smarty_function_xcatsvc_roots($params, &$smarty)
{
	if(!(count($params['tree'])>0 && $params['url'] && intval($params['topCat'])>0)){
		return '<div class="xcat_roots"></div>';
	}
	$treeHtml = '' ;
	
	if(isset($params['secCat'])){
		$treeHtml = secCatRootHtml($params) ;
	}else{
		$treeHtml = topCatRootHtml($params) ;
	}

	echo $treeHtml;
}

function secCatRootHtml($params)
{
	$d = $params['tree'][0]['cat_depth'] ;
	$catUrl = $params['url'] ;
	$tempHtml = '<div class="xcat_roots">' ;
	$topCat = intval($params['topCat']);
	$secCat = intval($params['secCat']);
	$width =  $topCat>0 ? intval(100 / $topCat) : 100 ;
	$col_count = $temp_counter = $secCat_counter = 0 ;

	foreach(array_keys($params['tree']) as $key){
		if($d == $params['tree'][$key]['cat_depth']){
			$tempHtml .= '<ul class="catL1" style="float:left;width:'.$width.'%;';
			$tempHtml .= ( $col_count % $topCat == 0 ) ? 'clear:both;' : '' ;
			$tempHtml .= '">';
		}
	
		if($params['tree'][$key]['cat_depth']-$d < 2){
			if($params['tree'][$key]['cat_depth']-$d==1){
				if($secCat_counter < $secCat){
					if($secCat_counter==0) $tempHtml .= '<ul class="catL2">' ;
					if($secCat_counter > 0 && $secCat_counter < $secCat) $tempHtml .= '<li>,&nbsp;</li>' ;
					$tempHtml .= '<li>' ;
				
					$tempHtml .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
					$tempHtml .= $params['tree'][$key]['cat_title'] ;
					$tempHtml .= '</a></li>' ;
				}elseif($secCat_counter == $secCat){
					$tempHtml .= '<li>..</li>' ;
				}
				$secCat_counter++ ;
			}else{
				$tempHtml .= '<li>' ;
				$tempHtml .= '<a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
				$tempHtml .= $params['tree'][$key]['cat_title'] ;
				if(isset($params['count'])){
					if($d == $params['tree'][$key]['cat_depth']) $tempHtml .= " (%%%%)" ;
				}
				$tempHtml .= '</a></li>' ;
			}
		}
		if(isset($params['count'])) $temp_counter += intval(@$params['count'][$params['tree'][$key]['cat_id']]) ;

		if(!isset($params['tree'][$key+1]['cat_depth']) || $d == intval($params['tree'][$key+1]['cat_depth'])){
			if($secCat_counter > 0) $tempHtml .= "</ul>" ;
			$tempHtml .= "</ul>" ;
			$col_count++ ;
			$tempHtml = str_replace('%%%%' , $temp_counter , $tempHtml);
			$temp_counter = $secCat_counter = 0 ;
		}
	}

	$tempHtml .= '</div><br style="clear:both;" />' ;
	return $tempHtml ;
}

function topCatRootHtml($params)
{
	$d = $params['tree'][0]['cat_depth'] ;
	$catUrl = $params['url'] ;
	$tempHtml = '<div class="xcat_roots">' ;
	$topCat = $params['topCat'] ;
	$width =  $topCat>0 ? intval(100 / $topCat) : 100 ;
	$col_count = 0 ;
	$depth = array();
	
	foreach(array_keys($params['tree']) as $key){
		if($d == $params['tree'][$key]['cat_depth']){
			$tempHtml .= '<ul class="catL1" style="float:left;width:"'.$width.'%">';
		}
		if($d < $params['tree'][$key]['cat_depth']){
			if(!isset($depth[$params['tree'][$key]['cat_depth']])){
				$tempHtml .= '<ul class="catL'.intval($params['tree'][$key]['cat_depth']-$d+1).'">';
				$depth[$params['tree'][$key]['cat_depth']] = true ;
			}
		}
		$tempHtml .= '<li><a href="'. sprintf($catUrl, $params['tree'][$key]['cat_id']) .'">' ;
		$tempHtml .= $params['tree'][$key]['cat_title'] ;
		if(isset($params['count'])){
			$tempHtml .= " (".intval(@$params['count'][$params['tree'][$key]['cat_id']]).")" ;
		}
		$tempHtml .= '</a></li>' ;
		if(intval(@$params['tree'][$key+1]['cat_depth']) < $params['tree'][$key]['cat_depth']){
			$tempHtml .= "</ul>" ;
			$depth[$params['tree'][$key]['cat_depth']] = NULL ;
		}
		if($d == intval(@$params['tree'][$key+1]['cat_depth'])){
			$tempHtml .= "</ul>" ;
			$col_count++ ;
		}
	}

	$tempHtml .= '</div>' ;
	$tempHtml .= '<br style="clear:both;" />' ;
	return $tempHtml ;
}

?>
