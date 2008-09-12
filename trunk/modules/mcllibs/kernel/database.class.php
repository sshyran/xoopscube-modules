<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class MCL_MySQL
{
  private $connect;
  private $result;
  private $errors = array();
  private static $instance;
  
  public static function getInstance()
  {
    if ( !isset(self::$instance) ) {
      self::$instance = new MCL_MySQL();
    }
    return self::$instance;
  }
  
  private function __construct()
  {
    $this->connect();
  }
  
  private function connect()
  {
    $this->connect = @mysql_connect(XOOPS_DB_HOST, XOOPS_DB_USER, XOOPS_DB_PASS);
    if ( !$this->connect ) {
      $this->errors[] = array($this->error(), $this->errno());
    } else {
      $this->selectdb();
    }
  }
  
  public function Dbcharset()
  {
    switch (_CHARSET) {
      case 'UTF-8':
        if ( function_exists('mysql_set_charset') ) {
          if (mysql_set_charset('utf8')) {
            return;
          }
        }
        $this->query('/*!40101 SET NAMES utf8 */');
        $this->query('/*!40101 SET SESSION collation_connection=utf8_general_ci */');
        break;
      case 'EUC-JP':
        if ( function_exists('mysql_set_charset') ) {
          if (mysql_set_charset('eucjpms')) {
            return;
          }
          if (mysql_set_charset('ujis')) {
            return;
          }
        }
        $this->query('/*!40101 SET NAMES ujis */');
        $this->query('/*!40101 SET SESSION collation_connection=ujis_japanese_ci */');
        $this->query('/*!50003 SET NAMES eucjpms */');
        $this->query('/*!50003 SET SESSION collation_connection=eucjpms_japanese_ci */');
        break;
    }
  }
  
  private function selectdb()
  {
    if ( !mysql_select_db(XOOPS_DB_NAME) ) {
      $this->errors[] = array($this->error(), $this->errno());
    }
  }
  
  public function select_query($sql)
  {
    if (strtolower(substr($sql, 0, 6)) == 'select') {
      return $this->query($sql);
    } else {
      $this->errors[] = array('This query is not SELECT', 0);
      return false;
    }
  }
  
  public function insert_query($sql)
  {
    if (strtolower(substr($sql, 0, 6)) == 'insert') {
      return $this->query($sql);
    } else {
      $this->errors[] = array('This query is not INSERT', 0);
      return false;
    }
  }
  
  public function update_query($sql)
  {
    if (strtolower(substr($sql, 0, 6)) == 'update') {
      return $this->query($sql);
    } else {
      $this->errors[] = array('This query is not UPDATE', 0);
      return false;
    }
  }
  
  public function delete_query($sql)
  {
    if (strtolower(substr($sql, 0, 6)) == 'delete') {
      return $this->query($sql);
    } else {
      $this->errors[] = array('This query is not DELETE', 0);
      return false;
    }
  }
  
  private function query($sql)
  {
    $this->result = mysql_query($sql, $this->connect);
    if ( $this->result ) {
      return $this->result;
    } else {
      $this->errors[] = array($this->error(), $this->errno());
      return false;
    }
  }
  
  public function queryF($sql)
  {
    return $this->query($sql);
  }
  
  public function fetchRow($result = "")
  {
    return @mysql_fetch_row($this->getResult($result));
  }
  
  public function fetchArray($result = "")
  {
    return @mysql_fetch_assoc($this->getResult($result));
  }
  
  public function fetchBoth($result)
  {
    return @mysql_fetch_array($this->getResult($result), MYSQL_BOTH);
  }
  
  public function getInsertId()
  {
    return mysql_insert_id($this->connect);
  }
  
  public function getRowsNum($result = "")
  {
    return @mysql_num_rows($this->getResult($result));
  }
  
  public function getAffectedRows()
  {
    return mysql_affected_rows($this->connect);
  }
  
  public function close()
  {
    mysql_close($this->connect);
  }
  
  public function freeRecordSet($result = "")
  {
    return mysql_free_result($this->getResult($result));
  }
  
  public function getFieldName($offset, $result = "")
  {
    return mysql_field_name($this->getResult($result), $offset);
  }
  
  public function getFieldType($offset, $result = "")
  {
    return mysql_field_type($this->getResult($result), $offset);
  }

  public function getFieldsNum($result = "")
  {
    return mysql_num_fields($this->getResult($result));
  }
  
  public function getFieldsLen($offset, $result = "")
  {
    return mysql_field_len($this->getResult($result), $offset);
  }
  
  public function getFieldsFlag($offset, $result = "")
  {
    return mysql_field_flags($this->getResult($result), $offset);
  }
  
  public function getResult($result)
  {
    if ( $result == "" ) {
      return $this->result;
    } else {
      return $result;
    }
  }
  
  public function prefix($tablename)
  {
    return XOOPS_DB_PREFIX.'_'.$tablename;
  }
  
  public function escape_string($sql)
  {
    return mysql_real_escape_string($sql);
  }
  
  public function quoteString($sql)
  {
    return "'".$this->escape_string($sql)."'";
  }
  
  public function error()
  {
    return @mysql_error();
  }
  
  public function errno()
  {
    return @mysql_errno();
  }
}
?>
