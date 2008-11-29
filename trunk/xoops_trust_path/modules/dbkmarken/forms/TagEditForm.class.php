<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Dbkmarken_TagEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.dbkmarken.TagEditForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tag_id'] =& new XCube_IntProperty('tag_id');
		$this->mFormProperties['tag_name'] =& new XCube_StringProperty('tag_name');
		$this->mFormProperties['bm_id'] =& new XCube_IntProperty('bm_id');
		$this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
		$this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['tag_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['tag_id']->setDependsByArray(array());
		$this->mFieldProperties['tag_id']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_TAG_ID);
	
		$this->mFieldProperties['tag_name'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['tag_name']->setDependsByArray(array('maxlength'));
		$this->mFieldProperties['tag_name']->addMessage('maxlength', _MD_DBKMARKEN_ERROR_MAXLENGTH, _MD_DBKMARKEN_LANG_TAG_NAME, '64');
		$this->mFieldProperties['tag_name']->addVar('maxlength', '64');
	
		$this->mFieldProperties['bm_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['bm_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['bm_id']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_BM_ID);
	
		$this->mFieldProperties['uid'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['reg_unixtime'] =& new XCube_FieldProperty($this);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('tag_id', $obj->get('tag_id'));
		$this->set('tag_name', $obj->get('tag_name'));
		$this->set('bm_id', $obj->get('bm_id'));
		$this->set('uid', $obj->get('uid'));
		$this->set('reg_unixtime', $obj->get('reg_unixtime'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
	//	$obj->set('tag_id', $this->get('tag_id'));
		$obj->set('tag_name', $this->get('tag_name'));
	//	$obj->set('bm_id', $this->get('bm_id'));
	//	$obj->set('uid', $this->get('uid'));
	//	$obj->set('reg_unixtime', $this->get('reg_unixtime'));
	}
}

?>
