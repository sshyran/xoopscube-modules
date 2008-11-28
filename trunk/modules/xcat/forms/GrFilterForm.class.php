<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractFilterForm.class.php";

define('XCAT_GR_SORT_KEY_GR_ID', 1);
define('XCAT_GR_SORT_KEY_GR_TITLE', 2);
define('XCAT_GR_SORT_KEY_LEVEL', 3);
define('XCAT_GR_SORT_KEY_ACTIONS', 4);
define('XCAT_GR_SORT_KEY_DEFAULT', XCAT_GR_SORT_KEY_GR_ID);

class Xcat_GrFilterForm extends Xcat_AbstractFilterForm
{
	var $mSortKeys = array(
		XCAT_GR_SORT_KEY_GR_ID => 'gr_id',
		XCAT_GR_SORT_KEY_GR_TITLE => 'gr_title',
		XCAT_GR_SORT_KEY_LEVEL => 'level',
		XCAT_GR_SORT_KEY_ACTIONS => 'actions'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return XCAT_GR_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('gr_id')) !== null) {
			$this->mNavi->addExtra('gr_id', $value);
			$this->_mCriteria->add(new Criteria('gr_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('gr_title')) !== null) {
			$this->mNavi->addExtra('gr_title', $value);
			$this->_mCriteria->add(new Criteria('gr_title', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('level')) !== null) {
			$this->mNavi->addExtra('level', $value);
			$this->_mCriteria->add(new Criteria('level', $value));
		}
	
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
