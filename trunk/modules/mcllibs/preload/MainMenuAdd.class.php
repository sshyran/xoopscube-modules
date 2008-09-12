<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class Mcllibs_MainMenuAdd extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    $this->mRoot->mDelegateManager->add('MCLLIBS.MainMenu', 'Mcllibs_MainMenuAdd::getMenu');
  }
  
  public static function getMenu(&$menu)
  {
    $menu[1][] = array('name' => 'Marijuana', 'link' => 'http://marijuana.ddo.jp/', 'sublinks' => array(), 'target' => '_blank');
  }
}
?>