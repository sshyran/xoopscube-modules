<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require '../../mainfile.php';
define ('_MY_DIRNAME', basename(dirname(__FILE__)));
define ('_MY_MODULE_PATH', XOOPS_MODULE_PATH.'/'._MY_DIRNAME.'/');
define ('_MY_MODULE_URL', XOOPS_MODULE_URL.'/'._MY_DIRNAME.'/');
define('XOOPS_FOOTER_INCLUDED', 1);
$classname = _MY_DIRNAME;
require _MY_MODULE_PATH.'class/ModController.class.php';

$root = XCube_Root::getSingleton();
$root->mController->executeHeader();

$mymodule = new ModController();
$root->mController->mExecute->add(array($mymodule, 'execute'));
$root->mController->execute();

$root->mController->executeView();
?>
