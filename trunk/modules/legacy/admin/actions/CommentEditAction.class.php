<?php
/**
 *
 * @package Legacy
 * @version $Id: CommentEditAction.class.php,v 1.4 2007/09/09 10:29:02 minahito Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/admin/forms/CommentAdminEditForm.class.php";
require_once XOOPS_ROOT_PATH . '/include/comment_constants.php';

class Legacy_CommentEditAction extends Legacy_AbstractEditAction
{
	/**
	 * Override. At first, call _setupObject().
	 */
	function prepare(&$controller, &$xoopsUser)
	{
		$this->_setupObject();
		$this->_setupActionForm();
	}
	
	function _getId()
	{
		return isset($_REQUEST['com_id']) ? intval(xoops_getrequest('com_id')) : 0;
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('comment');
		return $handler;
	}
	
	function isEnableCreate()
	{
		return false;
	}

	/**
	 * Choose appropriate ActionForm by the value of com_status.
	 */
	function _setupActionForm()
	{
		if ($this->mObject->get('com_status') == 1) {
			$this->mActionForm =& new Legacy_PendingCommentAdminEditForm();
			$this->mObjectHandler->mUpdateSuccess->add(array(&$this, "doApprove"));
		}
		else {
			$this->mActionForm =& new Legacy_ApprovalCommentAdminEditForm();
			$this->mObjectHandler->mUpdateSuccess->add(array(&$this, "doUpdate"));
		}
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$this->mObject->loadUser();
		$this->mObject->loadModule();
		$this->mObject->loadStatus();
		
		$render->setTemplateName("comment_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
		
		$subjectHandler =& xoops_gethandler('subjecticon');
		$subjectIconArr =& $subjectHandler->getObjects();
		
		$render->setAttribute('subjectIconArr', $subjectIconArr);

		$statusHandler =& xoops_getmodulehandler('commentstatus');
		if ($this->mObject->get('com_status') == XOOPS_COMMENT_PENDING) {
			$statusArr =& $statusHandler->getObjects();
		}
		else {
			$statusArr = array();
			$statusArr[0] =& $statusHandler->get(XOOPS_COMMENT_ACTIVE);
			$statusArr[1] =& $statusHandler->get(XOOPS_COMMENT_HIDDEN);
		}
		
		$render->setAttribute('statusArr', $statusArr);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=CommentList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=CommentList", 1, _MD_LEGACY_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=CommentList");
	}

	/**
	 * @static
	 * @return Return array as the informations of comments. If $comment has fatal status, return false.
	 */
	function loadCallbackFile(&$comment)
	{
		$handler =& xoops_gethandler('module');
		$module =& $handler->get($comment->get('com_modid'));
		
		if (!is_object($module)) {
			return false;
		}
		
		$comment_config = $module->getInfo('comments');
		
		//
		// Load call-back file
		//
		$file = XOOPS_MODULE_PATH . "/" . $module->get('dirname') . "/" . $comment_config['callbackFile'];
		if (!file_exists($file) || !isset($comment_config['callbackFile']) || empty($comment_config['callbackFile'])) {
			return false;
		}
		
		require_once $file;
		
		return $comment_config;
	}
	
	function doApprove($comment)
	{
		$comment_config = Legacy_CommentEditAction::loadCallbackFile($comment);
		
		if ($comment_config == false) {
			return;
		}
		
		$function = $comment_config['callback']['approve'];
		
		if (function_exists($function)) {
			call_user_func($function, $comment);
		}
		//we need to update also!
		$function = $comment_config['callback']['update'];
		
		if (function_exists($function)) {
			$comment_handler = xoops_gethandler('comment');
    			$criteria = new CriteriaCompo(new Criteria('com_modid', $comment->getVar('com_modid')));
			$criteria->add(new Criteria('com_itemid', $comment->getVar('com_itemid')));
			$criteria->add(new Criteria('com_status', XOOPS_COMMENT_ACTIVE));
			$comment_count = $comment_handler->getCount($criteria);
			call_user_func_array($function, array($comment->getVar('com_itemid'), $comment_count, $comment->getVar('com_id')));
		}
		
		$handler =& xoops_gethandler('member');

		//
		// TODO We should adjust the following lines and handler's design.
		// We think we should not use getUser() and updateUserByField in XCube 2.1.
		//
		$user =& $handler->getUser($comment->get('com_uid'));
		if (is_object($user)) {
			$handler->updateUserByField($user, 'posts', $user->get('posts') + 1);
		}

		//notification
		// RMV-NOTIFY
        		// trigger notification event if necessary
            	$notify_event = 'comment';
            	$not_modid = $comment->getVar('com_modid');
            	include_once XOOPS_ROOT_PATH . '/include/notification_functions.php';
            	$not_catinfo =& notificationCommentCategoryInfo($not_modid);
            	$not_category = $not_catinfo['name'];
            	$not_itemid = $comment->getVar('com_itemid');
            	$not_event = $notify_event;
            	$comment_tags = array();
                	$module_handler =& xoops_gethandler('module');
                	$not_module =& $module_handler->get($not_modid);
                	$com_config =& $not_module->getInfo('comments');
                	$comment_url = $com_config['pageName'] . '?';
		//Umm....not use com_exparams(--;;Fix Me!)	
                	//$extra_params = $comment->getVar('com_exparams');
                	//$comment_url .= $extra_params;
                	$comment_url .= $com_config['itemName'];
            	$comment_tags['X_COMMENT_URL'] = XOOPS_URL . '/modules/' . $not_module->getVar('dirname') . '/' .$comment_url . '=' . $comment->getVar('com_itemid').'&amp;com_id='.$comment->getVar('com_id').'&amp;com_rootid='.$comment->getVar('com_rootid').'#comment'.$comment->getVar('com_id');
            	$notification_handler =& xoops_gethandler('notification');
            	$notification_handler->triggerEvent ($not_category, $not_itemid, $not_event, $comment_tags, false, $not_modid);

	}
	
	function doUpdate($comment)
	{

		//
		// call back
		//
		$comment_config = Legacy_CommentEditAction::loadCallbackFile($comment);
		
		if ($comment_config == false) {
			return;
		}
		
		$function = $comment_config['callback']['update'];
		
		if (function_exists($function)) {
			$comment_handler = xoops_gethandler('comment');
    			$criteria = new CriteriaCompo(new Criteria('com_modid', $comment->getVar('com_modid')));
			$criteria->add(new Criteria('com_itemid', $comment->getVar('com_itemid')));
			$criteria->add(new Criteria('com_status', XOOPS_COMMENT_ACTIVE));
			$comment_count = $comment_handler->getCount($criteria);
			call_user_func_array($function, array($comment->getVar('com_itemid'), $comment_count, $comment->getVar('com_id')));
		}
	}
}

?>
