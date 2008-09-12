<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
function smarty_function_mcllibs_randimage($params, &$smarty)
{
  //get params
  $num = isset($params['num']) ? intval($params['num']) : 3;
  $path = isset($params['path']) ? XOOPS_ROOT_PATH.'/uploads/'.$params['path'].'/' : XOOPS_ROOT_PATH.'/uploads/';
  
  //$images = glob($path.'*.jpg');
  $images = array_merge(glob($path.'*.jpg'), glob($path.'*.JPG'));
  if ( count($images) < $num ) {
    $num = count($images);
  }
  
  if ( $num < 0 ) {
    return;
  }
  
  $imgnum = array_rand($images, $num);
  
  foreach ( $imgnum as $i ) {
    $smarty->_tpl_vars['randimages'][] = basename($images[$i]);
  }
}
?>
