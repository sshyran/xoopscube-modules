<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class mcllibs_Search extends Legacy_BlockProcedure
{
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
    return _MI_LEGACY_BLOCK_SEARCH_NAME;
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('legacy_block_search.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
}
?>
