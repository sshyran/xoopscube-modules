<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractViewAction.class.php";
require_once XOOPS_MODULE_PATH . "/xcat/class/Permission.class.php";
require_once XOOPS_MODULE_PATH . "/xcat/class/TreeObject.class.php";

class Xcat_CatViewAction extends Xcat_AbstractViewAction
{
	/**
	 * @public
	 */
	function _getId()
	{
		return xoops_getrequest('cat_id');
	}

	/**
	 * @public
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "cat");
		return $handler;
	}

	/**
	 * @public
	 */
	function prepare()
	{
		parent::prepare();
		
		//for Permissions
		if($this->mRoot->mContext->mXoopsUser){
			//$this->mObjectPermit->set('uid', $this->mRoot->mContext->mXoopsUser->get('uid'));
			$this->mObjectPermit->set('cat_id', $this->mObject->get('cat_id'));
		}
		$this->_setupActionForm();
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		//for Permission
		$this->mActionFormPermit =& $this->mAsset->create('form', "edit_permit");
		$this->mActionFormPermit->prepare();
	}

	function _setupObject()
	{
		parent::_setupObject();

		//for Permission
		$this->mObjectHandlerPermit =& $this->mAsset->load('handler', "permit");
		$this->mObjectPermit =& $this->mObjectHandlerPermit->create();
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mObject->loadGr();
		$this->mObject->loadPcat();
	
		//TreeObject
		$catTree = new Xcat_TreeObject($this->mObject->get('gr_id'));
		$catTree->loadTree();
	
		//format Permissions for html form
		$permissions = new Xcat_Permission($this->mObject);
		$gPermit = ($this->mObject->getThisPermit()) ? $this->mObject->getThisPermit() : array();
		$uPermit = ($this->mObject->getThisUserPermit()) ? $this->mObject->getThisUserPermit(): array();
		$permissions->setPermissions(array_merge($gPermit, $uPermit));
	
	
		//set renders
		$render->setTemplateName("xcat_cat_view.html");
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('childrenTree', $catTree->mTree);
		$render->setAttribute('permitObj', $permissions);
		//modules confinement
		$render->setAttribute('modulesArr', $this->mObject->getModulesArr());
	
		//for permit addition
		$this->mActionFormPermit->load($this->mObjectPermit);
		$render->setAttribute('actionFormPermit', $this->mActionFormPermit);
	
		//set CSS and Javascript
		$js = "";
		foreach($permissions->mActionArr['key'] as $actionKey){
			$js .= '<td><input type=\'checkbox\' value=\'1\' name=\'user_permit_options["+usersCounter+"]['. $actionKey .']\'></td>';
		}
	
		$render->setAttribute('xoops_module_header','<link rel="stylesheet" type="text/css" media="screen" href="xcat.css" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("language", "1"); 
google.load("jquery", "1");
google.setOnLoadCallback(function() {
usersCounter='. count($permissions->mPermit["key"]["user"]) .';
});
function addUserField() {
$("#usersPermit").append("<tr><th><input type=\'text\' id=\'user_names["+usersCounter+"]\' value=\'\' name=\'user_names["+usersCounter+"]\'></th>' . $js .'<tr>");
usersCounter++;
}
</script>');
	}

	
	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=CatList", 1, _MD_XCAT_ERROR_CONTENT_IS_NOT_FOUND);
	}

}

?>
