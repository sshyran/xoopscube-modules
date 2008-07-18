<?php
/**
 *
 * @package Legacy
 * @version $Id: HelpAction.class.php,v 1.4 2008/03/08 05:47:42 minahito Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

 if (!defined('XOOPS_ROOT_PATH')) exit();

/***
 * @internal
 * 
 * The sub-class of smarty for help viewer, make it possible to use smarty in
 * help html file. This class extends Smarty to mediate the collision compiled
 * file name.
 * 
 * To support help view, there are some original modifiers.
 * 
 * 'helpurl' modify a relativity URL for connecting the dynamic page link.
 * 'helpimage' modify a image URL. These modifiers consider the existence of
 * language files.
 */
class Legacy_HelpSmarty extends Smarty
{
	/**
	 * @var string
	 */
	var $mDirname = null;
	
	/**
	 * @var XoopsModule
	 */
	var $mModuleObject = null;
	
	/**
	 * @var string
	 */
	var $mFilename = null;

	function Legacy_HelpSmarty()
	{
		parent::Smarty();

		$this->compile_id = null;
		$this->_canUpdateFromFile = true;
		$this->compile_check = true;
		$this->compile_dir = XOOPS_COMPILE_PATH;
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		
		$this->force_compile = true;

		$this->register_modifier("helpurl", "Legacy_modifier_helpurl");
		$this->register_modifier("helpimage", "Legacy_modifier_helpimage");
	}
	
	function setDirname($dirname)
	{
		$this->mDirname = $dirname;
	}

	function _get_auto_filename($autoBase, $autoSource = null, $auotId = null)
	{
		$autoSource = $this->mDirname . "_help_" . $autoSource;
		return parent::_get_auto_filename($autoBase, $autoSource, $auotId);
	}
}

function Legacy_modifier_helpurl($file, $dirname = null )
{
	$root =& XCube_Root::getSingleton();
	
	$language = $root->mContext->getXoopsConfig('language');
	$dirname = $root->mContext->getAttribute('legacy_help_dirname');

	if ( $dirname == null ) {
		$moduleObject =& $root->mContext->mXoopsModule;
		$dirname = $moduleObject->get('dirname');
	}

	//
	// TODO We should check file_exists.
	//

	$url = XOOPS_MODULE_URL . "/legacy/admin/index.php?action=Help&amp;dirname=${dirname}&amp;file=${file}";

	return $url;
}

function Legacy_modifier_helpimage($file)
{
	$root =& XCube_Root::getSingleton();
	
	$language = $root->mContext->getXoopsConfig('language');
	$dirname = $root->mContext->getAttribute('legacy_help_dirname');

	$path = "/${dirname}/language/${language}/help/images/${file}";
	if (!file_exists(XOOPS_MODULE_PATH . $path) && $language != "english") {
		$path = "/${dirname}/language/english/help/images/${file}";
	}

	return XOOPS_MODULE_URL . $path;
}

/***
 * @internal
 * This action will show the information of a module specified to user.
 */
class Legacy_HelpAction extends Legacy_Action
{
	var $mModuleObject = null;
	var $mContents = null;

	var $mErrorMessage = null;
	
	/**
	 * @access private
	 */
	var $_mDirname = null;
	
	/**
	 * @var XCube_Delegate
	 */
	var $mCreateHelpSmarty = null;
	
	function Legacy_HelpAction($flag)
	{
		parent::Legacy_Action($flag);
		
		$this->mCreateHelpSmarty =& new XCube_Delegate();
		$this->mCreateHelpSmarty->add(array(&$this, '_createHelpSmarty'));
		$this->mCreateHelpSmarty->register('Legacy_HelpAction.CreateHelpSmarty');
	}
	
	function prepare(&$controller, &$xoopsUser)
	{
		parent::prepare($controller, $xoopsUser);
		$this->_mDirname = xoops_getrequest('dirname');
	}
	
	function hasPermission(&$controller, &$xoopsUser)
	{
		$dirname = xoops_getrequest('dirname');
		$controller->mRoot->mRoleManager->loadRolesByDirname($this->_mDirname);
		return $controller->mRoot->mContext->mUser->isInRole('Module.' . $dirname . '.Admin');
	}
	
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$moduleHandler =& xoops_gethandler('module');
		$this->mModuleObject =& $moduleHandler->getByDirname($this->_mDirname);
		
		$language = $controller->mRoot->mContext->getXoopsConfig('language');

		//
		// TODO We must change the following lines to ActionForm.
		//
		$helpfile = xoops_getrequest('file') ? xoops_getrequest('file') : $this->mModuleObject->getHelp();

		//
		// Smarty
		//
		$smarty = null;
		$this->mCreateHelpSmarty->call(new XCube_Ref($smarty));
		$smarty->setDirname($this->_mDirname);

		//
		// file check
		//
		// TODO We should not access files in language directory directly.
		//
		$template_dir = XOOPS_MODULE_PATH . "/" . $this->_mDirname . "/language/${language}/help";
		if (!file_exists($template_dir . "/" . $helpfile)) {
			$template_dir = XOOPS_MODULE_PATH . "/" . $this->_mDirname . "/language/english/help";
			if (!file_exists($template_dir . "/" . $helpfile)) {
				$this->mErrorMessage = _AD_LEGACY_ERROR_NO_HELP_FILE;
				return LEGACY_FRAME_VIEW_ERROR;
			}
		}
		
		$controller->mRoot->mContext->setAttribute('legacy_help_dirname', $this->_mDirname);

		$smarty->template_dir = $template_dir;
		$this->mContents = $smarty->fetch("file:" . $helpfile);

		return LEGACY_FRAME_VIEW_SUCCESS;
	}

	function _createHelpSmarty(&$smarty)
	{
		if (!is_object($smarty)) {
			$smarty = new Legacy_HelpSmarty();
		}
	}
	
	function executeViewSuccess(&$controller, &$xoopsUser, &$renderer)
	{
		$renderer->setTemplateName("help.html");
		
		$module =& Legacy_Utils::createModule($this->mModuleObject);
		
		$renderer->setAttribute('module', $module);
		$renderer->setAttribute('contents', $this->mContents);
	}

	function executeViewError(&$controller, &$xoopsUser, &$renderer)
	{
		$controller->executeRedirect('./index.php?action=ModuleList', 1, $this->mErrorMessage);
	}
}

?>