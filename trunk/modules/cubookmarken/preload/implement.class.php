<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Cubookmarken_Implement extends XCube_ActionFilter
{
	/**
	 * @public
	 */
	function preBlockFilter()
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add('Module.cubookmarken.Event.ImplementCubookmarken',"Cubookmarken_Implement::implement");

	}
	
	/**
	 * @private
	 */
	function implement($params)
	{
		//
		// Boot the action frame of the cubookmarken module directly.
		//
		$root =& XCube_Root::getSingleton();
		
		$_REQUEST['bm_title'] = $params['bm_title'];

		$root->mController->setupModuleContext('cubookmarken');
		$root->mLanguageManager->loadModuleMessageCatalog('cubookmarken');

//		$root->mController->setDialogMode(true);

		require_once XOOPS_MODULE_PATH . "/cubookmarken/class/Module.class.php";

		//from /legacy/kernel/Legacy_controller.class.php
		$handler =& xoops_gethandler('module');
		$module =& $handler->getByDirname('cubookmarken');
		if (!is_object($module)) {
			XCube_DelegateUtils::call('Legacy.Event.Exception.XoopsModuleNotFound', $dirname);
			$root->mController->executeRedirect(XOOPS_URL . '/', 1, "You can't access this URL.");	// TODO need message catalog.
			die();
		}

		$moduleRunner = new Cubookmarken_Module($module);
		$moduleRunner->setActionName('BmImplement');
		$root->mController->mExecute->add(array(&$moduleRunner, 'execute'));

		$root->mController->_processModule();

		$root->mController->execute();

//		$root->mController->executeView();

	}

}

?>
