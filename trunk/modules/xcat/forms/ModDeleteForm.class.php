<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_ModDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.ModDeleteForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['mod_id'] =& new XCube_IntProperty('mod_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['mod_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['mod_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['mod_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_MOD_ID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('mod_id', $obj->get('mod_id'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('mod_id', $this->get('mod_id'));
	}
}

?>
