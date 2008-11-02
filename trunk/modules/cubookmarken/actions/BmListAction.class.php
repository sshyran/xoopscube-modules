<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/cubookmarken/include/getTagCloud.php";

class Cubookmarken_BmListAction extends Cubookmarken_AbstractListAction
{

	var $myCubookmarken = null;
	var $tagCloud = null;
	var $userArr = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "bm");
		return $handler;
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
		// $filter =& new Cubookmarken_BmFilterForm();
		$filter =& $this->mAsset->create('filter', "bm");
		$filter->prepare($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	/**
	 * @protected
	 */
	function _getBaseUrl()
	{
		return "./index.php?action=BmList";
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
			$this->mObjects[$key]->loadTag();
			//count users who bookmarks the same url
			$this->mObjects[$key]->bm_count = $handler->getCount(new Criteria('url', $this->mObjects[$key]->get('url')));
			//check script insertion attack
			$myts = new MyTextSanitizer();
			if(! $myts->checkUrlString($this->mObjects[$key]->get('url'))){
				$this->mObjects[$key]->set('url', "");
				$this->mObjects[$key]->set('bm_title', "*** This may be bookmarked by attacker ! ***");
			}
		}
		
		//if filtered by uid, the result bookmarks are for specific user's.
		$i = 0;
		while(@$criteria->criteriaElements[$i]){
			if($criteria->criteriaElements[$i]->getName() == 'uid'){
				$this->myCubookmarken = 'true';
			}
			$i++;
		}
		//TagCloud
		$where = "";
		if(xoops_getrequest('uid')){
			$where= 'uid='. intval(xoops_getrequest('uid'));
		}
		$this->tagCloud = getTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'));
		
		//Cubookmarkener List
		$userCriteria = new CriteriaCompo('1', '1');
		$userCriteria->setSort('uid');
		$userArr =& $handler->getObjects($userCriteria);
		//omit duplicated user
		if($userArr){
			$this->userArr[0] = $userArr[0]->getShow('uid');
			$i = 1;
			$user = $userArr[0]->getVar('uid');
			foreach(array_keys($userArr) as $keys){
				if($user == $userArr[$keys]->getShow('uid')){
				}
				else{
					$this->userArr[$i] = $userArr[$keys]->getShow('uid');
					$user = $userArr[$keys]->getShow('uid');
					$i++;
				}
			}
		}
		
		return CUBOOKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_list.html");
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('myCubookmarken', $this->myCubookmarken);
	
		$render->setAttribute('userArr', $this->userArr);
	
		$render->setAttribute('tagCloud', $this->tagCloud);
	
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
