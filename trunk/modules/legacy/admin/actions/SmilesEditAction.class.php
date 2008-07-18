<?php
/**
 *
 * @package Legacy
 * @version $Id: SmilesEditAction.class.php,v 1.2 2007/06/25 04:05:22 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/class/AbstractEditAction.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/admin/forms/SmilesAdminEditForm.class.php";

class Legacy_SmilesEditAction extends Legacy_AbstractEditAction
{
	function _getId()
	{
		return isset($_REQUEST['id']) ? xoops_getrequest('id') : 0;
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('smiles');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm =& new Legacy_SmilesAdminEditForm();
		$this->mActionForm->prepare();
	}
	
	
	function _doExecute()
	{
		if ($this->mActionForm->mFormFile != null) {
			if (!$this->mActionForm->mFormFile->saveAs(XOOPS_UPLOAD_PATH)) {
				return false;
			}
		}

		//
		// 古いファイルがあれば削る
		//
		if ($this->mActionForm->mOldAvatarFilename != null && $this->mActionForm->mOldAvatarFilename != "blank.gif") {
			@unlink(XOOPS_UPLOAD_PATH . "/" . $this->mActionForm->mOldAvatarFilename);
		}

		return parent::_doExecute();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("smiles_edit.html");
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=SmilesList");
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect("./index.php?action=SmilesList", 1, _MD_LEGACY_ERROR_DBUPDATE_FAILED);
	}
	
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward("./index.php?action=SmilesList");
	}
}

?>
