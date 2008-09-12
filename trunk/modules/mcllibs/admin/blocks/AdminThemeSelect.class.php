<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class AdminThemeSelect extends Legacy_AbstractBlockProcedure
{
  public function getName()
  {
    return 'themeselect';
  }

  public function getTitle()
  {
    return 'AdminThemeSelect';
  }

  public function getEntryIndex()
  {
    return 0;
  }

  public function isEnableCache()
  {
    return false;
  }

  public function execute()
  {
    $root = XCube_Root::getSingleton();
    $root->mLanguageManager->loadModuleAdminMessageCatalog(_MCLLIBS_PATH);
    $root->mLanguageManager->loadBlockMessageCatalog('legacy');
    
    $render = $this->getRenderTarget();
    $render->setTemplateName('../../../../'._MCLLIBS_PATH.'/admin/templates/blocks/admin_block_themes.html');
    
    $moduleHandler = xoops_gethandler('module');
    $admintheme = $moduleHandler->getByDirname(_MCLLIBS_PATH);
    $configHandler = xoops_gethandler('config');
    $configs = $configHandler->getConfigsByCat(0, $admintheme->get('mid'));
    
    $admintheme_options = array();
    $i = 1;
    $admintheme_options[0]['name'] = 'default';
    if ( 'default' == $configs['admintheme'] ) {
      $admintheme_options[0]['selected'] = 'selected="selected"';
    } else {
      $admintheme_options[0]['selected'] = '';
    }
    foreach ( getAdminTheme() as $theme ) {
      $admintheme_options[$i]['name'] = $theme;
      if ( $theme == $configs['admintheme'] ) {
        $admintheme_options[$i]['selected'] = 'selected="selected"';
      } else {
        $admintheme_options[$i]['selected'] = '';
      }
      $i++;
    }
    $admintheme_count = $i;
    
    $render->setAttribute('admintheme_options', $admintheme_options);
    $render->setAttribute('admintheme_count', $admintheme_count);
    $render->setAttribute('blockid', $this->getName());
    $render->setAttribute('ret_url', $_SERVER['REQUEST_URI']);
    $renderSystem = $root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
}
?>
