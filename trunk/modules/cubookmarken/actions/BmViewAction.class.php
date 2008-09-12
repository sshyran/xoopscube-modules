<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractViewAction.class.php";

class Cubookmarken_BmViewAction extends Cubookmarken_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return xoops_getrequest('bm_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "bm");
		return $handler;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_view.html");
		$this->mObject->loadTag();
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
			$bookmarkers[$key]->loadTag();
		}
		$render->setAttribute('bookmarkers', $bookmarkers);
	
		//admin only mode ?
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$render->setAttribute('allow_useredit', "false");
		}else{
			$render->setAttribute('allow_useredit', "true");
		}
	
		//set module header
		if($this->mRoot->mContext->mModule->getModuleConfig('css_file')){
			$render->setAttribute('xoops_module_header','<link rel="stylesheet" type="text/css" media="screen" href="'. XOOPS_URL . $this->mRoot->mContext->mModule->getModuleConfig('css_file') .'" />');
		}
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_CUBOOKMARKEN_ERROR_CONTENT_IS_NOT_FOUND);
	}
}

?>
