<?php
/**
 *
 * @package Legacy
 * @version $Id: install_dbform.inc.php,v 1.2 2007/06/24 07:26:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
    include_once '../mainfile.php';
    include_once './class/settingmanager.php';
    $sm = new setting_manager();
    $sm->readConstant();
    $wizard->setContent($sm->editform());
    $wizard->render();
?>
