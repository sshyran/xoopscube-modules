<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_captcha($params, &$smarty)
{
  //get params
  //$prefix = isset($params['prefix']) ? trim($params['prefix']) : '_CAPSESSION';
  $width = isset($params['width']) ? intval($params['width']) : null;
  $height = isset($params['height']) ? intval($params['height']) : null;
  $returl = isset($params['returl']) ? $params['returl'] : XOOPS_URL.'/';
  $posturl = isset($params['posturl']) ? $params['posturl'] : null;
  
  //set session
  $_SESSION['_MCLLIBS']['CAPTCHA']['TOKEN'] = strtoupper(substr(sha1(uniqid(XOOPS_DB_PREFIX.mt_rand(), true)),mt_rand(0,10),6));
  $_SESSION['_MCLLIBS']['CAPTCHA']['RETURL'] = $returl;
  $_SESSION['_MCLLIBS']['CAPTCHA']['POSTURL'] = $posturl;
  
  //create form
  $form = '<img src="'.XOOPS_URL.'/modules/mcllibs/captcha.php"';
  if ( $width != null ) {
    $form.= ' width="'.$width.'"';
  }
  if ( $height != null ) {
    $form.= ' height="'.$height.'"';
  }
  $form.= ' alt="captcha_image" />';
  
  if ( isset($params['auto']) ) {
    $_SESSION['_MCLLIBS']['CAPTCHA']['AUTO_CAP'] = true;
    $root = XCube_Root::getSingleton();
    $root->mLanguageManager->loadModuleMessageCatalog('mcllibs');
    
    $form.= '<input type="hidden" name="MCLLIBS_USE_CAPTCHA" value="'.time().'" />';
    $form.= '<input type="text" name="MCLLIBS_CAPTCHA" id="captcha_text" size="8" value="" />';
    $form.= _MI_MCLLIBS_CAPTCHA_IN;
  }
  echo $form;
}
?>
