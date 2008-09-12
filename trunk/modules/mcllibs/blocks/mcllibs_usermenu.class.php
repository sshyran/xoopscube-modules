<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_Usermenu extends Legacy_BlockProcedure
{
  private $root = null;

  public function __construct($block)
  {
    parent::Legacy_BlockProcedure($block);
    $this->root = XCube_Root::getSingleton();
  }
  
  public function prepare()
  {
    $this->_loadlang();
    return true;
  }
  
  private function _loadlang()
  {
    $this->root->mLanguageManager->loadModinfoMessageCatalog(basename(dirname(dirname(__FILE__))));
    $this->root->mLanguageManager->loadModinfoMessageCatalog('legacy');
    $this->root->mLanguageManager->loadBlockMessageCatalog('legacy');
  }
  
  public function getTitle()
  {
    return _MI_LEGACY_BLOCK_USERMENU_NAME;
  }
  
  public function isDisplay()
  {
    return $this->root->mContext->mUser->isInRole('Site.RegisteredUser');
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('legacy_block_usermenu.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    $render->setAttribute('block', $this->make_usermenu());
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
  
  private function make_usermenu()
  {
    $user = $this->root->mContext->mUser;
    $xoopsUser = $this->root->mController->mRoot->mContext->mXoopsUser;
    if ($user->isInRole('Site.RegisteredUser')) {
      $block = array();
      $block['uid'] = $xoopsUser->get('uid');
      $block['flagShowInbox'] = false;

      $url = null;
      $service = $this->root->mServiceManager->getService('privateMessage');
      if ($service != null) {
        $client = $this->root->mServiceManager->createClient($service);
        $url = $client->call('getPmInboxUrl', array('uid' => $xoopsUser->get('uid')));
        if ($url != null) {
          $block['inbox_url'] = $url;
          $block['new_messages'] = $client->call('getCountUnreadPM', array('uid' => $xoopsUser->get('uid')));
          $block['flagShowInbox']=true;
        }
      }
      $block['show_adminlink'] = $this->root->mContext->mUser->isInRole('Site.Administrator');
      return $block;
    }
    return false;
  }
}
?>
