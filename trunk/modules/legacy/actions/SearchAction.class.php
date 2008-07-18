<?php
/**
 *
 * @package Legacy
 * @version $Id: SearchAction.class.php,v 1.2 2007/06/24 14:58:45 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/actions/SearchResultsAction.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/forms/SearchResultsForm.class.php";

class Legacy_SearchAction extends Legacy_SearchResultsAction
{
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& $controller->mRoot;
		$service =& $root->mServiceManager->getService("LegacySearch");
		if (is_object($service)) {
			$client =& $root->mServiceManager->createClient($service);

			$this->mModules = $client->call('getActiveModules', array());
		}
		
		return LEGACY_FRAME_VIEW_INDEX;
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		foreach(array_keys($this->mModules) as $key) {
			$ret[] = $this->mModules[$key]['mid'];
		}
		
		return $ret;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName("legacy_search_form.html");
	
		$render->setAttribute('actionForm', $this->mActionForm);
			
		$render->setAttribute('moduleArr', $this->mModules);

		//
		// If the request include $mids, setAttribute it. If it don't include, 
		// setAttribute $mid or $this->mModules.
		//		
		$render->setAttribute('selectedMidArr', $this->_getSelectedMids());
		$render->setAttribute('searchRuleMessage', @sprintf(_SR_KEYTOOSHORT, $this->mConfig['keyword_min']));
	}
}

?>
