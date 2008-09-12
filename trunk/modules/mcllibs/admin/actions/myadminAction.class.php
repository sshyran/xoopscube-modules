<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class myadminAction extends AbstractMCLAdminClass
{
  private $mid = 0;
  private $db;
  private $_mToken;
  
  public function __construct()
  {
    parent::__construct();
    $this->db = $this->root->mController->mDB;
    $this->mid = intval($this->root->mContext->mRequest->getRequest('mid'));
  }
  
  private function getModPerm()
  {
    $list = false;
    $sql = "SELECT gp.`gperm_groupid`, gp.`gperm_name`";
    $sql.= " FROM `".$this->db->prefix('group_permission')."` gp";
    $sql.= " WHERE gp.`gperm_itemid` = ".$this->mid;
    $sql.= " AND gp.`gperm_name` IN('module_admin','module_read')";
    $sql.= " ORDER BY gp.`gperm_groupid`, gp.`gperm_name`";
    $result = $this->db->query($sql);
    while ( list($gid, $gperm_name) = $this->db->fetchRow($result) ) {
      $list[$gid][$gperm_name] = true;
    }
    return $list;
  }

  public function getBlockPerm()
  {
    $bperm = false;
    $sql = "SELECT b.bid,gp.gperm_groupid";
    $sql.= " FROM ".$this->db->prefix('newblocks')." b,";
    $sql.= " ".$this->db->prefix('group_permission')." gp ";
    $sql.= " WHERE b.mid = ".$this->mid;
    $sql.= " AND b.bid = gp.gperm_itemid";
    $sql.= " AND gp.gperm_name = 'block_read'";
    $sql.= " ORDER BY b.bid";
    $result = $this->db->query($sql);
    while ( list($bid, $gid) = $this->db->fetchRow($result) ) {
      $bperm[$gid][$bid] = true;
    }
    return $bperm;
  }
  
  private function getBlockList()
  {
    $block = array();
    $sql = "SELECT `bid`, `title` FROM `".$this->db->prefix('newblocks')."` ";
    $sql.= "WHERE `mid` = ".$this->mid;
    $sql.= " ORDER BY `bid`";
    $result = $this->db->query($sql);
    while ( list($bid, $bname) = $this->db->fetchRow($result) ) {
      $block[$bid] = $bname;
    }
    return $block;
  }
  
  private function getGroupList($gid=0)
  {
    $groups = array();
    $sql = "SELECT groupid,name FROM ".$this->db->prefix('groups');
    if ( $gid != 0 ) {
      $sql.= " WHERE groupid = ".$gid;
    }
    $sql.= " ORDER BY groupid";
    $result = $this->db->query($sql);
    while ( list($gid, $gname) = $this->db->fetchRow($result) ) {
      $groups[$gid] = $gname;
    }
    return $groups;
  }
  
  private function getPerm()
  {
    $ret = false;
    $mperm = $this->getModPerm();
    $bperm = $this->getBlockPerm();
    $blocks = $this->getBlockList();
    
    foreach ($this->getGroupList() as $gid => $gname) {
      $ret[$gid]['gname'] = $gname;
      foreach (array_keys($blocks) as $bid) {
        if ( isset($bperm[$gid][$bid]) ) {
          $ret[$gid]['blk'][$bid]['perm'] = true;
        } else {
          $ret[$gid]['blk'][$bid]['perm'] = false;
        }
        $ret[$gid]['blk'][$bid]['name'] = $blocks[$bid];
      }
      if ( isset($mperm[$gid]['module_admin']) ) {
        $ret[$gid]['mod']['module_admin'] = true;
      } else {
        $ret[$gid]['mod']['module_admin'] = false;
      }
      if ( isset($mperm[$gid]['module_read']) ) {
        $ret[$gid]['mod']['module_read'] = true;
      } else {
        $ret[$gid]['mod']['module_read'] = false;
      }
    }
    return $ret;
  }
  
  private function deletePerm()
  {
    $sql = "DELETE FROM `".$this->db->prefix('group_permission')."` ";
    $sql.= "WHERE `gperm_itemid` = ".$this->mid;
    return $this->db->query($sql);
  }
  
  private function _addPerm($gid, $item, $perm)
  {
    $sql = "INSERT INTO `".$this->db->prefix('group_permission')."` ";
    $sql.= "(`gperm_id`, `gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) ";
    $sql.= "VALUES (0, ".$gid.", ".$item.", 1, '".$perm."')";
    return $this->db->query($sql);
  }
  
  private function addPerms()
  {
    $err = false;
    foreach ($_POST as $key => $perms) {
      switch ($key) {
        case 'modadmin':
          foreach (array_keys($perms) as $gid) {
            if ( !$this->_addPerm(intval($gid), $this->mid, 'module_admin') ) {
              $err = true;
            }
          }
          break;
        case 'modread':
          foreach (array_keys($perms) as $gid) {
            if ( !$this->_addPerm(intval($gid), $this->mid, 'module_read') ) {
              $err = true;
            }
          }
          break;
        case 'blkread':
          foreach ($perms as $gid => $blocks) {
            foreach (array_keys($blocks) as $bid) {
              if ( !$this->_addPerm(intval($gid), intval($bid), 'block_read') ) {
                $err = true;
              }
            }
          }
          break;
      }
    }
    return $err;
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

  public function execute()
  {
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
      if ( !$this->_chktoken() ) {
        $this->setErr(_TOKEN_ERROR);
        return;
      }
      if ( !$this->deletePerm() ) {
        $this->setErr(_AD_MCLLIBS_PERMDELERR);
        return;
      }
      
      if ( !$this->addPerms() ) {
        $this->setErr(_AD_MCLLIBS_PERMSUCCESS);
      } else {
        $this->setErr(_AD_MCLLIBS_PERMERROR);
      }
      return;
    }
    $this->_mToken = sha1(uniqid(mt_rand(), true));
    $_SESSION['XCUBE_TOKEN']['MCL_BLOCKS'] = $this->_mToken;
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_myadmin.html');
    $render->setAttribute('perm', $this->getPerm());
    $render->setAttribute('token', $this->_mToken);
  }
}
?>
