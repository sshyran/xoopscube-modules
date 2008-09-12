<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class Mcllibs_Mainmenu extends Legacy_BlockProcedure
{
  private $options = array();
  private $root = null;
  
  public function __construct($block)
  {
    parent::Legacy_BlockProcedure($block);
    $this->options = explode('|', $this->_mBlock->get('options'));
    if ( empty($this->options[0]) ) {
      $this->options[0] = '0';
    }
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
    return _MI_LEGACY_BLOCK_MAINMENU_NAME;
  }

  public function execute()
  {
    $render = $this->getRenderTarget();
    $render->setTemplateName('mcllibs_block_mainmenu.html');
    $render->setAttribute('mid', $this->_mBlock->get('mid'));
    $render->setAttribute('bid', $this->_mBlock->get('bid'));
    $render->setAttribute('block', $this->make_mainmenu());
    
    $renderSystem = $this->root->getRenderSystem($this->getRenderSystemName());
    $renderSystem->renderBlock($render);
  }
  
  private function make_mainmenu()
  {
    $xoopsModule = $this->root->mContext->mXoopsModule;
    $xoopsUser = $this->root->mController->mRoot->mContext->mXoopsUser;
    
    $block = $menu = array();
    $block['_display_'] = true;
    
    $mGetMenuItem = new XCube_Delegate();
    $mGetMenuItem->add(array(&$this, 'getMenuData'));
    $mGetMenuItem->register('MCLLIBS.MainMenu');
    $mGetMenuItem->call(new XCube_Ref($menu));
    
    ksort($menu);
    foreach ($menu as $m) {
      foreach ($m as $item) {
        $block['modules'][] = array(
          'name' => $item['name'],
          'link' => $item['link'],
          'sublinks' => $item['sublinks'],
          'target' => $item['target'],
        );
      }
    }
    
    return $block;
  }
  
  public function getMenuData(&$menu)
  {
    $xoopsUser = $this->root->mController->mRoot->mContext->mXoopsUser;
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
    $xoopsModule = $this->root->mContext->mXoopsModule;
    
    $db = $this->root->mController->mDB;
    $sql = "SELECT m.`mid`, m.`dirname`, m.`weight` ";
    $sql.= "FROM `".$db->prefix('modules')."` m, `".$db->prefix('group_permission')."` g ";
    $sql.= "WHERE m.`isactive` = 1 ";
    $sql.= "AND m.`hasmain` = 1 ";
    $sql.= "AND m.`weight` > 0 ";
    $sql.= "AND g.`gperm_name` = 'module_read' ";
    $sql.= "AND g.`gperm_groupid` IN (".implode(',', $groups).") ";
    $sql.= "AND g.`gperm_itemid` = m.`mid` ";
    $sql.= "GROUP BY m.`mid` ";
    $sql.= "ORDER BY m.`weight` ASC";
    $result = $db->query($sql);
    while (list($mid, $dirname, $weight) = $db->fetchRow($result)) {
      $modinfo = $this->loadInfo($dirname);
      $sublink = $this->getSubLink($this->root->mContext->mXoopsModule, $modinfo, $mid);
      if ( isset($modinfo['front']) ) {
        $link = XOOPS_URL.'/index.php?moddir='.$dirname;
      } else {
        $link = XOOPS_MODULE_URL.'/'.$dirname.'/';
      }
      
      $menu[$weight][] = array('name' => $modinfo['name'], 'link' => $link, 'sublinks' => $sublink, 'target' => '_self');
    }
  }
  
  private function getSubLink($mod, $info, $mid)
  {
    $sublink = array();
    if ( (isset($info['sub']) && count($info['sub']) > 0) && ((!empty($mod)) && ($mid == $mod->getVar('mid'))) || (isset($info['sub']) && $this->options[0] == 0)) {
      if ( isset($info['front']) ) {
        foreach ( $info['sub'] as $slink) {
          //$sublink[] = array ( 'link' => XOOPS_URL.'/index.php?moddir='.$mod->getVar('dirname').'&amp;'.$slink['url'], 'name' => $slink['name']);
          $sublink[] = array ( 'link' => XOOPS_URL.'/'.$slink['url'].'&amp;moddir='.$mod->getVar('dirname'), 'name' => $slink['name']);
        }
      } else {
        foreach ( $info['sub'] as $slink) {
          $sublink[] = array ( 'link' => XOOPS_URL.'/modules/'.$mod->getVar('dirname').'/'.$slink['url'], 'name' => $slink['name']);
        }
      }
    }
    return $sublink;
  }
  
  private function loadInfo($dirname)
  {
    $this->root->mLanguageManager->loadModinfoMessageCatalog($dirname);
    if (is_file(XOOPS_ROOT_PATH.'/modules/'.$dirname.'/xoops_version.php')) {
      require XOOPS_ROOT_PATH.'/modules/'.$dirname.'/xoops_version.php';
      return $modversion;
    }
  }
  
  public function getOptionForm()
  {
    $this->_loadlang();
    if ( empty($this->options[0]) ) {
      $this->options[0] = '0';
      $chk0 = ' checked="checked"';
      $chk1 = "";
    } else {
      $chk0 = "";
      $chk1 = ' checked="checked"';
    }
    $form = _MI_MLANGBLOCK_BLOCK_CONFIG.'
    <input type="radio" name="options[0]" value="0"'.$chk0.' />YES
    <input type="radio" name="options[0]" value="1"'.$chk1.' />NO<br />';
    
    return $form;
  }
}
?>
