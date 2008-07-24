<?php
/**
 *
 * @package Legacy
 * @version $Id: session.php,v 1.4 2007/09/22 06:54:51 minahito Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

/**
  * Regenerate New Session ID & Delete OLD Session
  * @deprecated
  */

function xoops_session_regenerate()
{
    $root =& XCube_Root::getSingleton();
    $root->mSession->regenerate();
}
?>
