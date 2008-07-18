<?php
/**
 *
 * @package Legacy
 * @version $Id: smiles.php,v 1.2 2007/06/24 14:58:52 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

class LegacySmilesObject extends XoopsSimpleObject
{
	function LegacySmilesObject()
	{
		$this->initVar('id', XOBJ_DTYPE_INT, '', true);
		$this->initVar('code', XOBJ_DTYPE_STRING, '', true, 50);
		$this->initVar('smile_url', XOBJ_DTYPE_STRING, '', true, 100);
		$this->initVar('emotion', XOBJ_DTYPE_STRING, '', true, 75);
		$this->initVar('display', XOBJ_DTYPE_BOOL, '0', true);
	}
}

class LegacySmilesHandler extends XoopsObjectGenericHandler
{
	var $mTable = "smiles";
	var $mPrimary = "id";
	var $mClass = "LegacySmilesObject";
	
	function delete(&$obj)
	{
		@unlink(XOOPS_UPLOAD_PATH . "/" . $obj->get('smile_url'));
		
		return parent::delete($obj);
	}
}

?>
