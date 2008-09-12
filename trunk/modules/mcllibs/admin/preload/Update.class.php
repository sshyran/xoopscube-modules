<?php
/**
 * @author Marijuana
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 */
class mcllibs_Update extends XCube_ActionFilter
{
  public function postFilter()
  {
    $this->mRoot->mDelegateManager->add('Legacypage.Admin.SystemCheck', 'MCL_Updatecheck::check');
  }
}

class MCL_Updatecheck
{
  const file_url = 'http://marijuana.ddo.jp/modules/downloads/vercheck.php';
  const file_xml = 'mcl_update.xml';
  public static function check()
  {
    $xml_file = XOOPS_CACHE_PATH.'/'.MCL_Updatecheck::file_xml;
    if ( !is_file($xml_file) || filectime($xml_file) < time() - 86400 ) {
      MCL_Updatecheck::getupdate();
    }
    
    if ( is_file($xml_file) && function_exists('simplexml_load_file') ) {
      if ( $xml = simplexml_load_file($xml_file) ) {
        $moduleHandler = xoops_gethandler('module');
        $objs = $moduleHandler->getObjects();
        
        foreach ( $objs as $obj ) {
          $info = $obj->getInfo('mcl_update');
          if ( $info ) {
            if ( isset($xml->$info) ) {
              if ( floatval($xml->$info->version) > floatval($obj->getInfo('version')) ) {
                xoops_error($obj->getVar('name').' is update version '.$xml->$info->version, '', 'warning');
              }
            }
          }
        }
      }
    } else {
      xoops_error('simplexml_load_file is nothing.', '', 'warning');
    }
  }
  
  private static function getupdate()
  {
    require_once XOOPS_ROOT_PATH.'/class/snoopy.php';
    $file = MCL_Updatecheck::file_url;
    $snoopy = new Snoopy();
    if ( $snoopy->fetch( $file ) ) {
      file_put_contents(XOOPS_CACHE_PATH.'/'.MCL_Updatecheck::file_xml, $snoopy->results);
    }
  }
}
?>