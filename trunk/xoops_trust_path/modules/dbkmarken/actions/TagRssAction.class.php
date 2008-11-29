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

class Dbkmarken_TagRssAction extends Dbkmarken_AbstractListAction
{
	var $rssArr = null;
	var $myDbkmarken = null;
	var $requestTag = null;
	var $requestUid = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "tag");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Dbkmarken_TagFilterForm();
		$filter =& $this->mAsset->getObject('filter', "tag");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=TagRss";
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

		//if filtered by uid, the result dbkmarkens are for specific user's.
		$i = 0;
		while($criteria->criteriaElements[$i]){
			if($criteria->criteriaElements[$i]->getName() == 'uid'){
				$this->myDbkmarken = 'true';
				$this->requestUid = $criteria->criteriaElements[$i]->getValue();
			}
			if($criteria->criteriaElements[$i]->getName() == 'tag_name'){
				$this->requestTag[$i] = $criteria->criteriaElements[$i]->getValue();
			}
			$i++;
		}

		$bmHandler =& $this->mAsset->getObject('handler', "tag");
		foreach(array_keys($this->mObjects) as $key){
			$this->mObjects[$key]->loadBm($this->mAsset->mDirname);
			$this->mObjects[$key]->mBm->loadTag($this->mAsset->mDirname);

			$this->rssArr['title'][$key] = $this->mObjects[$key]->mBm->getShow('bm_title');
			$this->rssArr['link'][$key] = $this->mObjects[$key]->mBm->getShow('url');
			$this->rssArr['guid'][$key] = 'bm'.$this->mObjects[$key]->getShow('bm_id');
			$this->rssArr['pubDate'][$key] = $this->mObjects[$key]->mBm->getShow('reg_unixtime');
			$this->rssArr['author'][$key] = $this->mObjects[$key]->getShow('uid');
			$tags = '';
			foreach(array_keys($this->mObjects[$key]->mBm->mTag) as $keyT){
				$tags = $tags . '[' . $this->mObjects[$key]->mBm->mTag[$keyT]->getShow('tag_name') . ']';
			}
			$this->rssArr['category'][$key] = '';
			$this->rssArr['description'][$key] = $tags.htmlspecialchars($this->mObjects[$key]->mBm->get('memo'), ENT_QUOTES);
		}
		
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{

		global $xoopsConfig;

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
		foreach(array_keys($this->requestTag) as $key){
			$channel_title = $channel_title . ' [' . $this->mRoot->mContext->mRequest->getRequest('tag_name') . ']';
		}

		//RSS number of output
		$limit = 20;

		//RSS Data create
		$tpl = rssCreate(& $this->rssArr, & $channel_title, & $limit);

        $tpl->assign('dirname', $this->mAsset->mDirname);
		$tpl->display("db:". $this->mAsset->mDirname . "_rss.html");

	}
}

?>
