<?php
if (!defined('XOOPS_ROOT_PATH')) die();

class Usersearch_Preload extends XCube_ActionFilter
{
  public function postFilter()
  {
    if ($this->mRoot->mContext->mUser->isInRole('Site.RegisteredUser')) {
      require_once XOOPS_MODULE_PATH.'/usersearch/service/Service.class.php';
      $service = new Usersearch_Service();
      $service->prepare();
      
      $this->mRoot->mServiceManager->addService('UserSearch', $service);
    }
  }
}
?>