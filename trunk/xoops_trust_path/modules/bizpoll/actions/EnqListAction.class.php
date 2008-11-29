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
require_once BIZPOLL_TRUST_PATH . '/class/XcatHandler.class.php';

/**
 * Bizpoll_EnqListAction
**/
class Bizpoll_EnqListAction extends Bizpoll_AbstractListAction
{
	var $mCatId = 0;
	var $mCatTitleList = array();
	var $mUseCat = false;

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  Bizpoll_EnqHandler
    **/
    protected function &_getHandler()
    {
        $handler =& $this->mAsset->getObject('handler', 'enq');
        return $handler;
    }

    /**
     * &_getFilterForm
     * 
     * @param   void
     * 
     * @return  Bizpoll_EnqFilterForm
    **/
    protected function &_getFilterForm()
    {
        // $filter =& new Bizpoll_EnqFilterForm();
        $filter =& $this->mAsset->getObject('filter', 'enq',false);
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
        return './index.php?action=EnqList';
    }

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mUseCat = ($this->mModule->getModuleConfig('gr_id')>0) ? true : false;
	
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
		$this->mCatId = intval($this->mRoot->mContext->mRequest->getRequest('cat_id'));
	
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
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    public function executeViewIndex(/*** XCube_RenderTarget ***/ &$render)
    {
        $render->setTemplateName($this->mAsset->mDirname . '_enq_list.html');
        #cubson::lazy_load_array('enq', $this->mObjects);
        $render->setAttribute('objects', $this->mObjects);
        $render->setAttribute('pageNavi', $this->mFilter->mNavi);

        $render->setAttribute('catTitleList', $this->mCatTitleList);
        $render->setAttribute('catId', $this->mCatId);
        $render->setAttribute('useCat', $this->mUseCat);
        if($this->mModule->getModuleConfig('show_rss')){
        	$render->setAttribute('flgShowRSS', 1);
        }
		$render->setAttribute('useEditor', $this->mModule->getModuleConfig('editor'));
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
        if($this->mModule->getModuleConfig('show_rss')){
			$moduleHeader .= '<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php?action=EnqRss">';
		}
		$render->setAttribute('xoops_module_header', $moduleHeader);
    }

}

?>
