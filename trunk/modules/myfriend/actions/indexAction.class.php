<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require _MY_MODULE_PATH.'kernel/MyPageNavi.class.php';

define('_MYFRIEND_PAGENUM', 10);

class indexAction extends AbstractAction
{
  private $listuser;
  private $mPagenavi = null;
  private $listinvi;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    $uid = $this->root->mContext->mXoopsUser->getVar('uid');
    
    $modhand = xoops_getmodulehandler('friend');
    $this->mPagenavi = new MyPageNavi($modhand);
    $this->mPagenavi->setUrl($this->url);
    $this->mPagenavi->addCriteria(new Criteria('uid', $uid));
    $this->mPagenavi->fetch();
    $modObj = $modhand->getObjects($this->mPagenavi->getCriteria());
    
    $userhand = xoops_gethandler('user');
    foreach ($modObj as $mod) {
      $this->listuser[] = $userhand->get($mod->getShow('friend_uid'));
    }
    
    $modhand = xoops_getmodulehandler('invitation');
    $modhand->oldDataDelete($this->root->mContext->mModuleConfig['deletedays']);
    $mCriteria = new CriteriaCompo();
    $mCriteria->add(new Criteria('uid', $uid));
    $modObj = $modhand->getObjects($mCriteria);
    
    foreach ($modObj as $mod) {
      foreach ( array_keys($mod->gets()) as $var_name ) {
        $item_ary[$var_name] = $mod->getShow($var_name);
      }
      $item_ary['formattedDate'] = formatTimestamp($item_ary['utime']);
      $this->listinvi[] = $item_ary;
    }
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName('myfriend_index.html');
    $render->setAttribute('ListData', $this->listuser);
    $render->setAttribute('pageNavi', $this->mPagenavi->mNavi);
    $render->setAttribute('invidata', $this->listinvi);
  }
}
?>