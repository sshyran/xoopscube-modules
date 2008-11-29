<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Dbkmarken_BmDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.dbkmarken.BmDeleteForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['bm_id'] =& new XCube_IntProperty('bm_id');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['bm_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['bm_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['bm_id']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_BM_ID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('bm_id', $obj->get('bm_id'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('bm_id', $this->get('bm_id'));
	}
}

?>
