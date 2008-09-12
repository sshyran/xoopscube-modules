<?php
/**
 * @file
 * @package cubookmarken
 * @version $Id$
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/cubookmarken/class/AbstractFilterForm.class.php";
require_once XOOPS_MODULE_PATH . "/cubookmarken/include/function.php";

define('CUBOOKMARKEN_TAG_SORT_KEY_TAG_ID', 1);
define('CUBOOKMARKEN_TAG_SORT_KEY_TAG_NAME', 2);
define('CUBOOKMARKEN_TAG_SORT_KEY_BM_ID', 3);
define('CUBOOKMARKEN_TAG_SORT_KEY_UID', 4);
define('CUBOOKMARKEN_TAG_SORT_KEY_REG_UNIXTIME', 5);
define('CUBOOKMARKEN_TAG_SORT_KEY_DEFAULT', CUBOOKMARKEN_TAG_SORT_KEY_TAG_ID);

class Cubookmarken_TagFilterForm extends Cubookmarken_AbstractFilterForm
{
	var $mSortKeys = array(
		CUBOOKMARKEN_TAG_SORT_KEY_TAG_ID => 'tag_id',
		CUBOOKMARKEN_TAG_SORT_KEY_TAG_NAME => 'tag_name',
		CUBOOKMARKEN_TAG_SORT_KEY_BM_ID => 'bm_id',
		CUBOOKMARKEN_TAG_SORT_KEY_UID => 'uid',
		CUBOOKMARKEN_TAG_SORT_KEY_REG_UNIXTIME => 'reg_unixtime'
	);

	/**
	 * @public
	 */
	function getDefaultSortKey()
	{
		return CUBOOKMARKEN_TAG_SORT_KEY_DEFAULT;
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
