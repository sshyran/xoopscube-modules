<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require XOOPS_ROOT_PATH.'/core/XCube_PageNavigator.class.php';

class UsersearchPageNavi
{
  private $_mCriteria = null;
  private $_mHandler = null;
  
  public $mNavi = null;
  
  private $_mPagenum = 10;
  private $_mUrl = 'index.php';
  private $_total = 0;
  
  public function __construct($handler, $criteria = null)
  {
    $this->_mHandler = $handler;
    if ( is_object($criteria) ) {
      $this->_mCriteria = $criteria;
    } else {
      $this->_mCriteria = new WhereComp();
    }
  }
  
  public function setPagenum($num)
  {
    $this->_mPagenum = intval($num);
  }
  
  public function setUrl($url)
  {
    $this->mUrl = $url;
  }
  
  public function addSort($sort, $order = 'ASC')
  {
    $this->_mCriteria->addOrder($sort, $order);
  }
  
  public function addCriteria($criteria, $condition = 'AND')
  {
    $this->_mCriteria->add($criteria, $condition);
  }
  
  public function getTotalItems(&$total)
  {
    $total = $this->total;
  }
  
  public function fetch()
  {
    $this->total = $this->_mHandler->getCount($this->_mCriteria);
    $this->mNavi = new XCube_PageNavigator($this->mUrl);
    $this->mNavi->mGetTotalItems->add(array(&$this, 'getTotalItems'));
    $this->mNavi->setPerpage($this->_mPagenum);
    $this->mNavi->mFetch->add(array(&$this, 'fetchNaviControl'));
    $this->mNavi->fetch();
  }
  
  function fetchNaviControl()
  {  
    $startKey = $this->mNavi->getStartKey();
    $perpageKey = $this->mNavi->getPerpageKey();
    
    if ($this->mNavi->mFlags & XCUBE_PAGENAVI_START) {
      $t_start = isset($_GET[$startKey]) ? intval($_GET[$startKey]) : 0;
      if ($t_start >= 0) {
        $this->mNavi->mStart = $t_start;
      }
    }

    if ($this->mNavi->mFlags & XCUBE_PAGENAVI_PERPAGE && !$this->mNavi->mPerpageFreeze) {
      $t_perpage = isset($_GET[$perpageKey]) ? intval($_GET[$perpageKey]) : 0;
      if ($t_perpage > 0) {
        $this->mNavi->mPerpage = $t_perpage;
      }
    }
  }
  
  public function getCriteria()
  {
    $this->_mCriteria->addOffset($this->mNavi->getStart());
    $this->_mCriteria->addRownum($this->mNavi->getPerpage());
    return $this->_mCriteria;
  }
}
?>
