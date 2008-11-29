<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractListAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/getTagCloud.php";

class Dbkmarken_TagListAction extends Dbkmarken_AbstractListAction
{

	var $myDbkmarken = null;
	var $tagCloud = null;
	var $requestTag = null;

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
		$bmHandler =& $this->mAsset->getObject('handler', "bm");
		foreach(array_keys($this->mObjects) as $key){
			$this->mObjects[$key]->loadBm($this->mAsset->mDirname);
			$this->mObjects[$key]->mBm->loadTag($this->mAsset->mDirname);
			//count users who bookmarks the same url
			$this->mObjects[$key]->mBm->bm_count = $bmHandler->getCount(new Criteria('url', $this->mObjects[$key]->mBm->get('url')));
			//check script insertion attack
			$myts = new MyTextSanitizer();
			if(! $myts->checkUrlString($this->mObjects[$key]->mBm->get('url'))){
				$this->mObjects[$key]->mBm->set('url', "");
				$this->mObjects[$key]->mBm->set('bm_title', "*** This may be bookmarked by attacker ! ***");
			}
		}

		//if filtered by uid, the result dbkmarkens are for specific user's.
		foreach(array_keys($criteria->criteriaElements) as $key2){
			if($criteria->criteriaElements[$key2]->getName() == 'uid'){
				$this->myDbkmarken = 'true';
			}
			if($criteria->criteriaElements[$key2]->getName() == 'tag_name'){
				$this->requestTag[$key2] = htmlspecialchars($this->mRoot->mContext->mRequest->getRequest('tag_name'), ENT_QUOTES);
			}
		}
		//TagCloud
		$where = "";
		if($this->mRoot->mContext->mRequest->getRequest('uid')){
			$where= 'uid='. intval($this->mRoot->mContext->mRequest->getRequest('uid'));
		}
		$this->tagCloud = Dbkmarken_GetTagCloud($where, $this->mModule->getModuleConfig('tagcloud_min'), $this->mModule->getModuleConfig('tagcloud_max'), $this->mAsset->mDirname);
	
		return DBKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function executeViewIndex(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_tag_list.html");
        $render->setAttribute('dirname', $this->mAsset->mDirname);
		$render->setAttribute('objects', $this->mObjects);
		$render->setAttribute('pageNavi', $this->mFilter->mNavi);
	
		$render->setAttribute('tagCloud', $this->tagCloud);
		$render->setAttribute('requestTag', $this->requestTag);
		$render->setAttribute('myDbkmarken', $this->myDbkmarken);
	
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', false);
		}
		else{
			$render->setAttribute('allow_useredit', true);
		}
	
		//set module header
		$render->setAttribute('xoops_pagetitle', _MD_DBKMARKEN_LANG_TAG .': '. implode(',', $this->requestTag));
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}
}

?>
