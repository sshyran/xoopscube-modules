<?php
/**
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 3
 * @author Marijuana
 */
require_once XOOPS_ROOT_PATH.'/modules/legacy/admin/class/ModuleInstaller.class.php';

class Message_myInstaller extends Legacy_ModuleInstaller
{
  function Message_myInstaller()
  {
    parent::Legacy_ModuleInstaller();
  }
  
  function executeInstall()
  {
    if ( version_compare(PHP_VERSION, '5.0.0', '>') ) {
      return parent::executeInstall();
    } else {
      $this->mLog->addError(_MI_MESSAGE_INSTALL_ERROR);
    }
  }
}
?>
