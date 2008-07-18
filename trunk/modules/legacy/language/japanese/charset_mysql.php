<?php
/**
 *
 * @package Legacy
 * @version $Id: charset_mysql.php,v 1.2 2007/06/24 14:58:52 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 * @brief This file is the callback declaring Mysql Client Handling. If this
 *        declaring causes display broken, you may skip this process by using
 *        the preload defining LEGACY_JAPANESE_ANTI_CHARSETMYSQL. 
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

if (!defined("LEGACY_JAPANESE_ANTI_CHARSETMYSQL")) {
    $GLOBALS['xoopsDB']->queryF("/*!40101 SET NAMES ujis */");
    $GLOBALS['xoopsDB']->queryF("/*!40101 SET SESSION collation_connection=ujis_japanese_ci */");
}

?>