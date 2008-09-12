<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
 
  /*
  0:String
  1:int
  2:float
  3:bool
  4:unixtime2timestamp
  5:unixtime2datetime
  9:no escape
  */
define('_WHERE_FIELD_STRING',    0);
define('_WHERE_FIELD_INT',       1);
define('_WHERE_FIELD_FLOAT',     2);
define('_WHERE_FIELD_BOOL',      3);
define('_WHERE_FIELD_TIMESTAMP', 4);
define('_WHERE_FIELD_DATETIME',  5);
define('_WHERE_FIELD_NOESCAPE',  9);

class WhereComp
{
  private $_orders = array();
  private $_groups = array();
  private $_rownum;
  private $_offset;
  
  private $_childelement = array();
  private $_fields;
  
  public function __construct($ChildElement = null)
  {
    if (isset($ChildElement) && is_object($ChildElement)) {
      $this->add($ChildElement, '');
    }
  }
  
  public function add ($ChildElement, $condition = 'AND')
  {
    $c = count($this->_childelement);
    if ( $c == 0 ) {
      $condition = '';
    }
    $this->_childelement[$c]['element'] = $ChildElement;
    $this->_childelement[$c]['condition'] = $condition;
  }
  
  public function addOrder($field, $order = 'ASC')
  {
    if ( strtoupper($order) == 'ASC' ) {
      $order = 'ASC';
    } else {
      $order = 'DESC';
    }
    $this->_orders[] = array('field' => $field, 'order' => $order);
  }
  
  public function addGroup($field)
  {
    $this->_groups[] = $field;
  }
  
  public function addRownum($limit = 0)
  {
    $this->_rownum = intval($limit);
  }
  
  public function addOffset($start = 0)
  {
    $this->_offset = intval($start);
  }
  
  public function addField($fields)
  {
    $this->_fields = $fields;
  }
  
  public function renderWhere()
  {
    $ret = "";
    foreach ($this->_childelement as $child) {
      $ret.= $child['condition'].' '.$child['element']->render().' ';
    }
    if ( $ret != "" ) {
      $ret = ' WHERE '.$ret;
    }
    return $ret;
  }
  
  public function renderGroup()
  {
    if ( count($this->_groups) == 0 ) {
      return '';
    }
    
    if ( is_array($this->_fields) ) {
      foreach ( array_keys($this->_groups) as $i ) {
        if ( !in_array($this->_groups[$i], $this->_fields) ) {
          unset($this->_groups[$i]);
        }
      }
    }
    
    foreach ( array_keys($this->_groups) as $i ) {
      $groups[] = '`'.$this->_groups[$i].'`';
    }
    return ' GROUP BY '.implode(',', $groups);
  }
  
  public function renderOrder()
  {
    if ( count($this->_orders) == 0 ) {
      return '';
    }
    
    if ( is_array($this->_fields) ) {
      foreach ( array_keys($this->_orders) as $i ) {
        if ( !in_array($this->_orders[$i]['field'], $this->_fields) ) {
          unset($this->_orders[$i]);
        }
      }
    }
    
    foreach ( array_keys($this->_orders) as $i ) {
      $orders[] = '`'.$this->_orders[$i]['field'].'` '.$this->_orders[$i]['order'];
    }
    return ' ORDER BY '.implode(',', $orders);
  }
  
  public function renderLimit()
  {
    if ( $this->_rownum == "" ) {
      return '';
    } elseif ( empty($this->_offset) ) {
      $this->_offset = 0;
    }
    return ' LIMIT '.$this->_offset.','.$this->_rownum;
  }
  
  
  public function render()
  {
    $ret = $this->renderWhere();
    $ret.= $this->renderGroup();
    $ret.= $this->renderOrder();
    $ret.= $this->renderLimit();
    return $ret;
  }
}

class WhereTray
{
  private $_childelement = array();
  private $_fields;
  
  public function __construct($ChildElement = null)
  {
    if (isset($ChildElement) && is_object($ChildElement)) {
      $this->add($ChildElement, '');
    }
  }
  
  public function add ($ChildElement, $condition = 'AND')
  {
    $c = count($this->_childelement);
    if ( $c == 0 ) {
      $condition = '';
    }
    $this->_childelement[$c]['element'] = $ChildElement;
    $this->_childelement[$c]['condition'] = $condition;
  }
  
  public function render()
  {
    $ret = "";
    foreach ($this->_childelement as $child) {
      $ret.= $child['condition'].' '.$child['element']->render().' ';
    }
    if ( $ret != "" ) {
      $ret = ' ( '.$ret.' ) ';
    }
    return $ret;
  }
}

class WhereElement
{
  private $_field;
  
  function __construct($escape, $column, $value = '', $operator = '=', $function = '')
  {
    $this->_field['escape'] = $escape;
    $this->_field['column'] = $column;
    $this->_field['value'] = $value;
    $this->_field['operator'] = $operator;
    $this->_field['function'] = $function;
  }
  
  public function render()
  {
    if ( in_array(strtoupper($this->_field['operator']), array('IN', 'NOT IN')) ) {
      if ( !is_array($this->_field['value']) ) {
        $this->_field['value'] = array($this->_field['value']);
      }
      foreach ( array_keys($this->_field['value']) as $i ) {
        $values[] = $this->_escape($this->_field['escape'], $this->_field['value'][$i]);
      }
      $value = '('.implode(',', $values).')';
    } elseif ( strtoupper($this->_field['operator']) == 'IS' ) {
      if ( strtoupper($this->_field['value']) == 'NULL' ) {
        $value = 'NULL';
      } else {
        $value = 'NOT NULL';
      }
    } else {
      $value = $this->_escape($this->_field['escape'], $this->_field['value']);
    }
    
    if ( !empty($this->_field['function']) ) {
      $column = sprintf($this->_field['function'], '`'.$this->_field['column'].'`');
    } else {
      $column = '`'.$this->_field['column'].'`';
    }
    
    return $column.' '.$this->_field['operator']. ' '.$value;
  }

  private function _escape($type, $value)
  {
    switch ($type) {
      case _WHERE_FIELD_STRING:    $value = "'".mysql_real_escape_string($value)."'"; break;
      case _WHERE_FIELD_INT:       $value = intval($value); break;
      case _WHERE_FIELD_FLOAT:     $value = floatval($value); break;
      case _WHERE_FIELD_BOOL:      $value = ($value) ? 1 : 0; break;
      case _WHERE_FIELD_TIMESTAMP: $value = date('YmdHis', intval($value)); break;
      case _WHERE_FIELD_DATETIME:  $value = date('Y-m-d H:i:s', intval($value)); break;
      case _WHERE_FIELD_NOESCAPE:  break;
      default: $value = "''";
    }
    return $value;
  }
}
?>
