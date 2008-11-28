<?php
/**
 * @file
 * @package xcat
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/xcat/class/AbstractFilterForm.class.php";

define('XCAT_CAT_SORT_KEY_CAT_ID', 1);
define('XCAT_CAT_SORT_KEY_CAT_TITLE', 2);
define('XCAT_CAT_SORT_KEY_GR_ID', 3);
define('XCAT_CAT_SORT_KEY_P_ID', 4);
define('XCAT_CAT_SORT_KEY_CAT_DESC', 5);
define('XCAT_CAT_SORT_KEY_WEIGHT', 6);
define('XCAT_CAT_SORT_KEY_OPTIONS', 7);
define('XCAT_CAT_SORT_KEY_DEFAULT', XCAT_CAT_SORT_KEY_CAT_ID);

class Xcat_CatFilterForm extends Xcat_AbstractFilterForm
{
	var $mSortKeys = array(
		XCAT_CAT_SORT_KEY_CAT_ID => 'cat_id',
		XCAT_CAT_SORT_KEY_CAT_TITLE => 'cat_title',
		XCAT_CAT_SORT_KEY_GR_ID => 'gr_id',
		XCAT_CAT_SORT_KEY_P_ID => 'p_id',
		XCAT_CAT_SORT_KEY_CAT_DESC => 'cat_desc',
		XCAT_CAT_SORT_KEY_WEIGHT => 'weight',
		XCAT_CAT_SORT_KEY_OPTIONS => 'options'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return XCAT_CAT_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('cat_id')) !== null) {
			$this->mNavi->addExtra('cat_id', $value);
			$this->_mCriteria->add(new Criteria('cat_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('cat_title')) !== null) {
			$this->mNavi->addExtra('cat_title', $value);
			$this->_mCriteria->add(new Criteria('cat_title', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('gr_id')) !== null) {
			$this->mNavi->addExtra('gr_id', $value);
			$this->_mCriteria->add(new Criteria('gr_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('p_id')) !== null) {
			$this->mNavi->addExtra('p_id', $value);
			$this->_mCriteria->add(new Criteria('p_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('weight')) !== null) {
			$this->mNavi->addExtra('weight', $value);
			$this->_mCriteria->add(new Criteria('weight', $value));
		}
	
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
