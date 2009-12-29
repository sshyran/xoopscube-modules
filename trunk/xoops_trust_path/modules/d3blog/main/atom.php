<?php
/**
 * @version $Id: atom.php 565 2008-12-22 17:54:19Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm_view()) {
    exit(d3blog_responseError("Sorry, you don't have permission to get atom feed", 1));
}

require_once(XOOPS_ROOT_PATH.'/class/template.php');
$myModule = call_user_func(array($mydirname, 'getInstance'));

$entry_handler =& $myModule->getHandler('entry');
$cat_handler =& $myModule->getHandler('category');
$all_categories =& $cat_handler->getAll();

$myts =& d3blogTextSanitizer::getInstance();
//$mydirname4show = $myts->htmlSpecialChars($mydirname);

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(10);

if (!$tpl->is_cached("db:{$mydirname}_main_atom.xml")) {

    // Meta tags
    $xoopsConfigMetaFooter = array();
    $config_handler =& xoops_gethandler('config');
    if( defined( 'XOOPS_CUBE_LEGACY' ) ) {
        $module_handler =& xoops_gethandler('module');
        $legacyRender =& $module_handler->getByDirname('legacyRender');
        if (is_object($legacyRender)) {
            $xoopsConfigMetaFooter =& $config_handler->getConfigsByCat(0, $legacyRender->get('mid'));
        }
    } else {
        $xoopsConfigMetaFooter =& $config_handler->getConfigsByCat(XOOPS_CONF_METAFOOTER);
    }

    $feed['lang'] = _LANGCODE;
    $feed['subtitle'] = xoops_convert_encoding($myts->htmlSpecialChars($xoopsConfig['sitename'].'-'.$xoopsConfig['slogan']));
    $feed['title'] = xoops_convert_encoding($myModule->module_name);
    $feed['link'] = $feed['generator_url'] = xoops_convert_encoding($myts->htmlSpecialChars(XOOPS_URL.'/'));
    $feed['link_self'] = xoops_convert_encoding($myts->htmlSpecialChars(XOOPS_URL."/modules/$mydirname/index.php?page=atom"));
    preg_match('@^(?:http://)?([^/]+)@i', XOOPS_URL, $matches);
    $feed['domain'] = xoops_convert_encoding(htmlspecialchars($matches[1], ENT_QUOTES));
//    $feed['tag_url'] = 'tag:'. $feed['domain']. ','. formatTimestamp(time(), "Y"). ':'. $mid. '.0';
    $feed['tag_url'] = xoops_convert_encoding($myts->htmlSpecialChars(XOOPS_URL."/modules/$mydirname/index.php"));
    $feed['modified'] = d3blog_iso8601_date(time());
    $feed['generator'] = xoops_convert_encoding($myts->htmlSpecialChars('D3BLOG - XOOPS BLOG MODULE'));
    $feed['meta_copyright'] = xoops_convert_encoding($myts->htmlSpecialChars($xoopsConfigMetaFooter['meta_copyright']));
    $feed['meta_author'] = xoops_convert_encoding($myts->htmlSpecialChars($xoopsConfigMetaFooter['meta_author']));

    $items = array() ;

    // obtain configuration parameters
    $limit = $myModule->getConfig('max_rdf');

    // add blog item
    $criteria =& $entry_handler->getCriteria(0, $limit);
    // CRITERIA WITH AN ENTRY PERMISSION
    $criteria =& $entry_handler->entryPermCriteria($criteria);
    $criteria->setSort('published');
    $criteria->setOrder('DESC');
    $entries =& $entry_handler->getObjects($criteria);

    foreach($entries as $entry) {
        $category =& $all_categories[$entry->cid()];
        $arr =& $entry->getStructure();
        $item['title'] = xoops_convert_encoding($entry->getVar('title'));
        $item['link'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid());
        $item['tag_url'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid());
        $item['modified'] = d3blog_iso8601_date($entry->modified());
        $item['issued'] = d3blog_iso8601_date($entry->published());
        $item['created'] = d3blog_iso8601_date($entry->created());
        $item['category'] = xoops_convert_encoding($category->getVar('name'));
        $item['blogger'] = xoops_convert_encoding($arr['blogger']['uname']);
        $item['excerpt'] = xoops_convert_encoding($entry->pingExcerpt(0));
        $item['contents'] = xoops_convert_encoding($entry->renderContents(false));
        $item['contentsStripped'] = xoops_convert_encoding($entry->renderContents(true));
        $items[] = $item;
        unset($arr);
    }

    $tpl->assign('feed', $feed);
    $tpl->assign('entries', $items);
    $tpl->display("db:{$mydirname}_main_atom.xml");
}
?>
