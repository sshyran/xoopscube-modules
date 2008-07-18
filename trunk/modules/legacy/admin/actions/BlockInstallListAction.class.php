<?php
/**
 *
 * @package Legacy
 * @version $Id: BlockInstallListAction.class.php,v 1.2 2007/06/25 04:05:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/class/AbstractListAction.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/admin/forms/BlockInstallFilterForm.class.php";

class Legacy_BlockInstallListAction extends Legacy_AbstractListAction
{
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('newblocks');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter =& new Legacy_BlockInstallFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return "./index.php?action=BlockInstallList";
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("blockinstall_list.html");

		//
		// Lazy load
		//
		foreach (array_keys($this->mObjects) as $key) {
			$this->mObjects[$key]->loadModule();
		}
		
		$render->setAttribute("objects", $this->mObjects);
		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}
}

?>
