<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_BlockLogin extends Legacy_BlockProcedure
{
  private $root = null;
  private $dirname = null;

  public function __construct($block)
  {
    parent::Legacy_BlockProcedure($block);
    $this->root = XCube_Root::getSingleton();
    $this->dirname = basename(dirname(dirname(__FILE__)));
  }
  
  public function prepare()
  {
    $this->_loadlang();
    return true;
  }
  
  private function _loadlang()
  {
    $this->root->mLanguageManager->loadModinfoMessageCatalog($this->dirname);
    $this->root->mLanguageManager->loadModinfoMessageCatalog('user');
    $this->root->mLanguageManager->loadBlockMessageCatalog('legacy');
    $this->root->mLanguageManager->loadBlockMessageCatalog('user');
  }
  
  public function isDisplay()
  {
    $root = XCube_Root::getSingleton();
    return !$root->mContext->mUser->isInRole('Site.RegisteredUser');
  }
  
  public function getTitle()
  {
    return _MI_USER_BLOCK_LOGIN_NAME;
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('mcllibs_block_login.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    $render->setAttribute('block', $this->make_usermenu());
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
  
  private function make_usermenu()
  {
    $user = $this->root->mContext->mUser;
    if ($user->isInRole('Site.GuestUser')) {
      $block = array();
      $config_handler = xoops_gethandler('config');
      $moduleConfig = $config_handler->getConfigsByDirname('user');
      if (isset($_COOKIE[$moduleConfig['usercookie']])) {
        $block['unamevalue'] = $_COOKIE[$moduleConfig['usercookie']];
      } else {
        $block['unamevalue'] = '';
      }
      $block['allow_register'] = $moduleConfig['allow_register'];
      $block['use_ssl'] = 0;
      $block['sslloginlink'] = '';
      
      $configHandler = xoops_gethandler('config');
      $configs = $configHandler->getConfigsByDirname($this->dirname);
      switch ($configs['allowloginid']) {
        case 1:
          $block['uname_cap'] = _MI_MCLLIBS_LOGIN_EMAIL;
          break;
        case 2:
          $block['uname_cap'] = _MI_MCLLIBS_LOGIN_UNAME;
          break;
        case 0:
        default:
          $block['uname_cap'] = _MI_MCLLIBS_LOGIN_ALL;
      }
      $block['autologin'] = $configs['autologin'];
      return $block;
    }
    return false;
  }
}
?>
