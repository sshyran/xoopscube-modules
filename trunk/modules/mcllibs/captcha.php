<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require './mainfile.php';
define ('_MY_DIRNAME', basename(dirname(__FILE__)));
define ('_MY_LIBS_PATH' , XOOPS_ROOT_PATH.'/modules/'._MY_DIRNAME.'/libs/imgtext/');
require _MY_LIBS_PATH.'imagetext.class.php';

$img = new pngimagetext();
$img->set_imgfile(_MY_LIBS_PATH.'captcha.png');
$img->set_font(_MY_LIBS_PATH.'fonts/PenguinAttack.ttf');
$img->set_fontsize(16);
if ( isset($_SESSION['_MCLLIBS']['CAPTCHA']['TOKEN']) ) {
  $img->set_value($_SESSION['_MCLLIBS']['CAPTCHA']['TOKEN']);
}
$img->view_image();
?>