<?php
/**
 *
 * @package Legacy
 * @version $Id: footer.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

if (!defined('XOOPS_ROOT_PATH'))  exit();
if (defined('XOOPS_FOOTER_INCLUDED')) exit();

$root=&XCube_Root::getSingleton();
if (!is_object($root->mController)) exit();

define('XOOPS_FOOTER_INCLUDED',1);

$xoopsLogger=&$root->mController->getLogger();
$xoopsLogger->stopTime();

// RMV-NOTIFY
require_once XOOPS_ROOT_PATH.'/include/notification_select.php';

// Display view
$root->mController->executeView();
?>