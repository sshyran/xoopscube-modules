<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractDeleteAction.class.php";

class Xcat_PermitDeleteAction extends Xcat_AbstractDeleteAction
{
	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('cat_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "permit");
		return $handler;
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		// $this->mActionForm =& new Xcat_PermitDeleteForm();
		$this->mActionForm =& $this->mAsset->create('form', "delete_permit");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		return is_object($this->mObject[0]);
	}

	/**
	 * @protected
	 */
	function _setupObject()
	{
		$id = xoops_getrequest('cat_id');
	
		$this->mObjectHandler =& $this->_getHandler();
	
		$this->mObject =& $this->mObjectHandler->getObjects(new Criteria('cat_id', $id));
	
		if ($this->mObject == null && $this->_isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("xcat_permit_delete.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('permit', $this->mObject);
		$render->setAttribute('cat_id', $this->_getid());
		//$render->setAttribute('object', $this->mObject);
	}

	/**
	 * @public
	 */
	function execute()
	{
		if ($this->mObject == null) {
			return XCAT_FRAME_VIEW_ERROR;
		}
	
		if (xoops_getrequest('_form_control_cancel') != null) {
		return XCAT_FRAME_VIEW_CANCEL;
		}
	
		//$this->mActionForm->load($this->mObject);
	
		//$this->mActionForm->fetch();
		$this->mActionForm->validate();
	
		if ($this->mActionForm->hasError()) {
			return XCAT_FRAME_VIEW_INPUT;
		}
	
		//$this->mActionForm->update($this->mObject);
	
		return $this->_doExecute($this->mObject);
	}

	/**
	 * @protected
	 */
	function _doExecute()
	{
		foreach(array_keys($this->mObject) as $key){
			if (! $this->mObjectHandler->delete($this->mObject[$key])) {
				return XCAT_FRAME_VIEW_ERROR;
			}
		}
	
		return XCAT_FRAME_VIEW_SUCCESS;
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatView&cat_id=". $this->mObject[0]->getShow('cat_id'));
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=PermitList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=PermitList");
	}
}

?>
