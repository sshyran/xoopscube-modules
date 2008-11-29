<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

/*------------------------------------------------------------------------
RSS2 Generator
------------------------------------------------------------------------*/

function rssCreate($arrRss, $title, $limit=10) {
	
	if (function_exists('mb_http_output')) {
		mb_http_output('pass');
	}
	header ('Content-Type:text/xml; charset=utf-8');
	$tpl = new XoopsTpl();
//	$tpl->xoops_setCaching(2);
//	$tpl->xoops_setCacheTime(3600);
	if (!$tpl->is_cached("db:{dirname}_rss.html")) {
		$tpl->assign('channel_title', xoops_utf8_encode($title));
		$tpl->assign('channel_link', XOOPS_URL.'/modules/dbkmarken/');
		$tpl->assign('channel_desc', "Dbkmarken");
		$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
		$tpl->assign('channel_webmaster', '');
		$tpl->assign('channel_editor', '');
		$tpl->assign('channel_category', 'bookmark');
		$tpl->assign('channel_generator', 'XOOPS/Dbkmarken');
		$tpl->assign('channel_language', _LANGCODE);
		$tpl->assign('image_url', '');
		/*
		$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/banners/banner_trpgsearch.png');
		if (empty($dimention[0])) {
			$width = 88;
		} else {
			$width = ($dimention[0] > 144) ? 144 : $dimention[0];
		}
		if (empty($dimention[1])) {
			$height = 31;
		} else {
			$height = ($dimention[1] > 400) ? 400 : $dimention[1];
		}
		$tpl->assign('image_width', $width);
		$tpl->assign('image_height', $height);
		*/
		if (is_array($arrRss['title'])) {
		
			//guid で並べ替えシングル化
			array_multisort($arrRss['guid'], SORT_ASC, $arrRss['title'], $arrRss['link'], $arrRss['pubDate'], $arrRss['author'], $arrRss['category'], $arrRss['description']);
			$m = 0;
			$n = 0;
			$guid = "";
			foreach(array_keys($arrRss['title']) as $key){
				if($arrRss['guid'][$key] == $guid){
				}else{
					$rssArr['title'][$n] = $arrRss['title'][$key];
					$rssArr['link'][$n] = $arrRss['link'][$key];
					$rssArr['pubDate'][$n] = $arrRss['pubDate'][$key];
					$rssArr['guid'][$n] = $arrRss['guid'][$key];
					$rssArr['author'][$n] = $arrRss['author'][$key];
					$rssArr['category'][$n] = $arrRss['category'][$key];
					$rssArr['description'][$n] = $arrRss['description'][$key];
					$guid = $arrRss['guid'][$key];
					$n++;
				}
			}
		
			//reg_unixtime で並べ替える
			array_multisort($rssArr['pubDate'], SORT_DESC, $rssArr['title'], $rssArr['link'], $rssArr['guid'], $rssArr['author'], $rssArr['category'], $rssArr['description']);
			$n = 0;
			for($m = 0; $m < count($rssArr['title']) && $m < $limit; $m++) {
				if($rssArr['title'][$n] != "") {
					$tpl->append('items', array(
						'title' => xoops_utf8_encode($rssArr['title'][$n]), 
						'link' => $rssArr['link'][$n], 
						'guid' => $rssArr['guid'][$n], 
						'pubdate' => formatTimestamp($rssArr['pubDate'][$n], 'rss'), 
						'author' => xoops_utf8_encode($rssArr['author'][$n]), 
						'category' => xoops_utf8_encode($rssArr['category'][$n]), 
						'description' => xoops_utf8_encode($rssArr['description'][$n])));
					$n++;
				}
			}
		}

	}
	return $tpl;
}

/*------------------------------------------------------------------------
Convert special characters in tag
------------------------------------------------------------------------*/

function unescapeTag($tag)
{
	$tag = preg_replace('/&amp;/', "&", $tag);
	$tag = preg_replace('/&lt;/', "<", $tag);
	$tag = preg_replace('/&gt;/', ">", $tag);
	$tag = preg_replace('/&#39;/', "'", $tag);
	$tag = preg_replace('/&quot;/', "\"", $tag);
	return $tag;
}

?>
