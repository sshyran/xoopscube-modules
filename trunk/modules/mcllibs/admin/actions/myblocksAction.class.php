<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class myblocksAction extends AbstractMCLAdminClass
{
  private $mid = 0;
  private $db;
  private $modlist = array();
  private $_mToken;
  
  public function __construct()
  {
    parent::__construct();
    $this->db = $this->root->mController->mDB;
    $this->mid = intval($this->root->mContext->mRequest->getRequest('mid'));
    $this->modlist = $this->getModlist();
  }
  
  private function getModlist()
  {
    $list[-1] = _AD_MCLLIBS_TOPPAGE;
    $list[0] = _AD_MCLLIBS_ALLPAGE;
    $sql = "SELECT `mid`, `name` FROM `".$this->db->prefix('modules')."` ";
    $sql.= "WHERE `hasmain` = 1 AND `isactive` = 1 ";
    $sql.= "ORDER BY `weight`, `mid`";
    $result = $this->db->query($sql);
    while ( list($mid, $name) = $this->db->fetchRow($result) ) {
      $list[$mid] = $name;
    }
    return $list;
  }
  
  private function getBlockList()
  {
    $list = false;
    $sql = "SELECT `bid`, `name`, `title`, `side`, `weight`, `visible`, `bcachetime`, `last_modified` ";
    $sql.= "FROM `".$this->db->prefix('newblocks')."` ";
    $sql.= "WHERE `mid` = ".$this->mid." ";
    $sql.= "ORDER BY `visible` DESC, `side`, `weight`";
    $result = $this->db->query($sql);
    while ( $row = $this->db->fetchArray($result) ) {
      $list[$row['bid']]['bl'] = $row;
      $list[$row['bid']]['mod'] = $this->selectModule($row['bid']);
    }
    return $list;
  }
  
  private function selectModule($bid)
  {
    $modlist = array();
    $sql = "SELECT `module_id` FROM ".$this->db->prefix('block_module_link')." WHERE `block_id` = ".$bid;
    $result = $this->db->query( $sql ) ;
    $selected_mids = array();
    while (list($selected_mid) = $this->db->fetchRow($result)) {
      $selected_mids[] = intval($selected_mid);
    }
    
    foreach ($this->modlist as $mid => $mname) {
      if (in_array($mid, $selected_mids)) {
        $modlist[$mid]['name'] = $mname;
        $modlist[$mid]['sel'] = ' selected="selected"';
      } else {
        $modlist[$mid]['name'] = $mname;
        $modlist[$mid]['sel'] = "";
      }
    }
    return $modlist;
  }
  
  private function _chktoken()
  {
    if ( !isset($_POST['token']) ) {
      return false;
    }
    if ( !isset($_SESSION['XCUBE_TOKEN']['MCL_BLOCKS']) ) {
      return false;
    }
    
    $token = $_SESSION['XCUBE_TOKEN']['MCL_BLOCKS'];
    $_SESSION['XCUBE_TOKEN']['MCL_BLOCKS'] = "";
    unset($_SESSION['XCUBE_TOKEN']['MCL_BLOCKS']);
    if ( $token != $_POST['token'] ) {
      return false;
    }
    return true;
  }
  
  private function _errchk()
  {
    if ( isset($_POST['bid']) && is_array($_POST['bid']) ) {
      return true;
    } else {
      return false;
    }
  }
  
  private function _chkpost($name, $bid)
  {
    if ( isset($_POST[$name][$bid]) && isset($_POST['old_'.$name][$bid]) ) {
      if ( $_POST[$name][$bid] != $_POST['old_'.$name][$bid] ) {
        return true;
      }
    }
    return false;
  }
  
  private function _update($bid)
  {
    $update = false;
    $handler = xoops_getmodulehandler('newblocks', 'legacy');
    $block = $handler->get($bid);
    if ( !isset($_POST['visible'][$bid]) ) {
      $_POST['visible'][$bid] = 0;
    }
    if ( $this->_chkpost('visible', $bid) ) {
      $block->set('visible', $_POST['visible'][$bid]);
      $update = true;
    }
    if ( $this->_chkpost('title', $bid) ) {
      $block->set('title', $_POST['title'][$bid]);
      $update = true;
    }
    if ( $this->_chkpost('side', $bid) ) {
      $block->set('side', $_POST['side'][$bid]);
      $update = true;
    }
    if ( $this->_chkpost('weight', $bid) ) {
      $block->set('weight', $_POST['weight'][$bid]);
      $update = true;
    }
    if ( $update ) {
      $block->set('last_modified', time());
      return $handler->insert($block);
    }
    return null;
  }
  
  private function updates()
  {
    $msg = false;
    foreach ( $_POST['bid'] as $bid) {
      $bid = intval($bid);
      $ret = $this->_update($bid);
      if ( $ret === false ) {
        $msg[] = 'bid:'.$bid.' update error';
      } elseif ( $ret === true ) {
        $msg[] = 'bid:'.$bid.' update success';
      }
      if ( $this->uplink($bid) ) {
        $msg[] = 'bid:'.$bid.' update success';
      }
    }
    if ( is_array($msg) ) {
      $this->setErr(implode('<br />', $msg));
      return true;
    }
    return false;
  }
  
  private function uplink($bid)
  {
    $modlist = array();
    $sql = "SELECT `module_id` FROM `".$this->db->prefix('block_module_link')."` WHERE `block_id` = ".$bid;
    $result = $this->db->query($sql);
    $selected_mids = array();
    while (list($selected_mid) = $this->db->fetchRow($result)) {
      $selected_mids[] = intval($selected_mid);
    }
    $bmodule = array();
    if ( isset($_POST['bmodule'][$bid]) && is_array($_POST['bmodule'][$bid]) ) {
      $bmodule = $_POST['bmodule'][$bid];
    }
    
    if ( count(array_diff_assoc($selected_mids, $bmodule)) > 0 ) {
      $sql = "DELETE FROM `".$this->db->prefix('block_module_link')."` WHERE `block_id` = ".$bid;
      $this->db->query($sql);
      foreach ( $bmodule as $bmid ) {
        $sql = "INSERT INTO `".$this->db->prefix('block_module_link')."` ";
        $sql.= "(`block_id`, `module_id`) ";
        $sql.= "VALUES (".$bid.", ".intval($bmid).")";
        $this->db->query($sql);
      }
      return true;
    }
    return false;
  }
  
  public function execute()
  {
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
      if ( !$this->_chktoken() ) {
        $this->setErr(_TOKEN_ERROR);
        return;
      }
      if ( !$this->_errchk() ) {
        $this->setErr(_AD_MCLLIBS_MYBLOCKS_ERR1);
        return;
      }
      if ( $this->updates() ) {
        return;
      }
    }
    
    $this->_mToken = sha1(uniqid(mt_rand(), true));
    $_SESSION['XCUBE_TOKEN']['MCL_BLOCKS'] = $this->_mToken;
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_myblocks.html');
    $render->setAttribute('blocklist', $this->getBlockList());
    $render->setAttribute('token', $this->_mToken);
  }
}
?>
