<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class TableObjectHandler
{
  protected $mTable;
  protected $mPrimary;
  protected $mClass;
  
  protected $db;
  protected $_sql;
  
  public function __construct($table, $primary, $class)
  {
    $root = XCube_Root::getSingleton();
    $this->db = $root->mController->getDB();
    $this->mTable = $this->db->prefix($table);
    if ( is_array($primary) ) {
      $this->mPrimary = $primary;
    } else {
      $this->mPrimary = array($primary);
    }
    $this->mClass = $class;
  }
  
  public function get_sqlquery()
  {
    return $this->_sql;
  }
  
  public function create($isNew = true)
  {
    $obj = null;
    if (class_exists($this->mClass)) {
      $obj = new $this->mClass();
      if ($isNew) {
        $obj->setNew();
      }
    }
    return $obj;
  }
  
  public function get($id)
  {
    $ret = null;
    
    $WhereComp = new WhereComp();
    if ( is_array($id) ) {
      foreach ( array_keys($id) as $i ) {
        $WhereComp->add(new WhereElement(1, $this->mPrimary[$i], $id[$i]));
      }
    } else {
      $WhereComp->add(new WhereElement(1, $this->mPrimary[0], $id));
    }
    
    $objArr = $this->getObjects($WhereComp);
    
    if (count($objArr) == 1) {
      $ret = $objArr[0];
    }
    return $ret;
  }
  
  public function gets($id, $order = array())
  {
    $WhereComp = new WhereComp();
    if ( is_array($id) ) {
      foreach ( array_keys($id) as $i ) {
        $WhereComp->add(new WhereElement(1, $this->mPrimary[$i], $id[$i]));
      }
    } else {
      $WhereComp->add(new WhereElement(1, $this->mPrimary[0], $id));
    }
    
    foreach ( $order as $field => $asc ) {
      $WhereComp->addOrder($field, $asc);
    }
    
    return $this->getObjects($WhereComp);
  }
  
  public function getMaxSeq($field, $id = false)
  {
    $num = 1;
    if ( is_array($id) ) {
      $WhereComp = new WhereComp();
      foreach ( array_keys($id) as $i ) {
        $WhereComp->add(new WhereElement(1, $this->mPrimary[$i], $id[$i]));
      }
    }
    
    $this->_sql = "SELECT IFNULL(MAX(`".$field."`), 0) + 1 FROM `" . $this->mTable . "`";
    if ( isset($WhereComp) ) {
      $this->_sql.= $WhereComp->render();
    }

    $result = $this->db->query($this->_sql);
    if ($result) {
      list($num) = $this->db->fetchRow($result);
    }
    return $num;
  }
  
  public function getObjects($criteria = null, $id_as_key = false)
  {
    $ret = array();
    
    $this->_sql = "SELECT * FROM `" . $this->mTable . "`";
    
    if ($criteria !== null && is_a($criteria, 'WhereComp')) {
      $this->_sql.= $criteria->render();
    }
    
    
    $result = $this->db->query($this->_sql);
    if (!$result) {
      return $ret;
    }
    while ($row = $this->db->fetchArray($result)) {
      $obj = new $this->mClass();
      $obj->assignVars($row);
      $obj->unsetNew();
      
      if ($id_as_key && count($this->mPrimary) == 1)  {
        $ret[$obj->get($this->mPrimary[0])] = $obj;
      } else {
        $ret[] = $obj;
      }
      unset($obj);
    }
    return $ret;
  }
  
  public function getCount($criteria = null)
  {
    $num = 0;
    $this->_sql = "SELECT COUNT(*) c FROM `" . $this->mTable . "`"; 
    if ($criteria !== null && is_a($criteria, 'WhereComp')) {
      $this->_sql.= $criteria->render();
    }
    $result = $this->db->query($this->_sql);
    if ($result) {
      list($num) = $this->db->fetchRow($result);
    }
    return $num;
  }
  
  public function insert(&$obj, $force = false)
  {
    if (!is_a($obj, $this->mClass)) {
      return false;
    }

    $new_flag = false;
    
    if ($obj->isNew()) {
      $new_flag = true;
      $this->_sql = $this->_insert($obj);
    } else {
      $this->_sql = $this->_update($obj);
    }
    $result = $force ? $this->db->queryF($this->_sql) : $this->db->query($this->_sql);

    if (!$result){
      return false;
    }
    
    if ( $new_flag && count($this->mPrimary) == 1) {
      $obj->setVar($this->mPrimary[0], $this->db->getInsertId());
    }

    return true;
  }

  protected function _insert($obj)
  {
    $fileds = array();
    $values = array();

    $arr = $this->_makeVars4sql($obj);

    foreach($arr as $_name => $_value) {
      $fields[] = '`'.$_name.'`';
      $values[] = $_value;
    }

    $sql = @sprintf("INSERT INTO `" . $this->mTable . "` ( %s ) VALUES ( %s )", implode(",", $fields), implode(",", $values));

    return $sql;
  }

  protected function _update($obj)
  {
    $set_lists = array();
    $where = "";
    
    if ( is_array($this->mPrimary) ) {
      
    }

    $arr = $this->_makeVars4sql($obj);

    foreach ($arr as $_name => $_value) {
      if ( in_array($_name, $this->mPrimary) ) {
        $where[] = '`'.$_name.'`='.$_value;
      } else {
        $set_lists[] = '`'.$_name.'`='.$_value;
      }
    }

    $sql = @sprintf("UPDATE `" . $this->mTable . "` SET %s WHERE %s", implode(',',$set_lists), implode(' AND ',$where));

    return $sql;
  }

  protected function _makeVars4sql($obj)
  {
    $ret = array();
    foreach ($obj->gets() as $key => $value) {
      switch ($obj->mVars[$key]['data_type']) {
        case XOBJ_DTYPE_STRING:
        case XOBJ_DTYPE_TEXT:
          $ret[$key] = $this->db->quoteString($value);
          break;
        default:
          $ret[$key] = $value;
      }
    }
    
    return $ret;
  }
  

  public function delete($obj, $force = false)
  {
    $WhereComp = new WhereComp();
    foreach ( $this->mPrimary as $pkey ) {
      $WhereComp->add(new WhereElement(1, $pkey, $obj->get($pkey)));
    }
    
    $this->_sql = "DELETE FROM `".$this->mTable."` ".$WhereComp->render(); 
    return $force ? $this->db->queryF($this->_sql) : $this->db->query($this->_sql);
  }
  
  public function deleteAll($criteria, $force = false)
  {
    $objs = $this->getObjects($criteria);
    
    $flag = true;
    
    foreach ($objs as $obj) {
      $flag = $this->delete($obj, $force);
    }
    
    return $flag;
  }
}
?>
