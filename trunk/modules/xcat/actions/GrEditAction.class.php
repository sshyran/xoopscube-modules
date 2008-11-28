<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractEditAction.class.php";

class Xcat_GrEditAction extends Xcat_AbstractEditAction
{
	var $mActions = null;	//list of action auth

	/**
	 * @protected
	 */
	function _getId()
	{
		return xoops_getrequest('gr_id');
	}

	/**
	 * @protected
	 */
	function &_getHandler()
	{
		$handler =& $this->mAsset->load('handler', "gr");
		return $handler;
	}

	/**
	 * @public
	 */
	function isAdminOnly()
	{
		return true;
	}

	function prepare()
	{
		parent::prepare();
	
		if ($this->mObject->isNew()) {
			$actionArr[0]['key'] = "viewer";
			$actionArr[0]['title'] = _MD_XCAT_LANG_VIEWER;
			$actionArr[0]['default'] = 1;
			$actionArr[1]['key'] = "poster";
			$actionArr[1]['title'] = _MD_XCAT_LANG_POSTER;
			$actionArr[1]['default'] = "";
		}
		else{
			$actions = unserialize($this->mObject->get('actions'));
			$i = 0;
			foreach(array_keys($actions['title']) as $key){
				$actionArr[$i]['key'] = $key;
				$actionArr[$i]['title'] = $actions['title'][$key];
				$actionArr[$i]['default'] = $actions['default'][$key];
				$i++;
			}
		}
	
		$this->mActions = $actionArr;
	}

	/**
	 * @protected
	 */
	function _setupActionForm()
	{
		// $this->mActionForm =& new Xcat_GrEditForm();
		$this->mActionForm =& $this->mAsset->create('form', "edit_gr");
		$this->mActionForm->prepare();
	}

	/**
	 * @public
	 */
	function executeViewInput(&$render)
	{
		$render->setTemplateName("xcat_gr_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		#cubson::lazy_load('gr', $this->mObject);
		$render->setAttribute('object', $this->mObject);
		$render->setAttribute('actions', $this->mActions);
		$render->setAttribute('xoops_module_header',
'<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("language", "1"); 
google.load("jquery", "1");
google.setOnLoadCallback(function() {
actionsCounter='. count($this->mActions) .';
});
function addActionKeyForm() {
$("#permitOptions").append("<tr><td><input type=\'text\' id=\'legacy_xoopsform_actions_key["+actionsCounter+"]\' value=\'\' name=\'actions_key["+actionsCounter+"]\'></td><td><input type=\'text\' id=\'legacy_xoopsform_actions_title["+actionsCounter+"]\' value=\'\' name=\'actions_title["+actionsCounter+"]\'></td><td><input type=\'checkbox\' id=\'legacy_xoopsform_actions_default["+actionsCounter+"]\' value=\'1\' name=\'actions_default["+actionsCounter+"]\'></td></tr>");
actionsCounter++;
}
</script>');
	}

	/**
	 * @public
	 */
	function executeViewSuccess(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=GrList");
	}

	/**
	 * @public
	 */
	function executeViewError(&$render)
	{
		$this->mRoot->mController->executeRedirect("./index.php?action=GrList", 1, _MD_XCAT_ERROR_DBUPDATE_FAILED);
	}

	/**
	 * @public
	 */
	function executeViewCancel(&$render)
	{
		$this->mRoot->mController->executeForward("./index.php?action=GrList");
	}
}

?>
