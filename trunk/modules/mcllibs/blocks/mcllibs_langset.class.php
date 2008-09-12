<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_Langset extends Legacy_BlockProcedure
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
  }
  
  public function getTitle()
  {
    return _MI_MCLLIBS_BLOCK_LANGSET_NAME;
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('mcllibs_block_lang.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    $render->setAttribute('block', $this->list_lang());
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
  
  public function list_lang()
  {
    $block = false;
    if ( class_exists('LangSelect') ) {
      foreach ( array_keys(LangSelect::get_LangArray()) as $lang ) {
        if ( strlen($lang) == 2 ) {
          $block[] = $lang;
        }
      }
    }
    return $block;
  }
}
?>
