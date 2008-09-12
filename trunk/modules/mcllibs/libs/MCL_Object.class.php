<?php
if ( !defined('XOBJ_DTYPE_STRING') ) {
  define('XOBJ_DTYPE_STRING', 1);
  define('XOBJ_DTYPE_TEXT', 2);
  define('XOBJ_DTYPE_INT', 3);
  define('XOBJ_DTYPE_FLOAT', 12);
  define('XOBJ_DTYPE_BOOL', 13);
}

class MCL_Object
{
  private $mVars = array();
  private $mIsNew = true;
  private $textFilter;
  
  public function __construct()
  {
    $root = XCube_Root::getSingleton();
    $this->textFilter = $root->getTextFilter();
  }
  
  public function setNew()
  {
    $this->mIsNew = true;
  }
  
  public function unsetNew()
  {
    $this->mIsNew = false;
  }

  public function isNew()
  {
    return $this->mIsNew;
  }
  
  public function initVar($key, $dataType, $value = null, $required = false, $size = null)
  {
    $this->mVars[$key] = array(
      'data_type' => $dataType,
      'value' => null,
      'required' => $required ? true : false,
      'maxlength' => $size ? intval($size) : null
    );
    
    $this->assignVar($key, $value);
  }
  
  public function assignVar($key, $value)
  {
    if (!isset($this->mVars[$key])) {
      return;
    }
    
    switch ($this->mVars[$key]['data_type']) {
      case XOBJ_DTYPE_BOOL:
        $this->mVars[$key]['value'] = $value ? true : false;
        break;

      case XOBJ_DTYPE_INT:
        $this->mVars[$key]['value'] = $value !== null ? intval($value) : null;
        break;

      case XOBJ_DTYPE_FLOAT:
        $this->mVars[$key]['value'] = $value !== null ? floatval($value) : null;
        break;

      case XOBJ_DTYPE_STRING:
        if ($this->mVars[$key]['maxlength'] !== null && $this->textFilter->strlen($value) > $this->mVars[$key]['maxlength']) {
          $this->mVars[$key]['value'] = $this->textFilter->cutstr($value, $this->mVars[$key]['maxlength']);
        } else {
          $this->mVars[$key]['value'] = $value;
        }
        break;

      case XOBJ_DTYPE_TEXT:
        $this->mVars[$key]['value'] = $value;
        break;
    }
  }
  
  public function assignVars($values)
  {
    foreach ($values as $key => $value) {
      $this->assignVar($key, $value);
    }
  }
  
  public function set($key, $value)
  {
    $this->assignVar($key, $value);
  }
  
  public function get($key)
  {
    return $this->mVars[$key]['value'];
  }
  
  public function gets()
  {
    $ret = array();
    
    foreach ($this->mVars as $key => $value) {
      $ret[$key] = $value['value'];
    }
    
    return $ret;
  }

  public function sets($values)
  {
    $this->assignVars($values);
  }

  public function getShow($key, $lang = false)
  {
    $value = null;
    
    switch ($this->mVars[$key]['data_type']) {
      case XOBJ_DTYPE_BOOL:
      case XOBJ_DTYPE_INT:
      case XOBJ_DTYPE_FLOAT:
        $value = $this->mVars[$key]['value'];
        break;
      case XOBJ_DTYPE_STRING:
        $root = XCube_Root::getSingleton();
        $value = $this->textFilter->toShow($this->mVars[$key]['value'], $lang);
        break;
      case XOBJ_DTYPE_TEXT:
        $root = XCube_Root::getSingleton();
        $value = $this->textFilter->toShowTarea($this->mVars[$key]['value'], 0, 1, 1, 1, 1);
        break;
    }
    
    return $value;
  }
  
  public function getEdit($key)
  {
    $value = null;
    
    switch ($this->mVars[$key]['data_type']) {
      case XOBJ_DTYPE_BOOL:
      case XOBJ_DTYPE_INT:
      case XOBJ_DTYPE_FLOAT:
        $value = $this->mVars[$key]['value'];
        break;
      case XOBJ_DTYPE_STRING:
      case XOBJ_DTYPE_TEXT:
        $value = $this->textFilter->toEdit($this->mVars[$key]['value']);
        break;
    }
    
    return $value;
  }
  
}
?>
