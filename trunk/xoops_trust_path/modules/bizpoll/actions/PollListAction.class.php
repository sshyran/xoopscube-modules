<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once BIZPOLL_TRUST_PATH . '/class/AbstractListAction.class.php';

/**
 * Bizpoll_PollListAction
**/
class Bizpoll_PollListAction extends Bizpoll_AbstractListAction
{
    /**
     * &_getHandler
     * @param   void
     * @return  Bizpoll_PollHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'poll');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizpoll_PollFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizpoll_PollFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'poll',false);
        $filter->prepare($this->_getPageNavi(), $this->_getHandler());
        return $filter;
    }

    /**
     * _getBaseUrl
     * @param   void
     * @return  string
    **/
    protected function _getBaseUrl()
    {
        return './index.php?action=PollList';
    }

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
	
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		$this->mEnqId = intval($this->mRoot->mContext->mRequest->getRequest('enq_id'));
	
		$handler =& $this->_getHandler();
		$criteria=$this->mFilter->getCriteria();
	
		//don't show on the List before published date
		$criteria->add(new Criteria('pub_unixtime', time(), '<'));
	
		//check permissions
		if($this->mUseCat){
			$xcatHandler = new Bizpoll_XcatHandler($this->mAsset->mDirname);
		
			$this->mCatTitleList = $xcatHandler->getTitleList();
		
			$idArr = $xcatHandler->getPermitCatIds($this->mCatId, 'viewer');
		
			$childFlag = false;
			$childCriteria = new CriteriaCompo('1', '1');
			if($this->mCatId > 0){
				if($xcatHandler->checkPermit($this->mCatId, 'viewer')){
					$childCriteria->add(new Criteria('cat_id', $this->mCatId), 'OR');
					$childFlag = true;
				}
			}
			else{
				foreach(array_keys($idArr) as $key){
					$childCriteria->add(new Criteria('cat_id', $idArr[$key]), 'OR');
					$childFlag = true;
				}
			}
			if($childFlag==true){
				$criteria->add($childCriteria);
			}
		}
	
		$criteria->setSort('pub_unixtime', 'DESC');
		$this->mObjects =& $handler->getObjects($criteria);
	
		return BIZPOLL_FRAME_VIEW_INDEX;
	}

    /**
     * executeViewIndex
     * @param   XCube_RenderTarget  &$render
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
        $enqHandler =& $this->mAsset->getObject('handler', 'poll');
        $enq =& $enqHandler->get($$this->mRoot->mContext->mRequest->getRequest('enq_id'));

        $render->setTemplateName($this->mAsset->mDirname . '_poll_list.html');
        $render->setAttribute('objects', $this->mObjects);
        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
    }
}

?>
