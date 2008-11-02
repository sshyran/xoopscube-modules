<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractEditAction.class.php";

class Cubookmarken_BmEditAction extends Cubookmarken_AbstractEditAction
{
	var $myTagArr = null;
	var $popTagArr = null;
	var $url = null;
	var $ret = null;
	var $mAllowUseredit = "1";
	var $mObject2 = null;

	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('bm_id');
	}

	/**
	 * @protected
	 */
	function _getUrl()
	{
		return xoops_getrequest('url');
	}

	/**
	 * @public
	 */
	function isMemberOnly()
	{
		return true;
	}

	/**
	 * @public
	 */
	function isAdminOnly()
	{
		if($this->mModule->getModuleConfig('allow_useredit') == '0'){
			$this->mAllowUseredit = "0";
			return true;
		}
		else{
			$this->mAllowUseredit = "1";
		}
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
	function _setupObject()
	{
		$id = $this->_getId();
		$this->url = $this->_getUrl();
		$this->ret = xoops_getrequest('ret');
	
		$this->mObjectHandler =& $this->_getHandler();
	
		//if cubookmarken url is already registered on bm table by the same user, 
		//get the bm_id and set it in $id.
		if($id == 0 and $this->url)
		{
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('url', $this->url));
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
		$this->mObjectHandler2 =& $this->mAsset->load('handler', "tag");
		$criteria2 = new CriteriaCompo('1', '1');
		$criteria2->add(new Criteria('bm_id', $id));
	
		$object2 =& $this->mObjectHandler2->getObjects($criteria2);
		$tag_name2 = "";
		if($object2){
			foreach(array_keys($object2) as $keys){
				$tag_name2 = $tag_name2 .'['. $object2[$keys]->get('tag_name') .']';
			}
			$object2[0]->set('tag_name', $tag_name2);
			$this->mObject2 =& $object2[0];
		}
		if ($this->mObject2 == null && $this->_isEnableCreate()) {
			$this->mObject2 =& $this->mObjectHandler2->create();
		}
	
		//get user's tag list
		$object3 = null;
		$criteria3 = new CriteriaCompo('1', '1');
		$criteria3->add(new Criteria('uid', $this->mRoot->mContext->mXoopsUser->get('uid')));
		$criteria3->setSort('tag_name');
		$object3 =& $this->mObjectHandler2->getObjects($criteria3);
	
		if($object3 != null){
			$i = 0;
			foreach(array_keys($object3) as $key3){
				$myTagArr[$i] = $object3[$key3]->getShow('tag_name');
				$i++;
			}
			$this->myTagArr = array_unique($myTagArr);
		}
	
		//get all tag list
		$object4 = null;
		$criteria4 = new CriteriaCompo('1', '1');
		$object4 =& $this->mObjectHandler->getObjects($criteria4);
	
		//omit duplicated tags
		if($object4 != null){
			$j = 0;
			foreach(array_keys($object4) as $key4a){
				$object4[$key4a]->loadTag();
				foreach(array_keys($object4[$key4a]->mTag) as $key4b){
					$popTag[$j] = $object4[$key4a]->mTag[$key4b]->getVar('tag_name');
					$j++;
				}
			}
			sort($popTag);
			$this->popTagArr = array_unique($popTag);
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
	
		//use cubookmarkenlet
		if(xoops_getrequest('url'))
		{
			//$this->mObject->set('url', $_REQUEST['url']);
			//$this->mObject->set('bm_title', $_REQUEST['bm_title']);
			$this->mObject->set('url', xoops_getrequest('url'));
			$this->mObject->set('bm_title', xoops_getrequest('bm_title'));
		}
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		// $this->mActionForm =& new Cubookmarken_BmEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_bm");
		$this->mActionForm->prepare();
	
		$this->mActionForm2 =& $this->mAsset->create('form', "edit_tag");
		$this->mActionForm2->prepare();
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		if ($this->mObject == null or $this->mObject2 == null) {
			return CUBOOKMARKEN_FRAME_VIEW_ERROR;
		}
	
		$this->mActionForm->load($this->mObject);
		$this->mActionForm2->load($this->mObject2);
	
		return CUBOOKMARKEN_FRAME_VIEW_INPUT;
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("cubookmarken_bm_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('actionForm2', $this->mActionForm2);
		#cubson::lazy_load('bm', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('object2', $this->mObject2);
	
		//tag list
		$render->setAttribute('myTagArr', $this->myTagArr);
		$render->setAttribute('popTagArr', $this->popTagArr);
		$render->setAttribute('ret', $this->ret);
		$render->setAttribute('allowUseredit', $this->mAllowUseredit);
	
		//set module header
		if($this->mRoot->mContext->mModule->getModuleConfig('css_file')){
			$render->setAttribute('xoops_module_header',
			'<script type="text/javascript" src="tag.js" charset="utf-8"></script>
			<link rel="stylesheet" type="text/css" media="screen" href="'. XOOPS_URL . $this->mRoot->mContext->mModule->getModuleConfig('css_file') .'" />'
			);
		}
		else{
			$render->setAttribute('xoops_module_header','<script type="text/javascript" src="tag.js" charset="utf-8"></script>');
		}
	}

	function execute()
	{
		$oldTagArr = null;
		$newTagArr = null;
	
		if ($this->mObject == null) {
			return CUBOOKMARKEN_FRAME_VIEW_ERROR;
		}
	
		if (xoops_getrequest('_form_control_cancel') != null) {
		return CUBOOKMARKEN_FRAME_VIEW_CANCEL;
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
			return CUBOOKMARKEN_FRAME_VIEW_INPUT;
		}
	
		$this->mActionForm->update($this->mObject);
	
		//kilica	tags diff with New and Old ... when update data
		if($this->mObject->get('bm_id') > 0){
			//kilica	get old tags and sort them
			$handler = & $this->mAsset->load('handler', "tag");
			$criteria = new CriteriaCompo('1', '1');
			$criteria->add(new Criteria('bm_id', $this->mObject->get('bm_id')));
			$criteria->setSort('tag_name');
			$oldTagArr =& $handler->getObjects($criteria);
		}
	
		//kilica	get new tags and sort them
		//[tag] -> tag
		if($this->mModule->getModuleConfig('mb_tag') == true){
			preg_match_all("/\[(.+)\]/U", mb_convert_kana($this->mActionForm2->get('tag_name'), asKV), $tags);
		}
		else{
			preg_match_all("/\[(.+)\]/U", $this->mActionForm2->get('tag_name'), $tags);
		}
		$newTagArr = array_unique($tags[1]);
	
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
				return CUBOOKMARKEN_FRAME_VIEW_ERROR;
			}
		}
	
		$this->mActionForm2->update($this->mObject2);
		//matching Old and New tags
		$i = 0;
		$j = 0;
	
		while ($newTagArr[$i] != null and $oldTagArr[$j] != null){
			if($newTagArr[$i] == $oldTagArr[$j]->getVar('tag_name')){
				$j++;
				$i++;
			}elseif($newTagArr[$i] > $oldTagArr[$j]->getVar('tag_name')){
				//delete tag record
				$this->mObject2->set('tag_id', $oldTagArr[$j]->getVar('tag_id'));
				if ($this->mObjectHandler2->delete($this->mObject2)) {
					$j++;
				}else{
					$res3 = $this->mObjectHandler->db->queryF("rollback");
					return CUBOOKMARKEN_FRAME_VIEW_ERROR;
				}
			}elseif($newTagArr[$i] < $oldTagArr[$j]->getVar('tag_name')){
				//add new tag record
				//reset tag_id and new flag
				$this->mObject2->set('tag_id', 0);
				$this->mObject2->setNew();
				$this->mObject2->set('tag_name', $newTagArr[$i]);
				if ($this->mObjectHandler2->insert($this->mObject2)) {
					$i++;
				}else{
					$res3 = $this->mObjectHandler->db->queryF("rollback");
					return CUBOOKMARKEN_FRAME_VIEW_ERROR;
				}
			}
		}
		//add new tag record
		while($newTagArr[$i]){
			// reset new tag_id
			$this->mObject2->set('tag_id', 0);
			$this->mObject2->setNew();
			$this->mObject2->set('tag_name', $newTagArr[$i]);
			$this->mObject2->set('uid', $this->mObject->get('uid'));
			$this->mObject2->set('bm_id', $this->mActionForm2->get('bm_id'));
			if ($this->mObjectHandler2->insert($this->mObject2)) {
				$i++;
			}else{
				$res3 = $this->mObjectHandler->db->queryF("rollback");
				return CUBOOKMARKEN_FRAME_VIEW_ERROR;
			}
		}
		//delete tag record
		while($oldTagArr[$j]){
			$this->mObject2->set('tag_id', $oldTagArr[$j]->getVar('tag_id'));
			if ($this->mObjectHandler2->delete($this->mObject2)) {
				$j++;
			}else{
				$res3 = $this->mObjectHandler->db->queryF("rollback");
				return CUBOOKMARKEN_FRAME_VIEW_ERROR;
			}
		}
	
		$res2 = $this->mObjectHandler->db->queryF("commit");
	
		//return to referred page if came through cubookmarkenlet
		if($this->ret == 1){
			$this->mRoot->mController->executeForward($this->url);
		}else{
			$this->mRoot->mController->executeForward("./index.php?action=BmList");
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
