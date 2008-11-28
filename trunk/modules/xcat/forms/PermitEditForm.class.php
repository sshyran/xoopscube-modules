<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_PermitEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.PermitEditForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['permit_id'] =& new XCube_IntProperty('permit_id');
		$this->mFormProperties['cat_id'] =& new XCube_IntProperty('cat_id');
		$this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
		$this->mFormProperties['groupid'] =& new XCube_IntProperty('groupid');
		$this->mFormProperties['permissions'] =& new XCube_TextProperty('permissions');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['permit_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['permit_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['permit_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_PERMIT_ID);
	
		$this->mFieldProperties['cat_id'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['uid'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['groupid'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['permissions'] =& new XCube_FieldProperty($this);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('permit_id', $obj->get('permit_id'));
		$this->set('cat_id', $obj->get('cat_id'));
		$this->set('uid', $obj->get('uid'));
		$this->set('groupid', $obj->get('groupid'));
		$this->set('permissions', $obj->get('permissions'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		//$obj->set('permit_id', $this->get('permit_id'));
		$obj->set('cat_id', $this->get('cat_id'));
		$obj->set('uid', intval($this->get('uid')));
		$obj->set('groupid', intval($this->get('groupid')));
		$obj->set('permissions', $this->get('permissions'));
	}
}

?>
