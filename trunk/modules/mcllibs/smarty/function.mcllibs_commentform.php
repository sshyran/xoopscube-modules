<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_commentform($params, &$smarty)
{
  //modid:モジュールID
  //itemid:アイテムID（uidとか）
  //status: 0は非表示、1は表示、2は登録ユーザのみ表示（0にすればモデレート）
  //xcode:XCodeの使用時は1
  //returl:コメント投稿後の戻り先
  //rows:textareaのrows
  //cols:textareaのcols
  //spam:0=なし 1=captcha 2=JS 3=captcha&JS
  $com['modid'] = isset($params['modid']) ? intval($params['modid']) : 0;
  $com['itemid'] = isset($params['itemid']) ? intval($params['itemid']) : 0;
  $com['status'] = isset($params['status']) ? intval($params['status']) : 0;
  $com['xcode'] = isset($params['xcode']) ? intval($params['xcode']) : 0;
  $com['returl'] = isset($params['returl']) ? $params['returl'] : XOOPS_URL.'/';
  
  $token = strtoupper(substr(sha1(uniqid(XOOPS_DB_PREFIX.mt_rand(), true)), mt_rand(0,10), 8));
  $rows = isset($params['rows']) ? intval($params['rows']) : 6;
  $cols = isset($params['cols']) ? intval($params['cols']) : 50;
  $spam = isset($params['spam']) ? intval($params['spam']) : 0;
  
  $root = XCube_Root::getSingleton();
  if ( empty($com['modid']) && $root->mContext->mModule != null ) {
    $com['modid'] = $root->mContext->mModule->mXoopsModule->get('mid');
  }
  
  $captcha = $postjs = false;
  if (!$root->mContext->mUser->isInRole('Site.RegisteredUser')) {
    switch ( $spam ) {
      case 1: $captcha = $com['returl']; break;
      case 2: $postjs = $com['returl']; break;
      case 3: $captcha = $postjs = $com['returl']; break;
    }
  }
  
  //set session
  $_SESSION['_MCLLIBS']['COMMENT'][$token] = $com;
  
  $root->mLanguageManager->loadModuleMessageCatalog('mcllibs');
  $fileName = XOOPS_MODULE_PATH.'/mcllibs/templates/mcllibs_comment_form.html';
  $smarty->assign('comment_token', $token);
  $smarty->assign('comment_rows', $rows);
  $smarty->assign('comment_cols', $cols);
  $smarty->assign('comment_captcha', $captcha);
  $smarty->assign('comment_postjs', $postjs);
  
  $form = $smarty->fetch($fileName);
  
  $smarty->clear_assign('comment_token');
  $smarty->clear_assign('comment_rows');
  $smarty->clear_assign('comment_cols');
  $smarty->clear_assign('comment_captcha');
  $smarty->clear_assign('comment_postjs');
  
  echo $form;
}
?>
