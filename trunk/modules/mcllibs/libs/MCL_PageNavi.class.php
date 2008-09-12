<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
define('MCL_PAGENAVI_START', 1);
define('MCL_PAGENAVI_PERPAGE', 2);
define('MCL_PAGENAVI_SORT', 1);
define('MCL_PAGENAVI_PAGE', 4);
define('MCL_PAGENAVI_DEFAULT_PERPAGE', 20);

class MCL_PageNavigator
{
  private $mStart = 0;
  private $mTotalItems = 0;
  private $mPerpage = MCL_PAGENAVI_DEFAULT_PERPAGE;
  private $mPerpageFreeze = false;
  private $mSort = array();
  private $mUrl = "";
  private $mPrefix = null;
  private $mExtra = array();
  private $mFlags = 0;

  public function __construct($url, $flags = MCL_PAGENAVI_START)
  {
    $this->mUrl = $url;
    $this->mFlags = $flags;
  }
  
  public function fetch()
  {
    $root = XCube_Root::getSingleton();
    
    $startKey = $this->getStartKey();
    $perpageKey = $this->getPerpageKey();
    
    if ($this->mFlags & MCL_PAGENAVI_START) {
      $t_start = $root->mContext->mRequest->getRequest($startKey);
      if ($t_start != null && intval($t_start) >= 0) {
        $this->mStart = intval($t_start);
      }
    }

    if ($this->mFlags & MCL_PAGENAVI_PERPAGE && !$this->mPerpageFreeze) {
      $t_perpage = $root->mContext->mRequest->getRequest($perpageKey);
      if ($t_perpage != null && intval($t_perpage) > 0) {
        $this->mPerpage = intval($t_perpage);
      }
    }
  }
  
  public function addExtra($key, $value)
  {
    $this->mExtra[$key] = $value;
  }
  
  public function removeExtra($key)
  {
    if ($this->mExtra[$key]) {
      unset($this->mExtra[$key]);
    }
  }
  
  public function getRenderBaseUrl($mask = null)
  {
    if ($mask == null) {
      $mask = array();
    }
    if (!is_array($mask)) {
      $mask = array($mask);
    }
    
    if (count($this->mExtra) > 0) {
      $tarr=array();
      
      foreach($this->mExtra as $key=>$value) {
        if (is_array($mask) && !in_array($key, $mask)) {
          $tarr[]=$key.'='.urlencode($value);
        }
      }
      
      if (count($tarr)==0) {
        return $this->mUrl;
      }
      
      if(strpos($this->mUrl, '?')!==false) {
        return $this->mUrl.'&amp;'.implode('&amp;', $tarr);
      } else {
        return $this->mUrl.'?'.implode('&amp;', $tarr);
      }
    }
    
    return $this->mUrl;
  }
  
  public function getRenderUrl($mask = null)
  {
    if ($mask != null && !is_array($mask)) {
      $mask = array($mask);
    }
    
    $demiliter = '?';
    $url = $this->getRenderBaseUrl($mask);
    
    if (strpos($url, '?')!==false) {
      $demiliter = '&amp;';
    }
    
    return $url.$demiliter.$this->getStartKey().'=';
  }
  
  public function renderUrlForSort()
  {
    if (count($this->mExtra) > 0) {
      $tarr = array();
      
      foreach ($this->mExtra as $key=>$value) {
        $tarr[] = $key.'='.urlencode($value);
      }
      
      $tarr[] = $this->getPerpageKey().'='.$this->mPerpage;
      
      if (strpos($this->mUrl, '?')!==false) {
        return $this->mUrl.'&amp;'.implode('&amp;', $tarr);
      } else {
        return $this->mUrl.'?'.implode('&amp;', $tarr);
      }
    }
    
    return $this->mUrl;
  }
  
  public function renderUrlForPage($page = null)
  {
    $tarr = array();
      
    foreach ($this->mExtra as $key=>$value) {
      $tarr[] = $key.'='.urlencode($value);
    }
      
    foreach ($this->mSort as $key=>$value) {
      $tarr[] = $key.'='.urlencode($value);
    }
    
    $tarr[] = $this->getPerpageKey().'='.$this->mPerpage;
    
    if ($page !== null) {
      $tarr[] = $this->getStartKey().'='.intval($page);
    }
      
    if (strpos($this->mUrl, '?')!==false) {
      return $this->mUrl.'&amp;'.implode('&amp;', $tarr);
    } else {
      return $this->mUrl.'?'.implode('&amp;', $tarr);
    }
    
    return $this->mUrl;
  }
  
  public function setStart($start)
  {
    $this->mStart = intval($start);
  }
  
  public function getStart()
  {
    return $this->mStart;
  }
  
  public function setTotalItems($total)
  {
    $this->mTotal = intval($total);
  }
  
  public function getTotalItems()
  {
    return $this->mTotal;
  }
  
  public function getTotalPages()
  {
    if ($this->mPerpage > 0) {
      return ceil($this->mTotal / $this->mPerpage);
    }
    return 0;
  }

  public function setPerpage($perpage)
  {
    $this->mPerpage = intval($perpage);
  }
  
  public function freezePerpage()
  {
    $this->mPerpageFreeze = true;
  }
  
  public function getPerpage()
  {
    return $this->mPerpage;
  }

  public function setPrefix($prefix)
  {
    $this->mPrefix = $prefix;
  }
  
  public function getPrefix()
  {
    return $this->mPrefix;
  }

  public function getStartKey()
  {
    return $this->mPrefix.'start';
  }

  public function getPerpageKey()
  {
    return $this->mPrefix.'perpage';
  }
  
  public function getCurrentPage()
  {
    return intval(floor(($this->mStart + $this->mPerpage) / $this->mPerpage));
  }
  
  public function hasPrivPage()
  {
    return ($this->mStart - $this->mPerpage) >= 0;
  }

  public function getPrivStart()
  {
    $prev = $this->mStart - $this->mPerpage;
    return ($prev > 0) ? $prev : 0;
  }

  public function hasNextPage()
  {
    return $this->mTotal > ($this->mStart + $this->mPerpage);
  }

  public function getNextStart()
  {
    $next = $this->mStart + $this->mPerpage;
    return ($this->mTotal > $next) ? $next : 0;
  }
}

class MCL_PageNavi
{
  public $mNavi = null;
  private $_mCriteria = null;
  private $_mHandler = null;
  private $_mPagenum = 10;
  private $_mUrl = 'index.php';
  private $_extra = array();
  
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
    $this->_mUrl = $url;
  }
  
  public function addSort($sort, $order = 'ASC')
  {
    $this->_mCriteria->addOrder($sort, $order);
  }
  
  public function addCriteria($criteria, $condition = 'AND')
  {
    $this->_mCriteria->add($criteria, $condition);
  }
  
  public function addExtra($key, $value)
  {
    $this->_extra[] = array('key' => $key, 'val' => $value);
  }
  
  public function fetch()
  {
    $this->mNavi = new MCL_PageNavigator($this->_mUrl);
    
    $this->mNavi->setTotalItems($this->_mHandler->getCount($this->_mCriteria));
    $this->mNavi->setPerpage($this->_mPagenum);
    foreach ($this->_extra as $extra) {
      $this->mNavi->addExtra($extra['key'], $extra['val']);
    }
    $this->mNavi->fetch();
  }

  public function getCriteria()
  {
    $this->_mCriteria->addOffset($this->mNavi->getStart());
    $this->_mCriteria->addRownum($this->mNavi->getPerpage());
    return $this->_mCriteria;
  }
}
?>