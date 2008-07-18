<?php
/**
 *
 * @package Legacy
 * @version $Id: BlockInstallFilterForm.class.php,v 1.2 2007/06/25 04:05:23 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/admin/forms/BlockFilterForm.class.php";

class Legacy_BlockInstallFilterForm extends Legacy_BlockFilterForm
{
	function _getVisible()
	{
		return 0;
	}
}

?>
