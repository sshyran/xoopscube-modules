<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_PageNavigator.class.php";

class Cubookmarken_AbstractListAction extends Cubookmarken_AbstractAction
{
	var $mObjects = array();
	var $mFilter = null;

	/**
	 * @protected
	 */
	function &_getHandler()
	{
	}

	/**
	 * @protected
	 */
	function &_getFilterForm()
	{
	}

	/**
	 * @protected
	 */
	function &_getBaseUrl()
	{
	}

	/**
	 * @protected
	 */
	function &_getPageNavi()
	{
		$navi =& new XCube_PageNavigator($this->_getBaseUrl(), XCUBE_PAGENAVI_START);
		return $navi;
	}

	/**
	 * @public
	 */
	function getDefaultView()
	{
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();
	
		$handler =& $this->_getHandler();
		$this->mObjects =& $handler->getObjects($this->mFilter->getCriteria());
	
		return CUBOOKMARKEN_FRAME_VIEW_INDEX;
	}

	/**
	 * @public
	 */
	function execute()
	{
		return $this->getDefaultView();
	}
}

?>
