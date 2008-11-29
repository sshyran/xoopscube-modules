<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
class MessageInboxObject extends XoopsSimpleObject
{
  public function __construct()
  {
    $this->initVar('inbox_id', XOBJ_DTYPE_INT, 0);
    $this->initVar('uid', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('from_uid', XOBJ_DTYPE_INT, 0, true);
    $this->initVar('title', XOBJ_DTYPE_STRING, '', true, 255);
    $this->initVar('message', XOBJ_DTYPE_TEXT, '', true);
    $this->initVar('utime', XOBJ_DTYPE_INT, time(), true);
    $this->initVar('is_read', XOBJ_DTYPE_INT, 0);
    $this->initVar('uname', XOBJ_DTYPE_STRING, '', true, 100);
  }
  
  public function setVar($key, $value)
  {
    $this->set($key, $value);
  }
  
  public function set($key, $value)
  {
    switch ($key) {
      case 'subject':     $key = 'title';    break;
      case 'from_userid': $key = 'from_uid'; break;
      case 'msg_text':    $key = 'message';  break;
      case 'to_userid':   $key = 'uid';      break;
    }
    
    $this->assignVar($key, $value);
  }
}

class MessageInboxHandler extends XoopsObjectGenericHandler
{
  public $mTable = 'message_inbox';
  public $mPrimary = 'inbox_id';
  public $mClass = 'MessageInboxObject';
  public $mSequence = 'message_inbox_inbox_id_seq';
  
  public function __construct(&$db)
  {
    parent::XoopsObjectGenericHandler($db);
  }
  
  public function getCountUnreadByFromUid($uid)
  {
    $criteria = new CriteriaCompo(new Criteria('is_read', 0));
    $criteria->add(new Criteria('uid', $uid));
    return $this->getCount($criteria);
  }
  
  public function getInboxCount($uid)
  {
    $criteria = new CriteriaCompo(new Criteria('uid', $uid));
    return $this->getCount($criteria);
  }
  
  public function getSendUserList($uid = 0, $fuid = 0)
  {
    if ( defined('XOOPS_DB_FILEDS_QUOTE') ) {
      $q = XOOPS_DB_FILEDS_QUOTE;
    } else {
      $q = '`';
    }
    $ret = array();
    $sql = "SELECT u.".$q."uname".$q.",u.".$q."uid".$q." FROM ".$q.$this->db->prefix('users').$q." u, ";
    $sql.= $q.$this->mTable.$q." i ";
    $sql.= "WHERE i.".$q."from_uid".$q." = u.".$q."uid".$q." ";
    $sql.= "AND i.".$q."uid".$q." = ".$uid." ";
    $sql.= "GROUP BY u.".$q."uname".$q.",u.".$q."uid".$q."";
    
    $result = $this->db->query($sql);
    while ($row = $this->db->fetchArray($result)) {
      if ( $fuid == $row['uid'] ) {
        $row['select'] = true;
      } else {
        $row['select'] = false;
      }
      $ret[] = $row;
    }
    return $ret;
  }
}
?>
