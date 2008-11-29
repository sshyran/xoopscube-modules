<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/getTagCloud.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/function.php";

class Dbkmarken_BmRssAction extends Dbkmarken_AbstractListAction
{

	var $rssArr = null;
	var $requestUid = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "bm");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Dbkmarken_BmFilterForm();
		$filter =& $this->mAsset->getObject('filter', "bm");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=BmRss";
	}

	//kilica	overwrite AbstructActionForm
	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		//sort by registered time
		$handler =& $this->_getHandler();
		$criteria = $this->mFilter->getCriteria();
		$criteria->setSort('reg_unixtime', 'DESC');
		$this->mObjects =& $handler->getObjects($criteria);
		foreach(array_keys($this->mObjects) as $key)
		{
			$this->mObjects[$key]->loadTag($this->mAsset->mDirname);

			$this->rssArr['title'][$key] = $this->mObjects[$key]->getShow('bm_title');
			$this->rssArr['link'][$key] = $this->mObjects[$key]->getShow('url');
			$this->rssArr['guid'][$key] = 'bm'.$this->mObjects[$key]->getShow('bm_id');
			$this->rssArr['pubDate'][$key] = $this->mObjects[$key]->getShow('reg_unixtime');
			$this->rssArr['author'][$key] = $this->mObjects[$key]->getShow('uid');
			$tags = '';
			foreach(array_keys($this->mObjects[$key]->mTag) as $keyT){
				$tags = $tags . '[' . $this->mObjects[$key]->mTag[$keyT]->getShow('tag_name') . ']';
			}
			$this->rssArr['category'][$key] = '';
			$this->rssArr['description'][$key] = $tags.htmlspecialchars($this->mObjects[$key]->get('memo'), ENT_QUOTES);
		}
		
		//if filtered by uid, the result bookmarks are for specific user's.
		$i = 0;
		while($criteria->criteriaElements[$i]){
			if($criteria->criteriaElements[$i]->getName() == 'uid'){
				$this->myDbkmarken = 'true';
				$this->requestUid = $criteria->criteriaElements[$i]->getValue();
			}

			$i++;
		}
		
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		global $xoopsConfig;
	
//		$render->setAttribute('objects', $this->mObjects);

		$channel_title = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES). ' Bookmark';
		//RSS Channel Title
		$channel_title = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES). ' Bookmark';
		if($this->requestUid){
			$handler = xoops_gethandler('user');
			$user =& $handler->getObjects(new Criteria('uid', $this->requestUid));
			
			if($user[0]->getShow('name')){
				$channel_title = $channel_title . ' by ' .$user[0]->getShow('name');
			}
			else{
				$channel_title = $channel_title . ' by ' . $user[0]->getShow('uname');
			}
		}

		//RSS number of output
		$limit = 20;

		//RSS Data create
		$tpl = rssCreate($this->rssArr, $channel_title, $limit);

        $tpl->assign('dirname', $this->mAsset->mDirname);
		$tpl->display("db:".$this->mAsset->mDirname ."_rss.html");

	}
}

?>
