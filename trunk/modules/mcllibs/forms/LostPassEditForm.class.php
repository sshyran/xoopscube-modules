<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';

class MCL_LostPassEditForm extends XCube_ActionForm
{
  public function __construct()
  {
    parent::XCube_ActionForm();
  }

  public function getTokenName()
  {
    return 'module.MCLLIBS.LostPassEditForm.TOKEN';
  }

  public function prepare()
  {
    $root = XCube_Root::getSingleton();
    $root->mLanguageManager->loadModuleMessageCatalog('user');
    
    $this->mFormProperties['email'] = new XCube_StringProperty('email');
    $this->mFormProperties['code'] = new XCube_StringProperty('code');

    $this->mFieldProperties['email'] = new XCube_FieldProperty($this);
    $this->mFieldProperties['email']->setDependsByArray(array('required', 'email'));
    $this->mFieldProperties['email']->addMessage('required', _MD_USER_ERROR_REQUIRED, _MD_USER_LANG_EMAIL);
    $this->mFieldProperties['email']->addMessage('email', _MD_USER_ERROR_EMAIL, _MD_USER_LANG_EMAIL);
  }
}
?>
