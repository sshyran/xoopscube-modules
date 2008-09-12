<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class indexAction extends AbstractMCLAdminClass
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_index.html');
  }
}
?>