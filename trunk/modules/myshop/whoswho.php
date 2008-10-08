<?php
/**
 * ****************************************************************************
 * myshop - MODULE FOR XOOPS
 * Copyright (c) Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myshop
 * @author 			Hervé Thouzard of Instant Zero (http://www.instant-zero.com)
 *
 * Version : $Id:
 * ****************************************************************************
 */

/**
 * manufacturers
 */
require 'header.php';
$GLOBALS['current_category'] = -1;
$xoopsOption['template_main'] = 'myshop_whoswho.html';
require_once XOOPS_ROOT_PATH.'/header.php';

$tblAll = $tblAnnuaire = array();
$xoopsTpl->assign('alphabet', $h_myshop_manufacturer->getAlphabet());
$xoopsTpl->assign('mod_pref', $mod_pref);

$manufacturers = $h_myshop_manufacturer->getItems(0, 0, 'manu_name, manu_commercialname' );
foreach($manufacturers as $item) {
	$forTemplate = array();
	$forTemplate = $item->toArray();
	$initiale = $item->getInitial();
	$tblAnnuaire[$initiale][] = $forTemplate;
}
$xoopsTpl->assign('manufacturers', $tblAnnuaire);

myshop_utils::setCSS();
if (file_exists( MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php')) {
	require_once MYSHOP_PATH.'language/'.$xoopsConfig['language'].'/modinfo.php';
} else {
	require_once MYSHOP_PATH.'language/english/modinfo.php';
}

$xoopsTpl->assign('global_advert', myshop_utils::getModuleOption('advertisement'));
$xoopsTpl->assign('breadcrumb', myshop_utils::breadcrumb(array(MYSHOP_URL.basename(__FILE__) => _MI_MYSHOP_SMNAME5)));

$title = _MI_MYSHOP_SMNAME5.' - '.myshop_utils::getModuleName();
myshop_utils::setMetas($title, $title);
require_once XOOPS_ROOT_PATH.'/footer.php';
?>