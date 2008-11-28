<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Xcat_GrEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.xcat.GrEditForm.TOKEN";
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
		$this->mFormProperties['gr_title'] =& new XCube_StringProperty('gr_title');
		$this->mFormProperties['level'] =& new XCube_IntProperty('level');
		$this->mFormProperties['actions'] =& new XCube_TextProperty('actions');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['gr_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['gr_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['gr_id']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_GR_ID);
	
		$this->mFieldProperties['gr_title'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['gr_title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['gr_title']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_GR_TITLE, '255');
		$this->mFieldProperties['gr_title']->addMessage('maxlength', _MD_XCAT_ERROR_MAXLENGTH, _MD_XCAT_LANG_GR_TITLE, '255');
		$this->mFieldProperties['gr_title']->addVar('maxlength', '255');
	
		$this->mFieldProperties['level'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['level']->setDependsByArray(array('required'));
		$this->mFieldProperties['level']->addMessage('required', _MD_XCAT_ERROR_REQUIRED, _MD_XCAT_LANG_LEVEL);
	
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('gr_id', $obj->get('gr_id'));
		$this->set('gr_title', $obj->get('gr_title'));
		$this->set('level', $obj->get('level'));
		$this->set('actions', $obj->get('actions'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
		//$obj->set('gr_id', $this->get('gr_id'));
		$obj->set('gr_title', $this->get('gr_title'));
		$obj->set('level', $this->get('level'));
		//actions
		$actions_key = xoops_getrequest('actions_key');
		$actions_title = xoops_getrequest('actions_title');
		$actions_default = xoops_getrequest('actions_default');
		$actions = array();
		foreach(array_keys($actions_key) as $key){
			if(! $actions_title[$key] || ! $actions_key[$key]){
				//TODO:error
			}
			else{
				$actions['title'][$actions_key[$key]] = $actions_title[$key];
				$actions['default'][$actions_key[$key]] = $actions_default[$key];
			}
		}
		$obj->set('actions', serialize($actions));
	}
}

?>
