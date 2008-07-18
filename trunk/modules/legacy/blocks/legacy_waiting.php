<?php
/**
 *
 * @package Legacy
 * @version $Id: legacy_waiting.php,v 1.2 2007/06/24 14:58:45 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
/*------------------------------------------------------------------------*
 |  This file was entirely rewritten by the XOOPS Cube Legacy project for |
 |   keeping compatibility with XOOPS 2.0.x <http://www.xoops.org>        |
 *------------------------------------------------------------------------*/

function b_legacy_waiting_show() {
    $modules = array();
    XCube_DelegateUtils::call('Legacyblock.Wating.Show', new XCube_Ref($modules));
    $block['modules'] = $modules;
    return $block;
}
?>
