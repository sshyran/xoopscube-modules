<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/getTagCloud.php";

class Dbkmarken_BmListAction extends Dbkmarken_AbstractListAction
{

	var $myDbkmarken = null;
	var $tagCloud = null;
	var $userArr = null;

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
		$this->mObjects =& $handler->getObjects($criteria);
		foreach(array_keys($this->mObjects) as $key)
		{
			$this->mObjects[$key]->loadTag($this->mAsset->mDirname);
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
				$this->myDbkmarken = 'true';
			}
			$i++;
		}
		//TagCloud
		$where = "";
		if($this->mRoot->mContext->mRequest->getRequest('uid')){
			$where= 'uid='. intval($this->mRoot->mContext->mRequest->getRequest('uid'));
		}
		$this->tagCloud = Dbkmarken_GetTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'), $this->mAsset->mDirname);
		
		//Dbkmarkener List
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
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_bm_list.html");
        $render->setAttribute('dirname',$this->mAsset->mDirname);
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
		$render->setAttribute('myDbkmarken', $this->myDbkmarken);
	
		$render->setAttribute('userArr', $this->userArr);
	
		$render->setAttribute('tagCloud', $this->tagCloud);
	
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', false);
		}
		else{
			$render->setAttribute('allow_useredit', true);
		}
	
		//set module header
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}
}

?>
