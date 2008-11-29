<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/actions/BmEditAction.class.php";

class Dbkmarken_BmRaterAction extends Dbkmarken_BmEditAction
{
	/**
	 * @protected
	 */
	function _getRatingTag()
	{
		return $this->mRoot->mContext->mRequest->getRequest('rating');
	}

	/**
	 * @protected
	 */
	function _setupObject()
	{
		$id = $this->_getId();
		$this->url = $this->_getUrl();
		$this->ret = $this->mRoot->mContext->mRequest->getRequest('ret');
	
		$this->mObjectHandler =& $this->_getHandler();
	
		//if dbkmarken url is already registered on bm table by the same user, 
		//get the bm_id and set it in $id.
		if($id == 0 and $this->_getUrl())
		{
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('url', $this->_getUrl()));
			$criteria->add(new Criteria('uid', $this->mRoot->mContext->mXoopsUser->get('uid')));
			$object =& $this->mObjectHandler->getObjects($criteria);
			if(isset($object[0]))
			{
				$id = $object[0]->get('bm_id');
			}
		}
	
		$this->mObject =& $this->mObjectHandler->get($id);
	
		if ($this->mObject == null && $this->_isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	
		//get the tag list of this bookmark
		$this->mObjectHandler2 =& $this->mAsset->getObject('handler', "tag");
		$criteria2 = new CriteriaCompo('1', '1');
		$criteria2->add(new Criteria('bm_id', $id));
	
		$object2 =& $this->mObjectHandler2->getObjects($criteria2);
		$tag_name2 = "";
		if($object2){
			$this->mObject2 =& $object2[0];
		}
		if ($this->mObject2 == null && $this->_isEnableCreate()) {
			$this->mObject2 =& $this->mObjectHandler2->create();
		}
	
	}

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		if ($this->mObject->isNew()) {
			$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			$this->mObject2->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
		}
		//set tag(rating)
		$this->mObject2->set('tag_name', $this->_getRatingTag());
	
		//use dbkmarkenlet
		if($this->_getUrl())
		{
			$this->mObject->set('url', $this->_getUrl());
			$this->mObject->set('bm_title', $this->_getTitle());
		}
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		echo $this->mObject2->getShow('tag_name');
	}

	function execute()
	{
		$oldTagArr = null;
		$newTagArr = null;
	
		if ($this->mObject == null) {
			return DBKMARKEN_FRAME_VIEW_ERROR;
		}
	
		if ($this->mRoot->mContext->mRequest->getRequest('_form_control_cancel') != null) {
		return DBKMARKEN_FRAME_VIEW_CANCEL;
		}
	
		//set bookmark
		$this->mActionForm->load($this->mObject);
		$this->mActionForm->fetch();
		$this->mActionForm->validate();
	
		//set tag
		$this->mActionForm2->load($this->mObject2);
		$this->mActionForm2->fetch();
		$this->mActionForm2->validate();
	
		if ($this->mActionForm->hasError() or $this->mActionForm2->hasError()) {
			return DBKMARKEN_FRAME_VIEW_INPUT;
		}
	
		$this->mActionForm->update($this->mObject);
	
		//kilica	transaction start
		$res1 = $this->mObjectHandler->db->queryF("begin");
		$result = $this->_doExecute($this->mObject);
	
		//kilica	for Tag table
		if($this->mActionForm->getVar('bm_id') > 0){
			$this->mActionForm2->set('bm_id', $this->mActionForm->getVar('bm_id'));
		}else{
			if($this->mObject->get('bm_id') > 0){
				$this->mActionForm2->set('bm_id', $this->mObject->get('bm_id'));
			}else{
				$res3 = $this->mObjectHandler->db->queryF("rollback");
				return DBKMARKEN_FRAME_VIEW_ERROR;
			}
		}
	
		$this->mActionForm2->update($this->mObject2);
		if ($this->mObjectHandler2->insert($this->mObject2)) {
			$i++;
		}else{
			$res3 = $this->mObjectHandler->db->queryF("rollback");
			return DBKMARKEN_FRAME_VIEW_ERROR;
		}
	
		$res2 = $this->mObjectHandler->db->queryF("commit");
	
		echo $this->mObject2->getShow('tag_name');
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
		$this->mRoot->mController->executeRedirect("./index.php?action=BmList", 1, _MD_DBKMARKEN_ERROR_DBUPDATE_FAILED);
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
