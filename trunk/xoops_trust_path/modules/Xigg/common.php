<?php
set_include_path(XOOPS_TRUST_PATH . '/PEAR' . PATH_SEPARATOR . get_include_path());
require_once 'Xigg.php';
require_once 'SabaiXOOPS.php';
Sabai::start(SABAI_LOG_ERROR_ALL, _CHARSET);
$module_path = XOOPS_ROOT_PATH . '/modules/' . $module_dirname;
$xigg =& Xigg::getInstance(SabaiXOOPS::getConfig('Xigg',
                                                 $module_dirname,
                                                 array(
                                                   'cacheDir'  => $module_path . '/cache',
                                                   'pluginDir' => array(
                                                                    $module_path . '/plugins',
                                                                    dirname(__FILE__) . '/plugins'))),
                          $module_dirname);
textdomain('Xigg');