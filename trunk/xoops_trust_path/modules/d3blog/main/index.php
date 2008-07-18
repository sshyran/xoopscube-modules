<?php
/**
 * @version $Id: index.php 465 2008-06-08 07:46:13Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm()) {
    redirect_header(XOOPS_URL.'/index.php', 1, _MD_D3BLOG_ERROR_NO_PERM_FOR_VIEW);
    exit();
}

$cat_handler =& $myModule->getHandler('category');
$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');

$myts =& d3blogTextSanitizer::getInstance();

// CRITERIA FOR TOTAL ENTRIES COUNT WITH AN ENTRY PERMISSION
$criteria =& $entry_handler->getCriteria();
if(!$criteria) {
    $ermsg = $myts->undoHtmlSpecialChars($entry_handler->result_message_);
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, htmlspecialchars($ermsg, ENT_QUOTES));
}
$criteria =& $entry_handler->entryPermCriteria($criteria);

$count = $entry_handler->getCount($criteria);

$perpage = intval($myModule->getConfig('num_per_page'));
if(empty($perpage)) {
    redirect_header(XOOPS_URL.'/index.php', 1, _MD_D3BLOG_ERROR_NO_NUM_PER_PAGE);
    exit;
}
// HOW MANY PAGES
$page_navigater = '';
if ( $count > $perpage ) {
    require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($count, $perpage, intval($entry_handler->filter_->start_), "start", $entry_handler->filter_->extra_uri_);
    $page_navigater = $nav->renderNav();
}

// GET ENTRIES
$criteria->setSort('published');
$criteria->setOrder('DESC');
$criteria->setLimit($perpage);
$criteria->setStart(intval($entry_handler->filter_->start_));

$objs =& $entry_handler->getObjects($criteria);

$entries = array();
foreach ($objs as $obj) {
    $entry = $obj->getStructure();
    $entries[] = $entry;
}

$xoopsOption['template_main'] = $mydirname.'_main_index.html';

// Include the page header
include(XOOPS_ROOT_PATH.'/header.php');

// BREADCRUMBS and PAGE TITLE
if(empty($entry_handler->filter_->breadcrumbs_info_)) {
    $entry_handler->filter_->breadcrumbs_info_[] = array('name' => _MD_D3BLOG_LANG_LATEST_ENTRIES, 'url' => '');
    $entry_handler->filter_->subtitle_ = _MD_D3BLOG_LANG_LATEST_ENTRIES;
}
$xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($entry_handler->filter_->breadcrumbs_info_));


$bloggers =& myPerm::getMembersByName('blog_perm_edit');
$currentUser4show =& $currentUser->getStructure();
$currentUser4show['user_perm'] =& $currentUser->_userPerm[$myModule->module_id]->getArray();

// WHAT'S FEEDER
if(count($entry_handler->filter_->feeder_)) {
    if(!isset($entry_handler->filter_->uid_) || count($bloggers) > 1) {
//        array_walk($feeder, create_function('&$v,$k', '$v = $v . "'.$entry_handler->filter_->feeder_['uri'].'";'));
        $feeder['what_feeder']['uri'] = $entry_handler->filter_->feeder_['uri'];
        $feeder['what_feeder']['lang'] = $entry_handler->filter_->feeder_['lang'];
    }
}

$xoopsTpl->assign( array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => $entry_handler->filter_->subtitle_
    )
);

$xoopsTpl->assign( array(
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mydirpath' => $mydirpath4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => $entry_handler->filter_->subtitle_,
    'feeder' => $feeder,
    'isIndex' => true,
    'category_breadcrumbs' => array_reverse($cat_handler->getNicePathArrayFromId($entry_handler->filter_->cid_, XOOPS_URL."/modules/$mydirname/index.php")),
    'extra_uri' => $entry_handler->filter_->extra_uri_,
    'currentUser' => $currentUser4show,
    'bloggers' => count($bloggers),
    'entries' => $entries,
    'imagepath' => str_replace(XOOPS_ROOT_PATH, XOOPS_URL, htmlspecialchars($imagepath, ENT_QUOTES)),
    'images' => d3blog_getCatImages($imagepath),
    'page_navigater' => $page_navigater
    )
);

// Include the page footer
include(XOOPS_ROOT_PATH.'/footer.php');

?>