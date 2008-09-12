<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class groupAction extends AbstractMCLAdminClass
{
  private $db;
  private $cmd;
  public $mForm;
  
  public function __construct()
  {
    parent::__construct();
    $this->db = $this->root->mController->mDB;
    $this->cmd = $this->root->mContext->mRequest->getRequest('cmd');
  }
  
  private function getGroupName($gid)
  {
    $groups = array();
    $sql = "SELECT name FROM ".$this->db->prefix('groups');
    $sql.= " WHERE groupid = ".$gid;
    $sql.= " ORDER BY groupid";
    $result = $this->db->query($sql);
    list($name) = $this->db->fetchRow($result);
    return $name;
  }
  
  private function getPermList($gid)
  {
    $list = false;
    $sql = "SELECT mid,name FROM ".$this->db->prefix('modules')." ORDER BY mid";
    $result = $this->db->query($sql);
    while ( list($mid,$name) = $this->db->fetchRow($result) ) {
      $list[$mid]['mod']['name'] = $name;
      $list[$mid]['mod']['perm'] = $this->getModPerm($mid,$gid);
      $list[$mid]['block'] = $this->getBlockPerm($mid,$gid);
    }
    return $list;
  }
  
  private function getModPerm($mid, $gid)
  {
    $list['module_admin'] = $list['module_read'] = 0;
    $sql = "SELECT gp.gperm_name";
    $sql.= " FROM ".$this->db->prefix('group_permission')." gp";
    $sql.= " WHERE gp.gperm_itemid = ".$mid;
    $sql.= " AND gp.gperm_name IN('module_admin','module_read')";
    $sql.= " AND gp.gperm_groupid = ".$gid;
    $sql.= " ORDER BY gp.gperm_name";
    $result = $this->db->query($sql);
    while ( list($gperm_name) = $this->db->fetchRow($result) ) {
      $list[$gperm_name] = 1;
    }
    return $list;
  }
  
  private function getBlockPerm($mid, $gid)
  {
    $list = false;
    $sql = "SELECT b.bid,b.title,b.side,gp.gperm_name";
    $sql.= " FROM ".$this->db->prefix('newblocks')." b";
    $sql.= " LEFT JOIN ".$this->db->prefix('group_permission')." gp ON b.bid = gp.gperm_itemid";
    $sql.= " AND gp.gperm_name = 'block_read'";
    $sql.= " AND gp.gperm_groupid = ".$gid;
    $sql.= " WHERE b.mid = ".$mid;
    $sql.= " ORDER BY b.bid,b.side";
    $result = $this->db->query($sql);
    while ( list($bid,$bname,$bside,$pname) = $this->db->fetchRow($result) ) {
      $list[$bid]['name'] = $bname;
      $list[$bid]['side'] = $bside;
      if ( $pname == "" ) {
        $list[$bid]['perm'] = 0;
      } else {
        $list[$bid]['perm'] = 1;
      }
    }
    return $list;
  }
  
  private function update()
  {
    $gid = $this->mForm->get('gid');
    
    $mmsg = $this->putModulesPerm($gid, $this->mForm->get('mid'), $this->mForm->get('modadm'), $this->mForm->get('modacc'), $this->mForm->get('oldmodadm'), $this->mForm->get('oldmodacc'));
    $bmsg = $this->putBlocksPerm($gid, $this->mForm->get('bid'), $this->mForm->get('blkacc'), $this->mForm->get('oldblkacc'));
  }
  
  private function putModulesPerm($gid, $mids, $madms, $maccs, $oldmadms, $oldmaccs)
  {
    $msg = false;
    foreach ( $mids as $mid ) {
      if ( isset($madms[$mid]) && $madms[$mid] != $oldmadms[$mid] ) {
        if ( !$this->insert_perm($gid, intval($mid), 'module_admin') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG1, $mid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG2, $mid);
        }
      } elseif ( !isset($madms[$mid]) && $oldmadms[$mid] == 1 ) {
        if ( !$this->delete_perm($gid,intval($mid),'module_admin') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG3, $mid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG4, $mid);
        }
      }
      
      if ( isset($maccs[$mid]) && $maccs[$mid] != $oldmaccs[$mid] ) {
        if ( !$this->insert_perm($gid,intval($mid),'module_read') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG5, $mid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG6, $mid);
        }
      } elseif ( !isset($maccs[$mid]) && $oldmaccs[$mid] == 1 ) {
        if ( !$this->delete_perm($gid,intval($mid),'module_read') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG7, $mid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_MODMSG8, $mid);
        }
      }
    }
    return $msg;
  }
  
  private function putBlocksPerm($gid, $bids, $baccs, $oldbaccs)
  {
    $msg = false;
    foreach ( $bids as $bid => $mid ) {
      if ( isset($baccs[$bid]) && $baccs[$bid] != $oldbaccs[$bid] ) {
        if ( !$this->insert_perm($gid, intval($bid), 'block_read') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_BLKMSG1, $bid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_BLKMSG2, $bid);
        }
      } elseif ( !isset($baccs[$bid]) && $oldbaccs[$bid] == 1 ) {
        if ( !$this->delete_perm($gid, intval($bid), 'block_read') ) {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_BLKMSG3, $bid);
        } else {
          $msg[] = XCube_Utils::formatString(_AD_MCLLIBS_BLKMSG4, $bid);
        }
      }
    }
    return $msg;
  }
  
  
  private function insert_perm($gid, $key, $type)
  {
    $sql = "INSERT INTO ".$this->db->prefix('group_permission');
    $sql.= " (gperm_groupid,gperm_itemid,gperm_modid,gperm_name)";
    $sql.= " VALUES(".$gid.",".$key.",1,'".$type."')";
    return $this->db->query($sql);
  }
  
  private function delete_perm($gid, $key, $type)
  {
    $sql = "DELETE FROM ".$this->db->prefix('group_permission');
    $sql.= " WHERE gperm_name = '".$type."'";
    $sql.= " AND gperm_itemid = ".$key;
    $sql.= " AND gperm_groupid = ".$gid;
    return $this->db->query($sql);
  }
  
  public function execute()
  {
    if ( $this->cmd == '' ) {
      $this->setErr('Command not found.');
      return;
    }
    
    require_once _MY_MODULE_PATH.'/admin/forms/permForm.class.php';
    $this->mForm = new GroupPermForm();
    $this->mForm->prepare();
    if ( $this->cmd == 'update' ) {
      $this->mForm->fetch();
      $this->mForm->validate();
      if ( !$this->mForm->hasError() ) {
        $this->update();
      } else {
        //dbg_print_r($this->mForm->getErrorMessages());exit;
      }
    }
  }
  
  public function executeView(&$render)
  {
    $gid = $this->root->mContext->mRequest->getRequest('gid');
    if ( $gid < 1 ) {
      $this->setErr('Group not selected.');
      return;
    }
    $this->mForm->set('gid', $gid);
    $render->setAttribute('plist',$this->getPermList($gid));
    $render->setAttribute('group',$this->getGroupName($gid));
    $render->setAttribute('mActionform',$this->mForm);
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_group_perm.html');
  }
}
?>
