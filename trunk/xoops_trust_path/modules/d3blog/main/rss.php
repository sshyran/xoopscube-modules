<?php
/**
 * @version $Id: rss.php 565 2008-12-22 17:54:19Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once(XOOPS_ROOT_PATH.'/class/template.php');

// check if user has perm
if(!$currentUser->blog_perm()) {
    exit(d3blog_responseError("Sorry, you don't have permission to get atom feed", 1));
}

$cat_handler =& $myModule->getHandler('category');
$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');
$myts =& d3blogTextSanitizer::getInstance();

// CRITERIA FOR TOTAL ENTRIES COUNT
$criteria =& $entry_handler->getCriteria();
// CRITERIA WITH AN ENTRY PERMISSION
$criteria =& $entry_handler->entryPermCriteria($criteria);
if(!$criteria) {
    $ermsg = $entry_handler->result_message_;
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, htmlspecialchars($ermsg, ENT_QUOTES));
}

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(10);

if (!$tpl->is_cached("db:{$mydirname}_main_rss.xml")) {

    $feed['lang'] = _LANGCODE;
    $feed['title'] = xoops_convert_encoding($myModule->module_name);
    $feed['link'] = XOOPS_URL.'/';
    $feed['desc'] = xoops_convert_encoding(htmlspecialchars($xoopsConfig['sitename'].'-'.$xoopsConfig['slogan'], ENT_QUOTES));
    $feed['lastbuild'] = d3blog_rfc2822_date(time());
    $feed['category'] = xoops_convert_encoding($myModule->module_name);
    $feed['generator'] = xoops_convert_encoding(htmlspecialchars('D3BLOG - XOOPS BLOG MODULE', ENT_QUOTES));
    $logo_path = $myModule->getConfig('logo_path');
    $feed['logo_url'] = '';
    if(!empty($logo_path) && file_exists($logo_path)) {
        $dimention = getimagesize($logo_path);
        if(count($dimension)) {
            $feed['logo_url'] = htmlspecialchars(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $logo_path), ENT_QUOTES);
            $feed['logo_width' ] = intval($dimention[0]);
            $feed['logo_height' ] = intval($dimention[1]);
        }
    }

    $items = array() ;

    // obtain configuration parameters
    $limit = intval($myModule->getConfig('max_rdf'));

    // add blog item
    $criteria =& $entry_handler->getCriteria(0, $limit);
    // CRITERIA WITH AN ENTRY PERMISSION
    $criteria =& $entry_handler->entryPermCriteria($criteria);
    $criteria->setSort('published');
    $criteria->setOrder('DESC');
    $entries =& $entry_handler->getObjects($criteria);

    foreach($entries as $entry) {
        $item['title'] = xoops_convert_encoding($entry->getVar('title'));
        $item['link'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid());
        $item['guid'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid());
        $item['pubdate'] = d3blog_rfc2822_date($entry->published());
        $item['description'] = xoops_convert_encoding($entry->pingExcerpt(0));
        $items[] = $item;
    }

    $tpl->assign('feed', $feed);
    $tpl->assign('entries', $items);

}

$tpl->display("db:{$mydirname}_main_rss.xml");
?>
