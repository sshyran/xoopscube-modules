<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

class Bizforum_FeedGenerator
{
	var $mDirname = '';
	var $mLimit = 10;
	var $mLastBuild = 0;
	var $mTpl = null;
	var $mItemArr = array();

	function Bizforum_FeedGenerator($dirname, $limit=10)
	{
		if (function_exists('mb_http_output')) {
			mb_http_output('pass');
		}
		$this->mDirname = $dirname;
		$this->setChannel();
		$this->_setLimit($limit);
	}

	function setChannel()
	{
		$this->mTpl = new XoopsTpl();
	
		if (!$this->mTpl->is_cached("db:". $this->mDirname ."_rss.html")) {
			$this->mTpl->assign('channel_title', xoops_utf8_encode($this->_getChannelTitle()));
			$this->mTpl->assign('channel_subtitle', xoops_utf8_encode($this->_getChannelSubtitle()));
			$this->mTpl->assign('channel_link', XOOPS_URL.'/modules/'. $this->mDirname .'/');
			$this->mTpl->assign('channel_desc', $this->mDirname);
			$this->mTpl->assign('channel_webmaster', XOOPS_URL);
			$this->mTpl->assign('channel_editor', '');
			$this->mTpl->assign('channel_category', 'rss, feeds');
			$this->mTpl->assign('channel_generator', 'XOOPS Cube Legacy/'. $this->mDirname);
			$this->mTpl->assign('channel_language', _LANGCODE);
		}
	}

	function _getChannelTitle()
	{
		$root =& XCube_Root::getSingleton();
		return htmlspecialchars($root->mContext->getXoopsConfig('sitename'), ENT_QUOTES);
	}

	function _getChannelSubtitle()
	{
        $handler =& Biznews_Utils::getXoopsHandler('module');
		$module =& $handler->getByDirname($this->mDirname);
		return htmlspecialchars($module->get('name'), ENT_QUOTES);
	}

	function _setLimit($limit)
	{
		$this->mLimit = intval($limit);
	}

	function _getLimit()
	{
		return $this->mLimit;
	}

	function setLastBuildDate($unixtime)
	{
		$this->mTpl->assign('channel_lastbuild', formatTimestamp($unixtime, 'rss'));
	}

	function addItems($rssArr)
	{
		$oldArr = $this->mItemArr;
		$this->mItemArr = array_merge_recursive($oldArr, $rssArr);
	}

	function _createItem()
	{
		if (is_array($this->mItemArr['title'])) {
			//reg_unixtime ¤ÇÊÂ¤ÙÂØ¤¨¤ë
			if(! array_multisort(
				$this->mItemArr['pubDate'], SORT_DESC, 
				$this->mItemArr['title'], 
				$this->mItemArr['link'], 
				$this->mItemArr['guid'], 
				$this->mItemArr['author'], 
				$this->mItemArr['category'], 
				$this->mItemArr['description']
			)){
				print "error";die();
			}
		}
		$m = 0;
		for($m = 0; $m<count($this->mItemArr['title']) && $m<$this->_getLimit(); $m++) {
			$this->mTpl->append('items', array(
				'title' => xoops_utf8_encode($this->mItemArr['title'][$m]), 
				'link' => $this->mItemArr['link'][$m], 
				'guid' => $this->mItemArr['guid'][$m], 
				'pubdate' => formatTimestamp($this->mItemArr['pubDate'][$m], 'rss'), 
				'author' => xoops_utf8_encode($this->mItemArr['author'][$m]), 
				'category' => xoops_utf8_encode($this->mItemArr['category'][$m]), 
				'description' => xoops_utf8_encode($this->mItemArr['description'][$m]))
			);
			if($this->mItemArr['pubDate'][$m] > $this->mLastBuild){
				$this->mLastBuild = $this->mItemArr['pubDate'][$m];
			}
		}
	}

	function display($table)
	{
		$this->_createItem();
		header ('Content-Type:text/xml; charset=utf-8');
		$this->mTpl->display("db:". $this->mDirname ."_". $table . "_rss.html");
	}

}

?>
