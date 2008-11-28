<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_ModEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.ModEditForm.TOKEN";
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
		$this->mFormProperties['gr_id'] =& new XCube_IntProperty('gr_id');
		$this->mFormProperties['mid'] =& new XCube_IntProperty('mid');
		$this->mFormProperties['dir_name'] =& new XCube_StringProperty('dir_name');
		$this->mFormProperties['weight'] =& new XCube_IntProperty('weight');
		$this->mFormProperties['option'] =& new XCube_TextProperty('option');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['mod_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['mod_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['mod_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_MOD_ID);
	
		$this->mFieldProperties['gr_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['gr_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['gr_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_GR_ID);
	
		$this->mFieldProperties['mid'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['mid']->setDependsByArray(array('required'));
		$this->mFieldProperties['mid']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_MID);
	
		$this->mFieldProperties['dir_name'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['dir_name']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['dir_name']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_DIR_NAME, '25');
		$this->mFieldProperties['dir_name']->addMessage('maxlength', _MD_XCAT_ERROR_MAXLENGTH, _MD_XCAT_LANG_DIR_NAME, '25');
		$this->mFieldProperties['dir_name']->addVar('maxlength', '25');
	
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('mod_id', $obj->get('mod_id'));
		$this->set('gr_id', $obj->get('gr_id'));
		$this->set('mid', $obj->get('mid'));
		$this->set('dir_name', $obj->get('dir_name'));
		$this->set('weight', $obj->get('weight'));
		$this->set('option', $obj->get('option'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		//$obj->set('mod_id', $this->get('mod_id'));
		$obj->set('gr_id', $this->get('gr_id'));
		$obj->set('mid', $this->get('mid'));
		$obj->set('dir_name', $this->get('dir_name'));
		$obj->set('weight', $this->get('weight'));
		$obj->set('option', $this->get('option'));
	}
}

?>
