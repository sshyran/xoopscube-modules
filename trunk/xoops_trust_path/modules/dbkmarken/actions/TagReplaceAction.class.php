<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 * batch replace all of one tag_name added by one user 
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractEditAction.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/function.php";

class Dbkmarken_TagReplaceAction extends Dbkmarken_AbstractEditAction
{
	var $mOldTagName = "";
	
	/**
	 * @protected
	 */
	function &_getId()
	{
		return $this->mRoot->mContext->mRequest->getRequest('tag_id');
	}

	/**
	 * @protected
	 */
	function _getTagName()
	{
		return unescapeTag($this->mRoot->mContext->mRequest->getRequest('tag_name'));
	}

	/**
	 * @protected
	 */
	function _getOldTagName()
	{
		return $this->mRoot->mContext->mRequest->getRequest('old_tag_name');
	}

	/**
	 * @public
	 */
	function isMemberOnly()
	{
		return true;
	}

	function isAdminOnly()
	{
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			return true;
		}
	}

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
	function _setupActionForm()
	{
		$this->mActionForm =& $this->mAsset->getObject('form', "tag", false, "replace");
		$this->mActionForm->prepare();
	}

	/**
	 * @protected
	 */
	function _setupObject()
	{
		$this->mObjectHandler =& $this->_getHandler();
	
		if ($this->_isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	}

	function prepare()
	{
		parent::prepare();
		//tag_name is necessary in GET request
		if ($this->_getTagName()) {
			$this->mObject->set('tag_name', $this->_getTagName());
			$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			$this->mOldTagName = $this->_getOldTagName();
		}
		else{
			$this->mRoot->mController->executeRedirect("./index.php?action=TagList&tag_name=". $this->mObject->get('tag_name'), 1, _MD_DBKMARKEN_ERROR_NO_TAG_NAME);
		}
		//Replace function is always NOT NEW
		$this->mObject->unsetNew();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		//get Current Bookmark List of the tag for the user.
		$tagHandler = & $this->_getHandler();
		$tagCriteria = new CriteriaCompo();
		$tagCriteria->add(new Criteria('uid', $this->mRoot->mContext->mXoopsUser->get('uid')));
		$tagCriteria->add(new Criteria('tag_name', $this->_getTagName()));
		$tagArr = & $tagHandler->getObjects($tagCriteria);
		foreach(array_keys($tagArr) as $key){
			$tagArr[$key]->loadBm($this->mAsset->mDirname);
		}
	
		$render->setTemplateName($this->mAsset->mDirname . "_tag_replace.html");
        $render->setAttribute('dirname',$this->mAsset->mDirname);
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('tag', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('tags', $tagArr);
	}

	function _doExecute()
	{
		//batch replace tag_name
		global $xoopsDB;

		$sql = 'update '. $xoopsDB->prefix($this->mAsset->mDirname."_tag") .' set tag_name="'. $this->mObject->get('tag_name') .'" where uid='. $this->mObject->get('uid') .' and tag_name="'. $this->mOldTagName .'"';
		
		$result = $force ? $xoopsDB->queryF($sql) : $xoopsDB->query($sql);
	
		if (!$result){
			return DBKMARKEN_FRAME_VIEW_ERROR;
		}
	
		return DBKMARKEN_FRAME_VIEW_SUCCESS;
		
	}


	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=TagList&tag_name=". urlencode($this->mObject->get('tag_name')));
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=TagList&tan_name=". $this->mObject->get('tag_name'), 1, _MD_DBKMARKEN_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=TagList");
	}
}

?>
