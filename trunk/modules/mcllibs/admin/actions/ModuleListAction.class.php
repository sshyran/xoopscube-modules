<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class ModuleListAction extends AbstractMCLAdminClass
{
  private $mods;
  public function __construct()
  {
    parent::__construct();
  }
  
  private function getModList()
  {
    $db = $this->root->mController->mDB;
    $sql = "SELECT `mid`, `weight`, `version`, `last_update`, `dirname` ";
    $sql.= "FROM `".$db->prefix('modules')."` ";
    $sql.= "WHERE `isactive` = 1 ";
    $sql.= "ORDER BY `weight`, `hasmain`";
    $result = $db->query($sql);
    while ( $row = $db->fetchArray($result) ) {
      $info = $this->loadInfo($row['dirname']);
      if ( $info ) {
        $row['fversion'] = sprintf('%01.2f', $info['version']);
        $row['name'] = $info['name'];
        $row['image'] = $info['image'];
        
        $row['version'] = sprintf('%01.2f', $row['version'] / 100);
        $this->mods[] = $row;
      }
    }
  }
  
  private function loadInfo($dirname)
  {
    $xoopsConfig = $this->root->mContext->mXoopsConfig;
    $this->root->mLanguageManager->loadModinfoMessageCatalog($dirname);
    
    if (file_exists(XOOPS_MODULE_PATH.'/'.$dirname.'/xoops_version.php')) {
      require XOOPS_MODULE_PATH.'/'.$dirname.'/xoops_version.php';
    } else {
      return false;
    }
    $modversion['version'] = isset($modversion['version']) ? floatval($modversion['version']) : 0;
    return $modversion;
  }
  
  
  public function execute()
  {
    $this->getModList();
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_modulelist.html');
    $render->setAttribute('modlist', $this->mods);
  }
}
