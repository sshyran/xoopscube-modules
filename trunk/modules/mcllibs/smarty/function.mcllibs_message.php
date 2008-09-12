<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_message($params, &$smarty)
{
  $message = array();
  Message_Preload::getNewMessage($message);
  if ( count($message) > 0 ) {
    $smarty->_tpl_vars['MCLLIBS_MESSAGE']['url'] = $message[0]['url'];
    $smarty->_tpl_vars['MCLLIBS_MESSAGE']['title'] = $message[0]['title'];
  }
}
?>
