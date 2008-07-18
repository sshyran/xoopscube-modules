<?php
/**
 *
 * @package Legacy
 * @version $Id: ModuleUpdateForm.class.php,v 1.2 2007/06/25 04:05:23 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class Legacy_ModuleUpdateForm extends XCube_ActionForm
{
	function getTokenName()
	{
		return "module.legacy.ModuleUpdateForm.TOKEN." . $this->get('dirname');
	}

	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['dirname'] =& new XCube_StringProperty('dirname');
		$this->mFormProperties['force'] =& new XCube_BoolProperty('force');
	}

	function load(&$obj)
	{
		$this->set('dirname', $obj->get('dirname'));
	}

	function update(&$obj)
	{
		$obj->set('dirname', $this->get('dirname'));
	}
}

?>
