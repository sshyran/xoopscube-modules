<?php
/**
 *
 * @package Legacy
 * @version $Id: InstallListAction.class.php,v 1.3 2007/06/25 04:05:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

/***
 * @public
 * @internal
 * List up non-installation modules.
 */
class Legacy_InstallListAction extends Legacy_Action
{
	var $mModuleObjects = null;
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& xoops_getmodulehandler('non_installation_module');

		$this->mModuleObjects =& $handler->getObjects();
		
		return LEGACY_FRAME_VIEW_INDEX;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("install_list.html");
		$renderer->setAttribute('moduleObjects', $this->mModuleObjects);
	}
}

?>