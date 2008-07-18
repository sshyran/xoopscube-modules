<?php
/**
 *
 * @package Legacy
 * @version $Id: block_module_link.php,v 1.2 2007/06/24 14:58:52 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class LegacyBlock_module_linkObject extends XoopsSimpleObject
{
	function LegacyBlock_module_linkObject()
	{
		$this->initVar('block_id', XOBJ_DTYPE_INT, '0', true);
		$this->initVar('module_id', XOBJ_DTYPE_INT, '0', true);
	}
}

class LegacyBlock_module_linkHandler extends XoopsObjectGenericHandler
{
	var $mTable = "block_module_link";
	var $mPrimary = "block_id";
	var $mClass = "LegacyBlock_module_linkObject";
}

?>
