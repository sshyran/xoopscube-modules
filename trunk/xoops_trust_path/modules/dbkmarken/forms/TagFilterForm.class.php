<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractFilterForm.class.php";
require_once DBKMARKEN_TRUST_PATH . "/includes/function.php";

define('DBKMARKEN_TAG_SORT_KEY_TAG_ID', 1);
define('DBKMARKEN_TAG_SORT_KEY_TAG_NAME', 2);
define('DBKMARKEN_TAG_SORT_KEY_BM_ID', 3);
define('DBKMARKEN_TAG_SORT_KEY_UID', 4);
define('DBKMARKEN_TAG_SORT_KEY_REG_UNIXTIME', 5);
define('DBKMARKEN_TAG_SORT_KEY_DEFAULT', DBKMARKEN_TAG_SORT_KEY_TAG_ID);

class Dbkmarken_TagFilterForm extends Dbkmarken_AbstractFilterForm
{
	var $mSortKeys = array(
		DBKMARKEN_TAG_SORT_KEY_TAG_ID => 'tag_id',
		DBKMARKEN_TAG_SORT_KEY_TAG_NAME => 'tag_name',
		DBKMARKEN_TAG_SORT_KEY_BM_ID => 'bm_id',
		DBKMARKEN_TAG_SORT_KEY_UID => 'uid',
		DBKMARKEN_TAG_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return DBKMARKEN_TAG_SORT_KEY_DEFAULT;
	}

	/**
	 * @public
	 */
	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
	
		if (($value = $root->mContext->mRequest->getRequest('tag_id')) !== null) {
			$this->mNavi->addExtra('tag_id', $value);
			$this->_mCriteria->add(new Criteria('tag_id', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('tag_name')) !== null) {
			$this->mNavi->addExtra('tag_name', $value);
			$this->_mCriteria->add(new Criteria('tag_name', unescapeTag($value)));
			//$this->_mCriteria->add(new Criteria('tag_name', $value));
		}
	
		if (($value = $root->mContext->mRequest->getRequest('bm_id')) !== null) {
			$this->mNavi->addExtra('bm_id', $value);
			$this->_mCriteria->add(new Criteria('bm_id', $value));
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
