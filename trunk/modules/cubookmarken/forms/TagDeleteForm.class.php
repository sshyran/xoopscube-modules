<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Cubookmarken_TagDeleteForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.cubookmarken.TagDeleteForm.TOKEN";
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
	
		//
		// Set field properties
		//
		$this->mFieldProperties['tag_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['tag_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['tag_id']->addMessage('required', _MD_CUBOOKMARKEN_ERROR_REQUIRED, _MD_CUBOOKMARKEN_LANG_TAG_ID);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('tag_id', $obj->get('tag_id'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$obj->set('tag_id', $this->get('tag_id'));
	}
}

?>
