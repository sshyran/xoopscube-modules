<?php
//================================================================
// Title:   Lightbox Preload for IMGTag D3
// Version: 0.20 alpha
// Date:    2008-05-24
// Author:  manta
// URL:     http://xoops.oceanblue-site.com/
//================================================================

if (!defined('XOOPS_ROOT_PATH')) exit();

class Lightbox4imgtag extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('XoopsTpl.New', array(&$this, 'Lightboxfiles'));
	}
	function Lightboxfiles(&$xoopsTpl)
	{
		global $xoopsModule;

		$modname = 'd3imgtag';		// Set your module name
		$modpath = XOOPS_URL.'/modules/'.$modname;

		if (isset($xoopsModule)) {
			$mod = $xoopsModule->dirname();
		} else {
			$mod = '';
		}

		if ($mod == $modname) {
			$module_handler =& xoops_gethandler('module');
			$module =& $module_handler->getByDirname($modname);
			$config_handler =& xoops_gethandler('config');
			$config = $config_handler->getConfigsByCat(0, $module->getVar('mid'));

			$xoopsTpl->assign('d3imgtag_ajaxeffect', $config['d3imgtag_ajaxeffect']);
			$xoopsTpl->assign("xoops_modname", $modname);
		} else {
			$xoopsTpl->assign("xoops_modname", '');
		}

		//if ( $config['d3imgtag_enableajax'] == 1 ) {
		if ( isset($config['d3imgtag_enableajax']) ) {
		
			if ( $config['d3imgtag_ajaxeffect'] == 1 ) {
$xoops_module_header =<<< HTML
<script type="text/javascript" src="$modpath/ajax/full/prototype.js"></script>
<script type="text/javascript" src="$modpath/ajax/full/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="$modpath/ajax/full/lightbox.js"></script>
<link rel="stylesheet" href="$modpath/ajax/full/lightbox.css" type="text/css" media="screen" />
HTML;
			} else {
$xoops_module_header =<<< HTML
<link rel="stylesheet" href="$modpath/ajax/med/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="$modpath/ajax/med/lightbox.js"></script>
HTML;
			}
			$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars('xoops_module_header'));
		}
	}
}
?>