<?php
/**
 *
 * @package Legacy
 * @version $Id: imagebody.php,v 1.2 2007/06/24 14:58:52 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class LegacyImagebodyObject extends XoopsSimpleObject
{
	function LegacyImagebodyObject()
	{
		$this->initVar('image_id', XOBJ_DTYPE_INT, '', false);
		$this->initVar('image_body', XOBJ_DTYPE_TEXT, '', true);
	}
}

class LegacyImagebodyHandler extends XoopsObjectGenericHandler
{
	var $mTable = "imagebody";
	var $mPrimary = "image_id";
	var $mClass = "LegacyImagebodyObject";
}

?>
