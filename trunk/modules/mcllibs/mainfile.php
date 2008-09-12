<?php
/**
 * @author Marijuana
 * @license http://creativecommons.org/licenses/by-nc/3.0/
 */
define('_MCLBASE_DIRNAME', basename(dirname(__FILE__)));
define('_LEGACY_PREVENT_LOAD_CORE_', true);

require dirname(__FILE__).'/../../mainfile.php';
require XOOPS_ROOT_PATH.'/core/XCube_Session.class.php';
require XOOPS_ROOT_PATH.'/core/XCube_LanguageManager.class.php';
require XOOPS_ROOT_PATH.'/core/XCube_Delegate.class.php';

require XOOPS_ROOT_PATH.'/modules/'._MCLBASE_DIRNAME.'/kernel/Session_Controller.class.php';
require XOOPS_ROOT_PATH.'/modules/'._MCLBASE_DIRNAME.'/kernel/database.class.php';

$root = XCube_Root::getSingleton();
$root->LoadController();
?>