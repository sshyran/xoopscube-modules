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
require_once BIZFORUM_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizforum_TopicListAction
**/
class Bizforum_TopicListAction extends Bizforum_AbstractListAction
{
    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizforum_TopicHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'topic');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizforum_TopicFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizforum_TopicFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'topic',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
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
        return './index.php?action=TopicList';
    }

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
	
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		$this->mCatId = intval($this->mRoot->mContext->mRequest->getRequest('cat_id'));
		
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
	
		//get permitted categories to show
		$idArr = $xcatHandler->getPermitCatIds($this->mCatId, $xcatHandler->getPermitTitle('viewer'));
	
		$childCriteria = new CriteriaCompo('1', '1');
		if($this->mCatId > 0){
			if($xcatHandler->checkPermit($this->mCatId, $xcatHandler->getPermitTitle('viewer'))){
				$childCriteria->add(new Criteria('cat_id', $this->mCatId), 'OR');
			}
		}
		else{
			foreach(array_keys($idArr) as $key){
				$childCriteria->add(new Criteria('cat_id', $idArr[$key]), 'OR');
			}
		}
		$criteria->add($childCriteria);
	
		$this->mObjects =& $handler->getObjects($criteria);
		foreach(array_keys($this->mObjects) as $keyL){
			$this->mObjects[$keyL]->loadLastPost($this->mAsset->mDirname);
			$this->mObjects[$keyL]->countPost($this->mAsset->mDirname);
		}
	
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
		$xcatHandler = new Bizforum_XcatHandler($this->mAsset->mDirname);
		$catTitleList = $xcatHandler->getTitleList();
	
        $render->setTemplateName($this->mAsset->mDirname . '_topic_list.html');
        #cubson::lazy_load_array('topic', $this->mObjects);
        $render->setAttribute('objects', $this->mObjects);
        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
        $render->setAttribute('catTitleList', $catTitleList);
        $render->setAttribute('catId', $this->mCatId);
        if($this->mModule->getModuleConfig('show_rss')){
        	$render->setAttribute('flgShowRSS', 1);
        }
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
        if($this->mModule->getModuleConfig('show_rss')){
			$moduleHeader .= '<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?action=PostRss">';
		}
		$render->setAttribute('xoops_module_header', $moduleHeader);
    }
}

?>
