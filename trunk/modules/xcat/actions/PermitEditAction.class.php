<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractEditAction.class.php";

class Xcat_PermitEditAction extends Xcat_AbstractEditAction
{

	var $mGrAction = null;	//ex. read, write or delete, etc.
	var $mPermitOptions = array();
	var $mPermitId = array();

	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('permit_id');
	}

	/**
	 * @public
	 */
	function isAdminOnly()
	{
		return true;
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
		// $this->mActionForm =& new Xcat_PermitEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_permit");
		$this->mActionForm->prepare();
	}

	function prepare()
	{
		parent::prepare();
		//if no cat_id and no permit_id is requested, it is invalid request.
		if(! xoops_getrequest('cat_id') && ! $this->_getId()){
			$this->mRoot->mController->executeRedirect("./index.php?action=CatList", 1, _MD_XCAT_ERROR_NO_CATEGORY_REQUESTED);
		}
	
		//add new record
		if ($this->mObject->isNew()) {
			//set parent category if requested
			$this->mObject->set('cat_id', xoops_getrequest('cat_id'));
		}
	
		$this->mObject->loadCat();
		$this->mObject->mCat->loadGr();

		$this->mPermitOptions = xoops_getrequest('permit_options');
		$this->mUserPermitOptions = xoops_getrequest('user_permit_options');
		$this->mUserNames = xoops_getrequest('user_names');
		$this->mPermitIds = xoops_getrequest('permit_ids');
		$this->mUserPermitIds = xoops_getrequest('user_permit_ids');
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		//Actions of this Group. ex. read, write, delete
		$grActionArr = unserialize($this->mObject->mCat->mGr->get('actions'));
		foreach(array_keys($this->mObject) as $key1){
			$permitArr = array();
			$permitArr = unserialize($this->mObject->get('permissions'));
			foreach(array_keys($grActionArr) as $key2){
				$grActionArr[$key2][$key1] = $permitArr[$grAction[$key2]];
			}
		}
		$this->mGrAction = $grActionArr;
		
		$render->setTemplateName("xcat_permit_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('permit', $this->mObject);
		$render->setAttribute('object', $this->mObject);

		//load User Groups for permissions
		$ugroupHandler =& xoops_gethandler('member');
		$ugroupArr =& $ugroupHandler->getGroups();
		$render->setAttribute('ugroupArr', $ugroupArr);
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
	
		$this->mActionForm->load($this->mObject);
	
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
	
		if ($this->mActionForm->hasError()) {
			return XCAT_FRAME_VIEW_INPUT;
		}
	
		$this->mActionForm->update($this->mObject);
	
		//get the list of user groups
		$groupHandler =& xoops_gethandler('member');
		$groups =& $groupHandler->getGroups();
	
		//set group permissions
		foreach(array_keys($groups) as $key1){	//$key1:groupid
			$permitArr = array();
			$groupId = $groups[$key1]->get('groupid');
			$this->mObject->set('groupid', $groupId);
		
			foreach(array_keys($this->mPermitOptions[$groupId]) as $key2){	//$key2:action
				$permitArr[$key2] = $this->mPermitOptions[$groupId][$key2];
			}
			if($this->mPermitIds[$groupId]){
				$this->mObject->set('permit_id', intval($this->mPermitIds[$groupId]));
				$this->mObject->unsetNew();
			}
			else{
				$this->mObject->set('permit_id', 0);
				$this->mObject->setNew();
			}
			$this->mObject->set('permissions', serialize($permitArr));
		
			if (! $this->mObjectHandler->insert($this->mObject)) {
				return XCAT_FRAME_VIEW_ERROR;
			}
		}

		//set user permissions
		$this->mObject->set('groupid', 0);
		$userHandler = xoops_gethandler('member');
		foreach(array_keys($this->mUserNames) as $key3){	//$key3:
			$permitArr = array();
			$userArr = $userHandler->getUsers(new Criteria('uname', $this->mUserNames[$key3]));
			if($userArr){
				$this->mObject->set('uid', $userArr[0]->get('uid'));
			
				foreach(array_keys($this->mUserPermitOptions[$key3]) as $key4){	//$key4:action
					$permitArr[$key4] = $this->mUserPermitOptions[$key3][$key4];
				}
				//var_dump($this->mUserPermitIds);die();
				if($this->mUserPermitIds[$key3]){
					$this->mObject->set('permit_id', intval($this->mUserPermitIds[$key3]));
					$this->mObject->unsetNew();
				}
				else{
					$this->mObject->set('permit_id', 0);
					$this->mObject->setNew();
				}
				$this->mObject->set('permissions', serialize($permitArr));
			
				if (! $this->mObjectHandler->insert($this->mObject)) {
					return XCAT_FRAME_VIEW_ERROR;
				}
			}
		}
	
		return XCAT_FRAME_VIEW_SUCCESS;
	
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatView&cat_id=". $this->mObject->get('cat_id'));
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
	 /*
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=PermitList");
	}
	*/
}

?>
