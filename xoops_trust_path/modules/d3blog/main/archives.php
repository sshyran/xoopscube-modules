<?php
/**
 * @version $Id: archives.php 476 2008-06-15 05:33:18Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm_view()) {
    redirect_header(XOOPS_URL.'/index.php', 1, _MD_D3BLOG_ERROR_NO_PERM_FOR_VIEW);
    exit();
}

//$myModule = call_user_func(array($mydirname, 'getInstance'));

// obtain class instances
$cat_handler =& $myModule->getHandler('category');
$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');
$myts =& d3blogTextSanitizer::getInstance();

// CRITERIA FOR TOTAL ENTRIES COUNT WITH AN ENTRY PERMISSION
$criteria =& $entry_handler->getCriteria();
$criteria =& $entry_handler->entryPermCriteria($criteria);

if(!$criteria) {
    $ermsg = $entry_handler->result_message_;
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname4show), 1, $ermsg);
    exit;
}

$count = $entry_handler->getCount($criteria);

$perpage = $myModule->getConfig('archive_numperpage');
if(empty($perpage)) {
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, _MD_D3BLOG_ERROR_NO_NUM_PER_PAGE);
    exit;
}

// HOW MANY PAGES
$page_navigater = '';
if ( $count > $perpage ) {
    require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($count, $perpage, intval($entry_handler->filter_->start_), "start", $myts->htmlSpecialChars($entry_handler->filter_->extra_uri_));
    $page_navigater = $nav->renderNav();
}

// GET ENTRIES
$criteria->setSort('published');
$criteria->setOrder('DESC');
$criteria->setLimit($perpage);
$criteria->setStart(intval($entry_handler->filter_->start_));

$objs =& $entry_handler->getObjects($criteria, true);

$entries = array();
foreach ($objs as $obj) {
    $entry = $obj->getStructure();
    $entry['summary'] = $obj->pingExcerpt(60);
    $entries[] = $entry;
}

$xoopsOption['template_main'] = $mydirname.'_main_archives.html';

// Include the page header
include(XOOPS_ROOT_PATH.'/header.php');

// BREADCRUMBS and PAGE TITLE
$entry_handler->filter_->breadcrumbs_info_[] = array('name' => _MD_D3BLOG_LANG_ARCHIVE_LIST,
    'url' => sprintf('%s/modules/%s/archives.php', XOOPS_URL, $mydirname4show)); 
if(!empty($entry_handler->filter_->subtitle_))
    $entry_handler->filter_->subtitle_ = _MD_D3BLOG_LANG_ARCHIVE_LIST.'>'.$entry_handler->filter_->subtitle_;
else
    $entry_handler->filter_->subtitle_ = _MD_D3BLOG_LANG_ARCHIVE_LIST;
$xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($entry_handler->filter_->breadcrumbs_info_));

$xoopsTpl->assign( array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => $entry_handler->filter_->subtitle_
    )
);

$bloggers =& myPerm::getUsersByName('blog_perm_edit');
$currentUser4show =& $currentUser->getStructure();
$currentUser4show['user_perm'] =& $currentUser->_userPerm[$myModule->module_id]->getArray();

$xoopsTpl->assign( array(
    'myname' => htmlspecialchars($myModule->module_name, ENT_QUOTES),
    'mydirname' => $mydirname4show,
    'mydirpath' => $mydirpath4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => $myts->htmlSpecialChars($entry_handler->filter_->subtitle_),
    'feeder' => $feeder,
    'isArchive' => true,
    'filter' => get_object_vars($entry_handler->filter_),
    'catselbox' => $cat_handler->getChildTreeArray(),
    'dateselbox' => $entry_handler->getDateSelbox(),
    'bloggerselbox' => $bloggers,
    'bloggers' => count($bloggers),
    'category_breadcrumbs' => array_reverse($cat_handler->getNicePathArrayFromId($entry_handler->filter_->cid_, XOOPS_URL."/modules/$mydirname4show/index.php")),
    'currentUser' => $currentUser4show,
    'show_archives' => count($count)? 1 : 0,
    'counter' => $count,
    'entries' => $entries,
    'imagepath' => str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $imagepath),
    'images' => d3blog_getCatImages($imagepath),
    'page_navigater' => $page_navigater
    )
);

//$xoopsTpl->xoops_setDebugging(true);  // smarty debug
// Include the page footer
include(XOOPS_ROOT_PATH.'/footer.php');



?>
