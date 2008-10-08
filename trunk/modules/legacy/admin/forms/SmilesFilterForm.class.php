<?php
/**
 *
 * @package Legacy
 * @version $Id: SmilesFilterForm.class.php,v 1.2 2007/06/25 04:05:23 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/class/AbstractFilterForm.class.php";

define('SMILES_SORT_KEY_ID', 1);
define('SMILES_SORT_KEY_CODE', 2);
define('SMILES_SORT_KEY_SMILE_URL', 3);
define('SMILES_SORT_KEY_EMOTION', 4);
define('SMILES_SORT_KEY_DISPLAY', 5);

define('SMILES_SORT_KEY_DEFAULT', -SMILES_SORT_KEY_DISPLAY);
define('SMILES_SORT_KEY_MAXVALUE', 5);

class Legacy_SmilesFilterForm extends Legacy_AbstractFilterForm
{
	var $mSortKeys = array(
		SMILES_SORT_KEY_ID => 'id',
		SMILES_SORT_KEY_CODE => 'code',
		SMILES_SORT_KEY_SMILE_URL => 'smile_url',
		SMILES_SORT_KEY_EMOTION => 'emotion',
		SMILES_SORT_KEY_DISPLAY => 'display'
	);
	
	var $mKeyword = "";
	var $mOptionField = "";

	function getDefaultSortKey()
	{
		return SMILES_SORT_KEY_DEFAULT;
	}

	function fetch()
	{
		parent::fetch();
	
		$root =& XCube_Root::getSingleton();
		$code = $root->mContext->mRequest->getRequest('code');
		$smile_url = $root->mContext->mRequest->getRequest('smile_url');
		$emotion = $root->mContext->mRequest->getRequest('emotion');
		$display = $root->mContext->mRequest->getRequest('display');
		$option_field = $root->mContext->mRequest->getRequest('option_field');
		$search = $root->mContext->mRequest->getRequest('search');

		if (isset($code)) {
			$this->mNavi->addExtra('code', $code);
			$this->_mCriteria->add(new Criteria('code', $code));
		}
	
		if (isset($smile_url)) {
			$this->mNavi->addExtra('smile_url', $smile_url);
			$this->_mCriteria->add(new Criteria('smile_url', $smile_url));
		}
	
		if (isset($emotion)) {
			$this->mNavi->addExtra('emotion', $emotion);
			$this->_mCriteria->add(new Criteria('emotion', $emotion));
		}
	
		if (isset($display)) {
			$this->mNavi->addExtra('display', $display);
			$this->_mCriteria->add(new Criteria('display', $display));
		}

		if (isset($option_field)) {
			$this->mNavi->addExtra('option_field', $option_field);
			$this->mOptionField = $option_field;
			if ( $this->mOptionField == "visible" ) {
			$this->_mCriteria->add(new Criteria('display', 1));
			}
			elseif ( $this->mOptionField == "invisible" ) {
			$this->_mCriteria->add(new Criteria('display', 0));
			}
			else {
			//all
			}
		}

		//
		if (!empty($search)) {
			$this->mKeyword = $search;
			$this->mNavi->addExtra('search', $this->mKeyword);
			$search_criteria = new CriteriaCompo(new Criteria('code', '%' . $this->mKeyword . '%', 'LIKE'));
			$search_criteria->add(new Criteria('emotion', '%' . $this->mKeyword . '%', 'LIKE'), $condition='OR');
			$this->_mCriteria->add($search_criteria);
		}

		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());
	}
}

?>
