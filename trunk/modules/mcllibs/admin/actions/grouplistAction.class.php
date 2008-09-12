<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class grouplistAction extends AbstractMCLAdminClass
{
  public function __construct()
  {
    parent::__construct();
  }
  
  private function getGroupList($gid=0)
  {
    $db = $this->root->mController->mDB;
    $groups = array();
    $sql = "SELECT groupid,name FROM ".$db->prefix('groups');
    if ( $gid != 0 ) {
      $sql.= " WHERE groupid = ".$gid;
    }
    $sql.= " ORDER BY groupid";
    $result = $db->query($sql);
    while ( list($id,$name) = $db->fetchRow($result) ) {
      $groups[$id]['name'] = $name;
      if (XOOPS_GROUP_ADMIN == $id || XOOPS_GROUP_USERS == $id || XOOPS_GROUP_ANONYMOUS == $id) {
        $groups[$id]['link'] = 0;
      } else {
        $groups[$id]['link'] = 1;
      }
    }
    return $groups;
  }
  
  public function execute()
  {
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_group_menu.html');
    $render->setAttribute('glist',$this->getGroupList());
  }
}
?>