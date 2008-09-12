<?php
/*
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
if (!defined('XOOPS_ROOT_PATH')) exit();

class commentAction extends AbstractMCLAdminClass
{
  private $mcomm;
  private $vcomm;
  private $pageNavi;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function execute()
  {
    $hand = MCL_Utils::get_handler('comment', array('com_modid', 'com_itemid', 'com_id'));
    //noview
    $where = new WhereComp(new WhereElement(_WHERE_FIELD_INT, 'com_status', '0'));
    $where->addOrder('com_time');
    $this->mcomm = $hand->getObjects($where);
    
    $where = new WhereComp(new WhereElement(_WHERE_FIELD_INT, 'com_status', '0', '>'));
    $where->addOrder('com_time', 'DESC');
    $this->pageNavi = new MCL_PageNavi($hand, $where);
    $this->pageNavi->fetch();
    $this->vcomm = $hand->getObjects($this->pageNavi->getCriteria());
  }
  
  public function executeView(&$render)
  {
    $render->setTemplateName(_MY_MODULE_PATH.'admin/templates/mcladmin_comment.html');
    $render->setAttribute('mcomm', $this->mcomm);
    $render->setAttribute('vcomm', $this->vcomm);
    $render->setAttribute('pagenavi', $this->pageNavi->mNavi);
  }
}
?>