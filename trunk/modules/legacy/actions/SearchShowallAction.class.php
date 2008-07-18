<?php
/**
 *
 * @package Legacy
 * @version $Id: SearchShowallAction.class.php,v 1.2 2007/06/24 14:58:45 nobunobu Exp $
 * @copyright Copyright 2005-2007 XOOPS Cube Project  <http://xoopscube.sourceforge.net/> 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE Version 2
 *
 */

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . "/legacy/actions/SearchResultsAction.class.php";
require_once XOOPS_MODULE_PATH . "/legacy/forms/SearchShowallForm.class.php";

class Legacy_SearchShowallAction extends Legacy_SearchResultsAction
{
	function _setupActionForm()
	{
		$this->mActionForm =& new Legacy_SearchShowallForm($this->mConfig['keyword_min']);
		$this->mActionForm->prepare();
	}
	
	function _getTemplateName()
	{
		return "legacy_search_showall.html";
	}
	
	function _getSelectedMids()
	{
		$ret = array();
		$ret[] = $this->mActionForm->get('mid');
		
		return $ret;
	}
	
	function _getMaxHit()
	{
		return LEGACY_SEARCH_SHOWALL_MAXHIT;
	}
	
	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		parent::executeViewIndex($controller, $xoopsUser, $render);
		
		$prevStart = $this->mActionForm->get('start') - LEGACY_SEARCH_SHOWALL_MAXHIT;
		if ($prevStart < 0) {
			$prevStart = 0;
		}
		
		$render->setAttribute('prevStart', $prevStart);
		$render->setAttribute('nextStart', $this->mActionForm->get('start') + LEGACY_SEARCH_SHOWALL_MAXHIT);
	}
}

?>
