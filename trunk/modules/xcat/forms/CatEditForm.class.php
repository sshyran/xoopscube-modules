<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_CatEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.CatEditForm.TOKEN";
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
		$this->mFormProperties['cat_title'] =& new XCube_StringProperty('cat_title');
		$this->mFormProperties['gr_id'] =& new XCube_IntProperty('gr_id');
		$this->mFormProperties['p_id'] =& new XCube_IntProperty('p_id');
		$this->mFormProperties['cat_desc'] =& new XCube_TextProperty('cat_desc');
		$this->mFormProperties['modules'] =& new XCube_TextProperty('modules');
		$this->mFormProperties['imageurl'] =& new XCube_TextProperty('imageurl');
		$this->mFormProperties['weight'] =& new XCube_IntProperty('weight');
		$this->mFormProperties['options'] =& new XCube_TextProperty('options');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['cat_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['cat_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['cat_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_CAT_ID);
	
		$this->mFieldProperties['cat_title'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['cat_title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['cat_title']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_CAT_TITLE, '255');
		$this->mFieldProperties['cat_title']->addMessage('maxlength', _MD_XCAT_ERROR_MAXLENGTH, _MD_XCAT_LANG_CAT_TITLE, '255');
		$this->mFieldProperties['cat_title']->addVar('maxlength', '255');
	
		$this->mFieldProperties['gr_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['gr_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['gr_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_GR_ID);
	
		$this->mFieldProperties['p_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['p_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['p_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_P_ID);
	
		$this->mFieldProperties['cat_desc'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['weight'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['weight']->setDependsByArray(array('required'));
		$this->mFieldProperties['weight']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_WEIGHT);
	
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('cat_id', $obj->get('cat_id'));
		$this->set('cat_title', $obj->get('cat_title'));
		$this->set('gr_id', $obj->get('gr_id'));
		$this->set('p_id', $obj->get('p_id'));
		$this->set('modules', $obj->get('modules'));
		$this->set('imageurl', $obj->get('imageurl'));
		$this->set('cat_desc', $obj->get('cat_desc'));
		$this->set('weight', $obj->get('weight'));
		$this->set('options', $obj->get('options'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		//$obj->set('cat_id', $this->get('cat_id'));
		$obj->set('cat_title', $this->get('cat_title'));
		//$obj->set('gr_id', $this->get('gr_id'));
		$obj->set('p_id', $this->get('p_id'));
		$obj->set('modules', $this->get('modules'));
		$obj->set('imageurl', $this->get('imageurl'));
		$obj->set('cat_desc', $this->get('cat_desc'));
		$obj->set('weight', $this->get('weight'));
		$obj->set('options', $this->get('options'));
	}
}

?>
