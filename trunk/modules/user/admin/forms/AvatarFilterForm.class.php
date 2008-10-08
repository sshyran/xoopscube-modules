<?php
/**
 * @package user
 * @version $Id: AvatarFilterForm.class.php,v 1.1 2007/05/15 02:34:39 minahito Exp $
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/user/class/AbstractFilterForm.class.php";

define('AVATAR_SORT_KEY_AVATAR_ID', 1);
define('AVATAR_SORT_KEY_AVATAR_FILE', 2);
define('AVATAR_SORT_KEY_AVATAR_NAME', 3);
define('AVATAR_SORT_KEY_AVATAR_MIMETYPE', 4);
define('AVATAR_SORT_KEY_AVATAR_CREATED', 5);
define('AVATAR_SORT_KEY_AVATAR_DISPLAY', 6);
define('AVATAR_SORT_KEY_AVATAR_WEIGHT', 7);
define('AVATAR_SORT_KEY_AVATAR_TYPE', 8);
define('AVATAR_SORT_KEY_MAXVALUE', 8);

define('AVATAR_SORT_KEY_DEFAULT', AVATAR_SORT_KEY_AVATAR_ID);

class User_AvatarFilterForm extends User_AbstractFilterForm
{
	var $mSortKeys = array(
		AVATAR_SORT_KEY_AVATAR_ID => 'avatar_id',
		AVATAR_SORT_KEY_AVATAR_FILE => 'avatar_file',
		AVATAR_SORT_KEY_AVATAR_NAME => 'avatar_name',
		AVATAR_SORT_KEY_AVATAR_MIMETYPE => 'avatar_mimetype',
		AVATAR_SORT_KEY_AVATAR_CREATED => 'avatar_created',
		AVATAR_SORT_KEY_AVATAR_DISPLAY => 'avatar_display',
		AVATAR_SORT_KEY_AVATAR_WEIGHT => 'avatar_weight',
		AVATAR_SORT_KEY_AVATAR_TYPE => 'avatar_type'
	);

	var $mKeyword = "";
	var $mOptionField = "";
	
	function getDefaultSortKey()
	{
		return AVATAR_SORT_KEY_DEFAULT;
	}

	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
		$avatar_display = $root->mContext->mRequest->getRequest('avatar_display');
		$avatar_type = $root->mContext->mRequest->getRequest('avatar_type');
		$option_field = $root->mContext->mRequest->getRequest('option_field');
		$search = $root->mContext->mRequest->getRequest('search');

		if (isset($avatar_display)) {
			$this->mNavi->addExtra('avatar_display', $avatar_display);
			$this->_mCriteria->add(new Criteria('avatar_display', array(XOBJ_DTYPE_BOOL, $avatar_display)));
		}
	
		if (isset($avatar_type)) {
			$this->mNavi->addExtra('avatar_type', $avatar_type);
			$this->_mCriteria->add(new Criteria('avatar_type', array(XOBJ_DTYPE_STRING, $avatar_type)));
		}

		if (isset($option_field)) {
			$this->mNavi->addExtra('option_field', $option_field);
			$this->mOptionField = $option_field;
			if ( $this->mOptionField == "system" ) {
			//only system avatar
			$this->_mCriteria->add(new Criteria('avatar_type', 'S'));
			}
			elseif ( $this->mOptionField == "custom" ) {
			//only custom avatar
			$this->_mCriteria->add(new Criteria('avatar_type', 'C'));
			}
			else {
			//all
			}
		}

		//
		if (!empty($search)) {
			$this->mKeyword = $search;
			$this->mNavi->addExtra('search', $this->mKeyword);
			$this->_mCriteria->add(new Criteria('avatar_name', '%' . $this->mKeyword . '%', 'LIKE'));
		}
		
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
