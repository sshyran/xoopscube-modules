<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class Mcllibs_Duplicatable extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule', 'DuplicatableModule::CreateDuplicatableModule');
    $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure', 'DuplicatableModule::CreateDuplicatableBlock');
  }
  
  public static function CreateDuplicatableModule(&$instance, $module)
  {
    if ( $module->getInfo('DuplicatableClass') != "" ) {
      $dirname = $module->get('dirname');
      $className = $module->getInfo('DuplicatableClass');
      $filePath = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/class/Module.class.php';
      if ( !class_exists($className) && is_file($filePath) ) {
        require_once $filePath;
        $instance = new $className($module);
      } elseif (class_exists($className)) {
        $instance = new $className($module);
      }
    }
  }
  
  public static function CreateDuplicatableBlock(&$retBlock, $block)
  {
    if ( $block->get('edit_func') == 'DuplicatableBlock' ) {
      $className = substr($block->get('show_func'), 4);
      $filePath = XOOPS_ROOT_PATH.'/modules/'.$block->get('dirname').'/blocks/'.$block->get('func_file');
      if ( !class_exists($className) && is_file($filePath) ) {
        require_once $filePath;
        $retBlock = new $className($block);
      } elseif (class_exists($className)) {
        $retBlock = new $className($block);
      }
    }
  }
}
?>
