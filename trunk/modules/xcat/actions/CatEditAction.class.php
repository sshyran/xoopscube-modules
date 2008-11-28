<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractEditAction.class.php";

class Xcat_CatEditAction extends Xcat_AbstractEditAction
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
		$handler =& $this->mAsset->load('handler', "cat");
		return $handler;
	}

	function _checkManager()
	{
		if(! $this->mRoot->mContext->mXoopsUser){
			return false;
		}
	
		if(! $this->mObject->checkPermitByUid('manager', $this->mRoot->mContext->mXoopsUser->get('uid')) && ! $this->mRoot->mContext->mUser->isInRole('Module.xcat.Admin')){
			return false;
		}
		return true;
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		// $this->mActionForm =& new Xcat_CatEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_cat");
		$this->mActionForm->prepare();
	}

	function prepare()
	{
		parent::prepare();
	
		//if no cat_id and no p_id and gr_id is requested, it is invalid request.
		if(! xoops_getrequest('gr_id') && ! xoops_getrequest('p_id') && ! $this->_getId()){
			$this->mRoot->mController->executeRedirect("./index.php?action=GrEdit", 1, _MD_XCAT_ERROR_NO_GROUP_REQUESTED);
		}

		//add new record
		if ($this->mObject->isNew()) {
			if($this->mRoot->mContext->mXoopsUser){
				$this->mObject->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			}
			//set parent category if requested
			if(xoops_getrequest('p_id')){
				$this->mObject->set('p_id', xoops_getrequest('p_id'));
				$this->mObject->loadPcat();
				$this->mObject->set('gr_id', $this->mObject->mPcat->get('gr_id'));
			}
			//set category group if requested
			elseif(xoops_getrequest('gr_id')){
				$this->mObject->set('gr_id', xoops_getrequest('gr_id'));
			}
		
			//set default values
			$this->mObject->set('count1', 0);
			$this->mObject->set('count2', 0);
		}
		else{		//load permission data if not new category
			$this->mObject->loadPermit();
		}
	
		//check Permission of editing this category
		if(! $this->_checkManager()){
			$this->mRoot->mContext->mModule->doPermissionError();
			die();
		}
	
		$this->mObject->loadPcat();
		$this->mObject->loadGr();
	
		//check specified modules name in the current and parent cats.
		$reqModulesArr = explode(',', xoops_getrequest('modules'));
		if($reqModulesArr){
			$modulesArr = array();
			$resultArr = array();
			//check limitation in parent categories
			$this->mObject->loadCatPath();
			foreach(array_keys($this->mObject->mCatPath['modules']) as $keyP){
				if($this->mObject->mCatPath['modules'][$keyP]){
					$modulesArr = explode(',', $this->mObject->mCatPath['modules'][$keyP]);
					break 1;
				}
			}
			//search parent categories' modules limitation
			foreach(array_keys($reqModulesArr) as $key){
				if(in_array($reqModulesArr[$key], $modulesArr)){
					$resultArr[] = $reqModulesArr[$key];
				}
			}
			if($resultArr){
				$_POST['modules'] = implode(',', $resultArr);
			}
		}
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		//load Category for Parent Selection
		$catCriteria=new CriteriaCompo('1', '1');
		$catCriteria->add(new Criteria('gr_id', $this->mObject->get('gr_id')));
		if($this->mObject->get('cat_id')){
			$catCriteria->add(new Criteria('cat_id', $this->mObject->get('cat_id'), '!='));
		}
		$catHandler =& xoops_getmodulehandler('cat');
		$catArr =& $catHandler->getObjects($catCriteria);
	
		//remove descendant categories
		$deepest = 0;	//the deepest category level in given category's descendant
		foreach(array_keys($catArr) as $keyD){
			$catArr[$keyD]->loadCatPath();
			//var_dump($catArr[$keyD]->mCatPath);
			if(is_array($catArr[$keyD]->mCatPath['cat_id']) && in_array($this->mObject->get('cat_id'), $catArr[$keyD]->mCatPath['cat_id'])){
				if($deepest<$catArr[$keyD]->getDepth()){
					$deepest = $catArr[$keyD]->getDepth();
				}
				unset($catArr[$keyD]);
			}
		}
		//remove depth limit overed categories
		$limit = $this->mObject->mGr->get('level');
		if($limit!=0){	//limit==0 means unlimited depth
			foreach(array_keys($catArr) as $keyL){
				if($limit<$catArr[$keyL]->getDepth()+$deepest-$this->mObject->getDepth()+1||$limit<$catArr[$keyL]->getDepth()+1){
					unset($catArr[$keyL]);
				}
			}
		}
	
		//set renders
		$render->setTemplateName("xcat_cat_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('catArr', $catArr);
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=CatList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=CatList");
	}
}

?>
