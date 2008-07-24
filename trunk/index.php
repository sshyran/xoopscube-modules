<?php
/**
 *
 * @package Legacy
 * @version $Id: index.php,v 1.2 2007/06/24 07:26:21 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */
require_once "./mainfile.php";
require_once "./header.php";

$xoopsOption['show_cblock'] = 1;
XCube_DelegateUtils::call("Legacypage.Top.Access");

require_once "./footer.php";
?>
