<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractEditAction.class.php";

class Cubookmarken_BmImplementAction extends Cubookmarken_AbstractEditAction
{
	/**
	 * @protected
	 */
	function &_getId()
	{
		return xoops_getrequest('bm_id');
	}

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
	function &_setupActionForm()
	{
		//$this->mActionForm =& new Cubookmarken_BmEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_bm");
		$this->mActionForm->prepare();
	}

	//½é´ï¿Í£ö¡»¥Ã¥È
	function prepare()
	{
		parent::prepare();
		if ($this->mObject->isNew()) {
			$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			$this->mObject->set('bm_title', $_REQUEST['bm_title']);
		}
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_implement.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('bm', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$tpl = new XoopsTpl();
		if (!$tpl->is_cached("db:cubookmarken_bm_implement.html")) {
			$tpl->assign('actionForm', $this->mActionForm);
			$tpl->assign('object', $this->mObject);
			$tpl->display("db:cubookmarken_bm_implement.html");
		}
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=BmList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_CUBOOKMARKEN_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=BmList");
	}
}

?>
