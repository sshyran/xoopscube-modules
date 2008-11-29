<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_MODULE_PATH.'/legacy/kernel/Legacy_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class UsersearchForm extends Legacy_ActionForm
{
  public function __construct()
  {
    parent::XCube_ActionForm();
  }
  
  public function getTokenName()
  {
    return 'module.usersearch.Search.TOKEN';
  }

  public function prepare()
  {
    $this->mFormProperties['searchtype'] = new XCube_IntProperty('searchtype');
    $this->mFormProperties['uname'] = new XCube_StringProperty('uname');
    $this->mFormProperties['dosearch'] = new XCube_IntProperty('dosearch');
  }
  
  public function validate()
  {
    foreach (array_keys($this->mFormProperties) as $name) {
      if (isset($this->mFieldProperties[$name])) {
        if ($this->mFormProperties[$name]->isArray()) {
          foreach (array_keys($this->mFormProperties[$name]->mProperties) as $_name) {
            $this->mFieldProperties[$name]->validate($this->mFormProperties[$name]->mProperties[$_name]);
          }
        } else {
          $this->mFieldProperties[$name]->validate($this->mFormProperties[$name]);
        }
      }
    }
    
    foreach (array_keys($this->mFormProperties) as $name) {
      $methodName = 'validate' . ucfirst($name);
      if (method_exists($this, $methodName)) {
        $this->$methodName();
      }
    }
  }
}
?>
