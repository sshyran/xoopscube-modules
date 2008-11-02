<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/cubookmarken/include/getTagCloud.php";

class Cubookmarken_TagListAction extends Cubookmarken_AbstractListAction
{

	var $myCubookmarken = null;
	var $tagCloud = null;
	var $requestTag = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "tag");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Cubookmarken_TagFilterForm();
		$filter =& $this->mAsset->create('filter', "tag");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=TagList";
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
		$bmHandler =& xoops_getmodulehandler('bm');
		foreach(array_keys($this->mObjects) as $key){
			$this->mObjects[$key]->loadBm();
			$this->mObjects[$key]->mBm->loadTag();
			//count users who bookmarks the same url
			$this->mObjects[$key]->mBm->bm_count = $bmHandler->getCount(new Criteria('url', $this->mObjects[$key]->mBm->get('url')));
			//check script insertion attack
			$myts = new MyTextSanitizer();
			if(! $myts->checkUrlString($this->mObjects[$key]->mBm->get('url'))){
				$this->mObjects[$key]->mBm->set('url', "");
				$this->mObjects[$key]->mBm->set('bm_title', "*** This may be bookmarked by attacker ! ***");
			}
		}

		//if filtered by uid, the result cubookmarkens are for specific user's.
		foreach(array_keys($criteria->criteriaElements) as $key2){
			if($criteria->criteriaElements[$key2]->getName() == 'uid'){
				$this->myCubookmarken = 'true';
			}
			if($criteria->criteriaElements[$key2]->getName() == 'tag_name'){
				$this->requestTag[$key2] = xoops_getrequest('tag_name');
			}
		}
		//TagCloud
		$where = "";
		if(xoops_getrequest('uid')){
			$where= 'uid='. intval(xoops_getrequest('uid'));
		}
		$this->tagCloud = getTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'));
	
		return CUBOOKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName("cubookmarken_tag_list.html");
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
	
		$render->setAttribute('tagCloud', $this->tagCloud);
		$render->setAttribute('requestTag', $this->requestTag);
		$render->setAttribute('myCubookmarken', $this->myCubookmarken);
	
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', false);
		}
		else{
			$render->setAttribute('allow_useredit', true);
		}
	
		//set module header
		if($this->mRoot->mContext->mModule->getModuleConfig('css_file')){
			$render->setAttribute('xoops_module_header','<link rel="stylesheet" type="text/css" media="screen" href="'. XOOPS_URL . $this->mRoot->mContext->mModule->getModuleConfig('css_file') .'" />');
		}
	}
}

?>
