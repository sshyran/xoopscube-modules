<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
class Mcllibs_Textfilter extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    require_once XOOPS_MODULE_PATH.'/mcllibs/kernel/MCL_TextFilter.class.php';
    $this->mRoot->setTextFilter(MCL_TextFilter::getInstance());
  }
  
  public function postFilter()
  {
    if ( is_object($this->mRoot->mContext->mXoopsModule) ) {
      $this->mRoot->mTextFilter->loadModPlgs($this->mRoot->mContext->mXoopsModule->get('dirname'));
    }
  }
}
?>