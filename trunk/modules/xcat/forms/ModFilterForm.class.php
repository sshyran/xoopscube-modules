<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractFilterForm.class.php";

define('XCAT_MOD_SORT_KEY_MOD_ID', 1);
define('XCAT_MOD_SORT_KEY_GR_ID', 2);
define('XCAT_MOD_SORT_KEY_MID', 3);
define('XCAT_MOD_SORT_KEY_DIR_NAME', 4);
define('XCAT_MOD_SORT_KEY_WEIGHT', 5);
define('XCAT_MOD_SORT_KEY_OPTION', 6);
define('XCAT_MOD_SORT_KEY_DEFAULT', XCAT_MOD_SORT_KEY_MOD_ID);

class Xcat_ModFilterForm extends Xcat_AbstractFilterForm
{
	var $mSortKeys = array(
		XCAT_MOD_SORT_KEY_MOD_ID => 'mod_id',
		XCAT_MOD_SORT_KEY_GR_ID => 'gr_id',
		XCAT_MOD_SORT_KEY_MID => 'mid',
		XCAT_MOD_SORT_KEY_DIR_NAME => 'dir_name',
		XCAT_MOD_SORT_KEY_WEIGHT => 'weight',
		XCAT_MOD_SORT_KEY_OPTION => 'option'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return XCAT_MOD_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('mod_id')) !== null) {
			$this->mNavi->addExtra('mod_id', $value);
			$this->_mCriteria->add(new Criteria('mod_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('gr_id')) !== null) {
			$this->mNavi->addExtra('gr_id', $value);
			$this->_mCriteria->add(new Criteria('gr_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('mid')) !== null) {
			$this->mNavi->addExtra('mid', $value);
			$this->_mCriteria->add(new Criteria('mid', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('dir_name')) !== null) {
			$this->mNavi->addExtra('dir_name', $value);
			$this->_mCriteria->add(new Criteria('dir_name', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('weight')) !== null) {
			$this->mNavi->addExtra('weight', $value);
			$this->_mCriteria->add(new Criteria('weight', $value));
		}
	
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
