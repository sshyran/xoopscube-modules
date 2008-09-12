<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_postjs($params, &$smarty)
{
  //get params
  $formname = isset($params['formname']) ? $params['formname'] : 'postform';
  $returl = isset($params['returl']) ? $params['returl'] : XOOPS_URL.'/';
  $posturl = isset($params['posturl']) ? $params['posturl'] : null;
  $btncap = isset($params['btncap']) ? $params['btncap'] : _SUBMIT;
  
  $dummy = md5(uniqid(mt_rand(), true));
  
  //set session
  $_SESSION['_MCLLIBS']['POSTJS']['TOKEN'] = strtoupper(substr(sha1(uniqid(mt_rand(), true)),mt_rand(0,10),4));
  $_SESSION['_MCLLIBS']['POSTJS']['RETURL'] = $returl;
  $_SESSION['_MCLLIBS']['POSTJS']['POSTURL'] = $posturl;
  
  //create form
  $root = XCube_Root::getSingleton();
  $root->mLanguageManager->loadModuleMessageCatalog('mcllibs');
  
  $form = '<noscript>'._MI_MCLLIBS_POSTJS_NOSCRIPT.'<br /></noscript>';
  $form.= '<input type="hidden" name="MCL_stoken" id="stoken" value="'.$dummy.'" />';
  $form.= '<input type="button" name="sbbtn" value="'.$btncap.'" onclick="'.$formname.'.MCL_stoken.value=\''.$_SESSION['_MCLLIBS']['POSTJS']['TOKEN'].'\';'.$formname.'.submit();" />';
  echo $form;
}
?>
