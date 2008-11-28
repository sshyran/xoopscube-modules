<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_CatDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.CatDeleteForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['cat_id'] =& new XCube_IntProperty('cat_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['cat_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['cat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['cat_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_CAT_ID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('cat_id', $obj->get('cat_id'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('cat_id', $this->get('cat_id'));
	}
}

?>
