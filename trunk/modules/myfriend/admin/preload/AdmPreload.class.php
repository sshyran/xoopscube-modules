<?php
if (!defined('XOOPS_ROOT_PATH')) die();
class Myfriend_AdmPreload extends XCube_ActionFilter
{
  public function postFilter()
  {
    $this->mRoot->mDelegateManager->add('Legacy.Admin.Event.UserDelete', 'Myfriend_Preload::userdel');
  }
}
?>