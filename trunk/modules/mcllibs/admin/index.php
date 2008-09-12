<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
require_once '../../../mainfile.php';

define ('_MY_DIRNAME', basename(dirname(dirname(__FILE__))));
define ('_MY_MODULE_PATH', XOOPS_MODULE_PATH.'/'._MY_DIRNAME.'/');
define ('_MY_MODULE_URL', XOOPS_MODULE_URL.'/'._MY_DIRNAME.'/');

require _MY_MODULE_PATH.'admin/class/AdmController.class.php';

$root = XCube_Root::getSingleton();
$root->mController->executeHeader();

$modcon = new AdmController();
$root->mController->mExecute->add(array(&$modcon, 'execute'));
$root->mController->execute();

$root->mController->executeView();
?>
