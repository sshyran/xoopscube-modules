<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class GroupPermForm extends XCube_ActionForm
{
  public function __construct()
  {
    parent::XCube_ActionForm();
  }
  
  public function getTokenName()
  {
    return 'module.message.GroupPerm.TOKEN';
  }
  
  public function prepare()
  {
    $this->mFormProperties['gid'] = new XCube_IntProperty('gid');

    $this->mFormProperties['mid'] = new XCube_IntArrayProperty('mid');
    $this->mFormProperties['modadm'] = new XCube_IntArrayProperty('modadm');
    $this->mFormProperties['oldmodadm'] = new XCube_IntArrayProperty('oldmodadm');
    
    $this->mFormProperties['modacc'] = new XCube_IntArrayProperty('modacc');
    $this->mFormProperties['oldmodacc'] = new XCube_IntArrayProperty('oldmodacc');
    
    $this->mFormProperties['bid'] = new XCube_IntArrayProperty('bid');
    $this->mFormProperties['blkacc'] = new XCube_IntArrayProperty('blkacc');
    $this->mFormProperties['oldblkacc'] = new XCube_IntArrayProperty('oldblkacc');
  }
}
?>
