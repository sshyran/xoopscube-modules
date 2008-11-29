<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractViewAction.class.php";

class Dbkmarken_BmViewAction extends Dbkmarken_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return $this->mRoot->mContext->mRequest->getRequest('bm_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->getObject('handler', "bm");
		return $handler;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$render->setTemplateName($this->mAsset->mDirname . "_bm_view.html");
        $render->setAttribute('dirname', $this->mAsset->mDirname);
		$this->mObject->loadTag($this->mAsset->mDirname);
		//check script insertion attack
		$myts = new MyTextSanitizer();
		if(! $myts->checkUrlString($this->mObject->get('url'))){
			$this->mObject->set('url', "");
			$this->mObject->set('bm_title', "*** This may be bookmarked by attacker ! ***");
		}
		$render->setAttribute('object', $this->mObject);
	
		//other bookmarks on this url
		$handler = $this->_getHandler();
		$bmCriteria = new CriteriaCompo('1', '1');
		$bmCriteria->add(new Criteria('url', $this->mObject->get('url')));
		$bmCriteria->add(new Criteria('uid', $this->mObject->get('uid'), '!='));		$bookmarkers = $handler->getObjects($bmCriteria);
		foreach(array_keys($bookmarkers) as $key){
			$bookmarkers[$key]->loadTag($this->mAsset->mDirname);
		}
		$render->setAttribute('bookmarkers', $bookmarkers);
	
		//admin only mode ?
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', "false");
		}else{
			$render->setAttribute('allow_useredit', "true");
		}
	
		//set module header
		$render->setAttribute('xoops_pagetitle', $this->mObject->getShow('bm_title'));
		//css
		$css = XOOPS_URL . $this->mModule->getModuleConfig('css_file');
		$moduleHeader = $render->getAttribute('xoops_module_header');
		$moduleHeader .= '<link rel="stylesheet" type="text/css" media="screen" href="'. $css .'" />';
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_DBKMARKEN_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
