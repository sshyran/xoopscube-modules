<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractFilterForm.class.php";

define('XCAT_PERMIT_SORT_KEY_PERMIT_ID', 1);
define('XCAT_PERMIT_SORT_KEY_CAT_ID', 2);
define('XCAT_PERMIT_SORT_KEY_UID', 3);
define('XCAT_PERMIT_SORT_KEY_GROUPID', 4);
define('XCAT_PERMIT_SORT_KEY_PERMISSIONS', 5);
define('XCAT_PERMIT_SORT_KEY_DEFAULT', XCAT_PERMIT_SORT_KEY_PERMIT_ID);

class Xcat_PermitFilterForm extends Xcat_AbstractFilterForm
{
	var $mSortKeys = array(
		XCAT_PERMIT_SORT_KEY_PERMIT_ID => 'permit_id',
		XCAT_PERMIT_SORT_KEY_CAT_ID => 'cat_id',
		XCAT_PERMIT_SORT_KEY_UID => 'uid',
		XCAT_PERMIT_SORT_KEY_GROUPID => 'groupid',
		XCAT_PERMIT_SORT_KEY_PERMISSIONS => 'permissions'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return XCAT_PERMIT_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('permit_id')) !== null) {
			$this->mNavi->addExtra('permit_id', $value);
			$this->_mCriteria->add(new Criteria('permit_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('cat_id')) !== null) {
			$this->mNavi->addExtra('cat_id', $value);
			$this->_mCriteria->add(new Criteria('cat_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
			$this->mNavi->addExtra('uid', $value);
			$this->_mCriteria->add(new Criteria('uid', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('groupid')) !== null) {
			$this->mNavi->addExtra('groupid', $value);
			$this->_mCriteria->add(new Criteria('groupid', $value));
		}
	
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
