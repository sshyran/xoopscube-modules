<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_commentview($params, &$smarty)
{
  //modid:モジュールID
  //itemid:アイテムID（uidとか）
  $com['modid'] = isset($params['modid']) ? intval($params['modid']) : 0;
  $com['itemid'] = isset($params['itemid']) ? intval($params['itemid']) : 0;
  
  $root = XCube_Root::getSingleton();
  if ( empty($com['modid']) && $root->mContext->mModule != null ) {
    $com['modid'] = $root->mContext->mModule->mXoopsModule->get('mid');
  }
  $status = $root->mContext->mUser->isInRole('Site.RegisteredUser') ? '>=' : '=';
  //require_once _MCL_LIBS_PATH.'MCL_Utils.class.php';
  
  $where = new WhereComp();
  $where->add(new WhereElement(_WHERE_FIELD_INT, 'com_modid', $com['modid']));
  $where->add(new WhereElement(_WHERE_FIELD_INT, 'com_itemid', $com['itemid']));
  $where->add(new WhereElement(_WHERE_FIELD_INT, 'com_status', 1, $status));
  $where->addOrder('com_time', 'DESC');

  $hand = MCL_Utils::get_handler('comment', array('com_modid', 'com_itemid', 'com_id'), 'mcllibs');
  $objs = $hand->getObjects($where);

  $root->mLanguageManager->loadModuleMessageCatalog('mcllibs');
  $fileName = XOOPS_MODULE_PATH.'/mcllibs/templates/mcllibs_comment_view.html';
  $smarty->assign('comment_objs', $objs);
  $form = $smarty->fetch($fileName);
  $smarty->clear_assign('comment_objs');
  echo $form;
}
?>
