<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractFilterForm.class.php";

define('DBKMARKEN_BM_SORT_KEY_BM_ID', 1);
define('DBKMARKEN_BM_SORT_KEY_BM_TITLE', 2);
define('DBKMARKEN_BM_SORT_KEY_URL', 3);
define('DBKMARKEN_BM_SORT_KEY_UID', 4);
define('DBKMARKEN_BM_SORT_KEY_MEMO', 5);
define('DBKMARKEN_BM_SORT_KEY_REG_UNIXTIME', 6);
define('DBKMARKEN_BM_SORT_KEY_DEFAULT', '-'. DBKMARKEN_BM_SORT_KEY_BM_ID);

class Dbkmarken_BmFilterForm extends Dbkmarken_AbstractFilterForm
{
	var $mSortKeys = array(
		DBKMARKEN_BM_SORT_KEY_BM_ID => 'bm_id',
		DBKMARKEN_BM_SORT_KEY_BM_TITLE => 'bm_title',
		DBKMARKEN_BM_SORT_KEY_URL => 'url',
		DBKMARKEN_BM_SORT_KEY_UID => 'uid',
		DBKMARKEN_BM_SORT_KEY_MEMO => 'memo',
		DBKMARKEN_BM_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return DBKMARKEN_BM_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('bm_id')) !== null) {
			$this->mNavi->addExtra('bm_id', $value);
			$this->_mCriteria->add(new Criteria('bm_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('bm_title')) !== null) {
			$this->mNavi->addExtra('bm_title', $value);
			$this->_mCriteria->add(new Criteria('bm_title', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('url')) !== null) {
			$this->mNavi->addExtra('url', $value);
			$this->_mCriteria->add(new Criteria('url', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('uid')) !== null) {
			$this->mNavi->addExtra('uid', $value);
			$this->_mCriteria->add(new Criteria('uid', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('reg_unixtime')) !== null) {
			$this->mNavi->addExtra('reg_unixtime', $value);
			$this->_mCriteria->add(new Criteria('reg_unixtime', $value));
		}
	
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
