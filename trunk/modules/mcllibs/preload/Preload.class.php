<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
define('_MCL_LIBS_BASE_PATH', XOOPS_MODULE_PATH.'/mcllibs/');
define('_MCL_LIBS_PATH', _MCL_LIBS_BASE_PATH.'libs/');

require _MCL_LIBS_PATH.'MCL_Utils.class.php';

function __autoload($classname)
{
  $filename = "";
  switch ($classname) {
    case 'MCL_PageNavigator':
    case 'MCL_PageNavi':       $filename = 'MCL_PageNavi.class.php'; break;
    case 'TableObjectHandler': $filename = 'tablehandler.class..php'; break;
    case 'MCL_Object':         $filename = 'MCL_Object.class.php'; break;
    case 'WhereComp':          $filename = 'where.class.php'; break;
    case 'MCL_Mailer':         $filename = 'MCL_Mailer.class..php'; break;
  }
  
  if ( !empty($filename) && is_file(_MCL_LIBS_PATH.$filename) ) {
    require _MCL_LIBS_PATH.$filename;
  }
}

class Mcllibs_Preload extends XCube_ActionFilter
{
  public function preBlockFilter()
  {
    $this->mRoot->mDelegateManager->add('Legacy_RenderSystem.SetupXoopsTpl', 'Mcllibs_Preload::addFilter');
  }

  public static function addFilter(&$xoopsTpl)
  {
    $xoopsTpl->plugins_dir[] = XOOPS_MODULE_PATH.'/mcllibs/smarty';
  }
}
?>