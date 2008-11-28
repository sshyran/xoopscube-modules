<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_GrDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.GrDeleteForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['gr_id'] =& new XCube_IntProperty('gr_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['gr_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['gr_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['gr_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_GR_ID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('gr_id', $obj->get('gr_id'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('gr_id', $this->get('gr_id'));
	}
}

?>
