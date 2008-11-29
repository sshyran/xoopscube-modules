<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/class/Legacy_Validator.class.php";

class Dbkmarken_BmEditForm extends XCube_ActionForm
{
	/**
	 * @public
	 */
	function getTokenName()
	{
		return "module.dbkmarken.BmEditForm.TOKEN";
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
		$this->mFormProperties['bm_title'] =& new XCube_StringProperty('bm_title');
		$this->mFormProperties['url'] =& new XCube_StringProperty('url');
		$this->mFormProperties['uid'] =& new XCube_IntProperty('uid');
		$this->mFormProperties['memo'] =& new XCube_TextProperty('memo');
		$this->mFormProperties['reg_unixtime'] =& new XCube_IntProperty('reg_unixtime');
	
		//
		// Set field properties
		//
		$this->mFieldProperties['bm_id'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['bm_id']->setDependsByArray(array('required'));
		$this->mFieldProperties['bm_id']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_BM_ID);
	
		$this->mFieldProperties['bm_title'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['bm_title']->setDependsByArray(array('required','maxlength'));
		$this->mFieldProperties['bm_title']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_BM_TITLE, '255');
		$this->mFieldProperties['bm_title']->addMessage('maxlength', _MD_DBKMARKEN_ERROR_MAXLENGTH, _MD_DBKMARKEN_LANG_BM_TITLE, '255');
		$this->mFieldProperties['bm_title']->addVar('maxlength', '255');
	
		$this->mFieldProperties['url'] =& new XCube_FieldProperty($this);
		$this->mFieldProperties['url']->setDependsByArray(array('required','maxlength','mask'));
		$this->mFieldProperties['url']->addMessage('required', _MD_DBKMARKEN_ERROR_REQUIRED, _MD_DBKMARKEN_LANG_URL, '255');
		$this->mFieldProperties['url']->addMessage('maxlength', _MD_DBKMARKEN_ERROR_MAXLENGTH, _MD_DBKMARKEN_LANG_URL, '255');
		$this->mFieldProperties['url']->addVar('maxlength', '255');
		$this->mFieldProperties['url']->addMessage('mask', _MD_DBKMARKEN_ERROR_URLMASK, 'http://');
		$this->mFieldProperties['url']->addVar('mask', '#^(http:\/\/|https:\/\/|file:\/\/).*#');
	
		$this->mFieldProperties['uid'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['memo'] =& new XCube_FieldProperty($this);
	
		$this->mFieldProperties['reg_unixtime'] =& new XCube_FieldProperty($this);
	}

	/**
	 * @public
	 */
	function load(&$obj)
	{
		$this->set('bm_id', $obj->get('bm_id'));
		$this->set('bm_title', $obj->get('bm_title'));
		$this->set('url', $obj->get('url'));
		$this->set('uid', $obj->get('uid'));
		$this->set('memo', $obj->get('memo'));
		$this->set('reg_unixtime', $obj->get('reg_unixtime'));
	}

	/**
	 * @public
	 */
	function update(&$obj)
	{
	//	$obj->set('bm_id', $this->get('bm_id'));
		$obj->set('bm_title', $this->get('bm_title'));
		$obj->set('url', $this->get('url'));
	//	$obj->set('uid', $this->get('uid'));
		$obj->set('memo', $this->get('memo'));
	//	$obj->set('reg_unixtime', $this->get('reg_unixtime'));
	}
}

?>
