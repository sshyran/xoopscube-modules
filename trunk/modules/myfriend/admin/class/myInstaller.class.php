<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
require_once XOOPS_ROOT_PATH.'/modules/legacy/admin/class/ModuleInstaller.class.php';

class Myfriend_myInstaller extends Legacy_ModuleInstaller
{
  function Myfriend_myInstaller()
  {
    parent::Legacy_ModuleInstaller();
  }
  
  function executeInstall()
  {
    if ( version_compare(PHP_VERSION, '5.0.0', '>') ) {
      return parent::executeInstall();
    } else {
      $this->mLog->addError(_MI_MYFRIEND_INSTALL_ERROR);
    }
  }
}
?>
