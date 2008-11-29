<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZFORUM_TRUST_PATH . '/class/AbstractListAction.class.php';
require_once BIZFORUM_TRUST_PATH . '/class/FeedGenerator.class.php';

/**
 * Bizforum_PostListAction
**/
class Bizforum_PostRssAction extends Bizforum_AbstractListAction
{
	var $mFeed = null;

	var $mCatTitle = "";
	var $mCatPath = array();

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizforum_PostHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'post');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizforum_PostFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizforum_PostFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'post',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
    }

	function prepare()
	{
		if($this->mModule->getModuleConfig('show_rss')!=1){
			$this->mRoot->mController->executeRedirect('./index.php?action=TopicList', 1, _MD_BIZFORUM_ERROR_NOT_PERMITTED);
		}
	}

    /**
     * _getBaseUrl
     * 
     * @param   void
     * 
     * @return  string
    **/
    protected function _getBaseUrl()
    {
        return './rss.php?action=PostRss';
    }

	/**
	 * @public
	 */
	function getDefaultView()
	{
		/*-----------------------------------------------------------
		  create POST RSS Feed
		-----------------------------------------------------------*/
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
		$criteria->setSort('reg_unixtime', "DESC");
	
		$this->mObjects =& $handler->getObjects($criteria);
		$userHandler =& xoops_gethandler('member');
		foreach(array_keys($this->mObjects) as $key)
		{
			$this->mObjects[$key]->loadTopic($this->mAsset->mDirname);
			$postRssArr['title'][$key] = "Re:". $this->mObjects[$key]->mTopic->getShow('topic_title');
			$postRssArr['link'][$key] = XOOPS_URL. '/modules/'. $this->mAsset->mDirname .'/index.php?action=PostList&amp;topic_id='. $this->mObjects[$key]->getShow('topic_id');
			$postRssArr['guid'][$key] = XOOPS_URL. '/modules/'. $this->mAsset->mDirname .'/index.php?action=PostList&amp;topic_id='. $this->mObjects[$key]->getShow('topic_id');
			$postRssArr['pubDate'][$key] = $this->mObjects[$key]->getShow('reg_unixtime');
			if($this->mObjects[$key]->getShow('uid')>0){
				$user = $userHandler->getUser($this->mObjects[$key]->getShow('uid'));
				$postRssArr['author'][$key] = $user->getShow('uname');
			}
			else{
				$postRssArr['author'][$key] = $this->mObjects[$key]->getShow('guest_name');
			}
			$postRssArr['category'][$key] = '';
			$postRssArr['description'][$key] = htmlspecialchars($this->mObjects[$key]->get('bodytext'), ENT_QUOTES);
		}
		$this->mFeed = new Bizforum_FeedGenerator($this->mAsset->mDirname, 20);
		$this->mFeed->addItems($postRssArr);
	
		/*-----------------------------------------------------------
		  create TOPIC RSS Feed
		-----------------------------------------------------------*/
		$topicHandler =& $this->mAsset->getObject('handler', 'topic');
		$topicCriteria = new CriteriaCompo('1', '1');
		$topicCriteria->setSort('reg_unixtime', "DESC");
		$topicCriteria->setLimit('20');
	
		$topicArr =& $topicHandler->getObjects($topicCriteria);
		foreach(array_keys($topicArr) as $keyT)
		{
			$topicRssArr['title'][$keyT] = $topicArr[$keyT]->getShow('topic_title');
			$topicRssArr['link'][$keyT] = XOOPS_URL. '/modules/'. $this->mAsset->mDirname .'/index.php?action=PostList&amp;topic_id='. $topicArr[$keyT]->getShow('topic_id');
			$topicRssArr['guid'][$keyT] = XOOPS_URL. '/modules/'. $this->mAsset->mDirname .'/index.php?action=PostList&amp;topic_id='. $topicArr[$keyT]->getShow('topic_id');
			$topicRssArr['pubDate'][$keyT] = $topicArr[$keyT]->getShow('reg_unixtime');
			if($this->mObjects[$key]->getShow('uid')>0){
				$user = $userHandler->getUser($this->mObjects[$key]->getShow('uid'));
				$topicRssArr['author'][$keyT] = $user->getShow('uname');
			}
			else{
				$topicRssArr['author'][$keyT] = $this->mObjects[$key]->getShow('guest_name');
			}
			$topicRssArr['category'][$keyT] = '';
			$topicRssArr['description'][$keyT] = htmlspecialchars($topicArr[$keyT]->get('bodytext'), ENT_QUOTES);
		}
		$this->mFeed->addItems($topicRssArr);
	
		return BIZFORUM_FRAME_VIEW_INDEX;
	}

    /**
     * executeViewIndex
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
		//RSS Data create
		$this->mFeed->display("post");
	}
}

?>
