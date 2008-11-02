<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Cubookmarken_TagReplaceForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.cubookmarken.TagReplaceForm.TOKEN";
	}

	/**
	 * @public
	 */
	function prepare()
	{
		//
		// Set form properties
		//
		$this->mFormProperties['tag_name'] =& new XCube_StringProperty('tag_name');
		$this->mFormProperties['uid'] =& new XCube_IntProperty('uid');

		//
		// Set field properties
		//
		$this->mFieldProperties['tag_name'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['tag_name']->setDependsByArray(array('required', 'maxlength'));
		$this->mFieldProperties['tag_name']->addMessage('required', _MD_CUBOOKMARKEN_ERROR_REQUIRED, _MD_CUBOOKMARKEN_LANG_TAG_NAME);
		$this->mFieldProperties['tag_name']->addMessage('maxlength', _MD_CUBOOKMARKEN_ERROR_MAXLENGTH, _MD_CUBOOKMARKEN_LANG_TAG_NAME, '64');
		$this->mFieldProperties['tag_name']->addVar('maxlength', '64');
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$root = & XCube_Root::getSingleton();
		$this->set('tag_name', $obj->get('tag_name'));
		$this->set('uid', $root->mContext->mXoopsUser->get('uid'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		$root = & XCube_Root::getSingleton();
		$obj->set('tag_name', $this->get('tag_name'));
	}
}

?>
