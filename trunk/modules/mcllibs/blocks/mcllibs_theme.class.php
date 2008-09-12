<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_Theme extends Legacy_BlockProcedure
{
  private $options = array();
  private $root = null;
  
  public function __construct($block)
  {
    parent::Legacy_BlockProcedure($block);
    $this->options = explode('|', $this->_mBlock->get('options'));
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
    return _MI_LEGACY_BLOCK_THEMES_NAME;
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('legacy_block_themes.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    $render->setAttribute('block', $this->themes_show());
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
  
  private function themes_show()
  {
    if (count($this->root->mContext->mXoopsConfig['theme_set_allowed']) == 0) {
      return null;
    }
    $block = array();
    if (xoops_getenv('REQUEST_METHOD') == 'POST') {
      $block['isEnableChanger'] = 0;
      return $block;
    }
    $block['isEnableChanger'] = 1;
    $theme_options = array();
    $handler = xoops_getmodulehandler('theme', 'legacy');
    foreach ($this->root->mContext->mXoopsConfig['theme_set_allowed'] as $name) {
      $theme = $handler->get($name);
      if ($theme != null) {
        $theme_option['name'] = $name;
        $theme_option['screenshot'] = $theme->getShow('screenshot');
        $theme_option['screenshotUrl'] = XOOPS_THEME_URL . "/" . $name . "/" . $theme->getShow('screenshot');
        if ($name == $this->root->mContext->mXoopsConfig['theme_set']) {
          $theme_option['selected'] = 'selected="selected"';
          $block['theme_selected_screenshot'] = $theme->getShow('screenshot');
        } else {
          $theme_option['selected'] = '';
        }
        $theme_options[] = $theme_option;
      }
    }
    $block['count'] = count($this->root->mContext->mXoopsConfig['theme_set_allowed']);
    $block['mode'] = $this->options[0];
    $block['width'] = $this->options[1];
    $block['theme_options'] = $theme_options;
    return $block;
  }
  
  public function getOptionForm()
  {
    $this->_loadlang();
    $chk = "";
    $form = _MB_LEGACY_LANG_THSHOW."&nbsp;";
    if ( $this->options[0] == 1 ) {
      $chk = ' checked="checked"';
    }
    $form .= '<input type="radio" name="options[0]" value="1"'.$chk.' />&nbsp;'._YES;
    $chk = "";
    if ( $this->options[0] == 0 ) {
      $chk = ' checked="checked"';
    }
    $form .= '&nbsp;<input type="radio" name="options[0]" value="0"'.$chk.' />'._NO;
    $form .= '<br />'._MB_LEGACY_LANG_THWIDTH.'&nbsp;';
    $form .= '<input type="text" name="options[1]" value="'.$this->options[1].'" />';
    return $form;
  }
}
?>
