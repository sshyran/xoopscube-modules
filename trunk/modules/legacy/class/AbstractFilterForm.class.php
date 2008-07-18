<?php
/**
 *
 * @package Legacy
 * @version $Id: AbstractFilterForm.class.php,v 1.2 2007/06/24 14:58:45 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class Legacy_AbstractFilterForm
{
	var $mSort = 0;
	var $mSortKeys = array();
	var $_mCriteria = null;
	var $mNavi = null;
	
	var $_mHandler = null;
	
	function Legacy_AbstractFilterForm(&$navi, &$handler)
	{
		$this->mNavi =& $navi;
		$this->_mHandler =& $handler;
		
		$this->_mCriteria =& new CriteriaCompo();
		
		$this->mNavi->mGetTotalItems->add(array(&$this, 'getTotalItems'));
	}
	
	function getDefaultSortKey()
	{
	}
	
	function getTotalItems(&$total)
	{
		$total = $this->_mHandler->getCount($this->getCriteria());
	}
	
	function fetchSort()
	{
		$root =& XCube_Root::getSingleton();
		$this->mSort = intval($root->mContext->mRequest->getRequest('sort'));
		
		if (!isset($this->mSortKeys[abs($this->mSort)])) {
			$this->mSort = $this->getDefaultSortKey();
		}
		
		$this->mNavi->mSort['sort'] = $this->mSort;
	}

	function fetch()
	{
		$this->mNavi->fetch();
		$this->fetchSort();
	}
	
	function getSort()
	{
		$sortkey = abs($this->mNavi->mSort['sort']);
		return isset($this->mSortKeys[$sortkey]) ? $this->mSortKeys[$sortkey] : null;
	}

	function getOrder()
	{
		return ($this->mSort < 0) ? "DESC" : "ASC";
	}

	function getCriteria($start = null, $limit = null)
	{
		$t_start = ($start === null) ? $this->mNavi->getStart() : intval($start);
		$t_limit = ($limit === null) ? $this->mNavi->getPerpage() : intval($limit);
		
		$criteria = $this->_mCriteria;
		
		$criteria->setStart($t_start);
		$criteria->setLimit($t_limit);
		
		return $criteria;
	}
}

?>
