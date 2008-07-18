<?php
// Forbid prefetch
if (
	(isset($_SERVER['HTTP_X_MOZ']) && $_SERVER['HTTP_X_MOZ'] === 'prefetch')
	||
	(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] === 'Fasterfox')
) {
	header ( 'HTTP/1.1 403 Forbidden' );
	exit();
}

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

include_once "$mytrustdirpath/include.php";

$xpwiki = new XpWiki($mydirname);

// initialize
$xpwiki->init();

// execute
$xpwiki->execute();

// gethtml
$xpwiki->catbody();

// Add error message
if ($xpwiki->root->userinfo['admin']) {
	$hyp_common_methods = get_class_methods('HypCommonFunc');
	if (is_null($hyp_common_methods) || ! in_array('get_version', $hyp_common_methods) || HypCommonFunc::get_version() < 20080225) {
		$xpwiki->admin_messages[] = '[Warning] Please install or update <a href="http://cvs.sourceforge.jp/cgi-bin/viewcvs.cgi/hypweb/XOOPS_TRUST/class/hyp_common.tar.gz?view=tar" title="Download">a newest HypCommonFunc</a> into "XOOPS_TRUST_PATH/class/".';
	}
	if ($xpwiki->admin_messages) {
		$xpwiki->html = '<p style="color:red;font-weight:bold;">' . join('<br />', $xpwiki->admin_messages).'</p><hr />'.$xpwiki->html;
	}
}

if ($xpwiki->runmode === 'xoops') {
	
	// xoops header
	include XOOPS_ROOT_PATH.'/header.php';

	$_xoops_header = $xoopsTpl->get_template_vars("xoops_module_header");
	$xpwiki_head = '';
	foreach(explode("\n", $_xoops_header) as $_head) {
		$_head = trim($_head);
		if ($_head && strpos($xpwiki->root->html_header, $_head) === FALSE) {
			$xpwiki_head .= $_head . "\n";
		}
	}
	$xpwiki->root->html_header .= $xpwiki_head;
	
	$xoopsTpl->assign(
		array(
			'xoops_pagetitle' => $xpwiki->root->pagetitle,
			'xoops_module_header' => $xpwiki->root->html_header,
			'xoops_breadcrumbs' => $xpwiki->get_var('breadcrumbs_array'),
			'xpwiki_pagename' => $xpwiki->get_var('page'),
 			'xpwiki_pginfo' => $xpwiki->get_pginfo(),
		)
	);
	
	echo $xpwiki->html;
	
	// xoops footer
	include XOOPS_ROOT_PATH.'/footer.php';

} else if ($xpwiki->runmode === 'xoops_admin') {

	// Check referer
	if (! $xpwiki->func->refcheck()) {
		exit('Invalid REFERER.');
	}
	
	// environment
	require_once XOOPS_ROOT_PATH.'/class/template.php' ;
	$module_handler =& xoops_gethandler( 'module' ) ;
	$xoopsModule =& $module_handler->getByDirname( $xpwiki->root->mydirname ) ;
	$config_handler =& xoops_gethandler( 'config' ) ;
	$xoopsModuleConfig =& $config_handler->getConfigsByCat( 0 , $xoopsModule->getVar( 'mid' ) ) ;

	// check permission of 'module_admin' of this module
	$moduleperm_handler =& xoops_gethandler( 'groupperm' ) ;
	if( ! is_object( @$xoopsUser ) || ! $moduleperm_handler->checkRight( 'module_admin' , $xoopsModule->getVar( 'mid' ) , $xoopsUser->getGroups() ) ) die( 'only admin can access this area' ) ;

	$xoopsOption['pagetype'] = 'admin' ;
	require XOOPS_ROOT_PATH.'/include/cp_functions.php' ;
	
	// language files
	$mydirpath = $xpwiki->root->mydirpath;
	$mytrustdirpath = $xpwiki->root->mytrustdirpath ;
	$language = empty( $xoopsConfig['language'] ) ? 'english' : $xoopsConfig['language'] ;
	if( file_exists( "$mydirpath/language/$language/admin.php" ) ) {
		// user customized language file
		include_once "$mydirpath/language/$language/admin.php" ;
	} else if( file_exists( "$mytrustdirpath/language/$language/admin.php" ) ) {
		// default language file
		include_once "$mytrustdirpath/language/$language/admin.php" ;
	} else {
		// fallback english
		include_once "$mytrustdirpath/language/english/admin.php" ;
	}

	// xoops admin header
	xoops_cp_header() ;

	// mymenu
	//$mymenu_fake_uri = '' ;
	include dirname(__FILE__).'/admin/mymenu.php' ;

	// Decide charset for CSS
	$css_charset = 'iso-8859-1';
	switch($xpwiki->cont['UI_LANG']){
		case 'ja': $css_charset = 'Shift_JIS'; break;
	}
	$dirname = $xpwiki->root->mydirname;
	// Head Tags
	list($head_pre_tag, $head_tag) = $xpwiki->func->get_additional_headtags();
	$cssprefix = $xpwiki->root->css_prefix ? 'pre=' . rawurlencode($xpwiki->root->css_prefix) . '&amp;' : '';
	
	echo <<<EOD
$head_pre_tag
<link rel="stylesheet" type="text/css" media="screen" href="{$xpwiki->cont['LOADER_URL']}?skin={$xpwiki->cont['SKIN_NAME']}&amp;pw={$xpwiki->root->pre_width}&amp;{$cssprefix}charset={$css_charset}&amp;src={$xpwiki->root->main_css}" charset="{$css_charset}" />	
$head_tag
EOD;
	
	echo $xpwiki->html;
	
	// xoops admin footer
	xoops_cp_footer() ;	

} else if ($xpwiki->runmode === 'standalone') {
	
	while( ob_get_level() ) {
		ob_end_clean() ;
	}
	echo $xpwiki->html;

}

exit;