<?php
/**
 *
 * @package Legacy
 * @version $Id: BlockInstallEditForm.class.php,v 1.2 2007/06/25 04:05:23 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/modules/legacy/admin/forms/BlockEditForm.class.php";

class Legacy_BlockInstallEditForm extends Legacy_BlockEditForm
{
	function getTokenName()
	{
		return "module.legacy.BlockInstallEditForm.TOKEN" . $this->get('bid');
	}
	
	function update(&$obj)
	{
		parent::update($obj);
		$obj->set('visible', true);
	}
}

?>
