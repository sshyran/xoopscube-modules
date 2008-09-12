<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class MCL_AdminSideMenu extends Legacy_AdminSideMenu
{
  public function execute()
  {
    $root = XCube_Root::getSingleton();
    $root->mLanguageManager->loadModuleAdminMessageCatalog('legacy'); 
    $root->mLanguageManager->loadModuleAdminMessageCatalog(_MCLLIBS_PATH);
    $controller = $root->mController;
    $user = $root->mController->mRoot->mContext->mXoopsUser;
    $render = $this->getRenderTarget();
    $render->setAttribute('legacy_module', 'legacy');
    $this->mCurrentModule = $controller->mRoot->mContext->mXoopsModule;
    
    if ($this->mCurrentModule->get('dirname') == 'legacy') {
      if (xoops_getrequest('action') == 'help') {
        $moduleHandler = xoops_gethandler('module');
        $t_module = $moduleHandler->getByDirname(xoops_gethandler('dirname'));
        if (is_object($t_module)) {
          $this->mCurrentModule = $t_module;
        }
      }
    }
    
    $db = $controller->getDB();

    $mod = $db->prefix('modules');
    $perm = $db->prefix('group_permission');
    $groups = implode(',', $user->getGroups());
    
    if ($root->mContext->mUser->isInRole('Site.Owner')) {
      $sql = "SELECT DISTINCT `mid` FROM `".$mod."` WHERE `isactive` = 1 AND `hasadmin` = 1 ORDER BY `weight`, `mid`";
    } else {
      $sql = "SELECT DISTINCT m.`mid` FROM `".$mod."` m, `".$perm."` g ";
      $sql.= "WHERE m.`isactive` = 1 AND m.`mid` = g.`gperm_itemid` ";
      $sql.= "AND g.`gperm_name` = 'module_admin' AND g.`gperm_groupid` IN (".$groups.") AND m.`hasadmin` = 1 ";
      $sql.= "ORDER BY m.`weight`, m.`mid`";
    }

    $result = $db->query($sql);
    $handler = xoops_gethandler('module');
    
    while($row = $db->fetchArray($result)) {
      $xoopsModule = $handler->get($row['mid']);
      $this->mModules[] = Legacy_Utils::createModule($xoopsModule);
    }
    $render->setTemplateName('../../../../'._MCLLIBS_PATH.'/admin/templates/blocks/mcl_admin_block_sidemenu.html');
    $render->setAttribute('modules', $this->mModules);
    $render->setAttribute('currentModule', $this->mCurrentModule);
    
    $renderSystem = $root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
}
?>
