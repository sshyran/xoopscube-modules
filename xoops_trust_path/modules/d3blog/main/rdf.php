<?php
/**
 * @version $Id: rdf.php 664 2010-10-20 13:56:43Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm()) {
    exit(d3blog_responseError("Sorry, you don't have permission to get atom feed", 1));
}

// mbstring
if(function_exists('mb_http_output'))
    mb_http_output('pass');

require_once(XOOPS_ROOT_PATH.'/class/template.php');
$entry_handler =& $myModule->getHandler('entry');

$myts =& MyTextSanitizer::getInstance();

$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(0);

if (!$tpl->is_cached("db:{$mydirname}_main_rdf.xml")) {
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

    $feed['language'] = _LANGCODE;
    $feed['description'] = xoops_convert_encoding(htmlspecialchars($xoopsConfig['sitename'].'-'.$xoopsConfig['slogan'], ENT_QUOTES));
    $feed['title'] = xoops_convert_encoding(htmlspecialchars($myModule->module_name, ENT_QUOTES));
    $feed['link'] = sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname4show);
    $feed['creater'] = xoops_convert_encoding(htmlspecialchars($xoopsConfigMetaFooter['meta_author'], ENT_QUOTES));

    $items = array() ;
    // obtain configuration parameters
    $limit = intval($myModule->getConfig('max_rdf'));

    $criteria =& $entry_handler->getCriteria(0, $limit);
    // CRITERIA WITH AN ENTRY PERMISSION
    $criteria =& $entry_handler->entryPermCriteria($criteria);
    $criteria->setSort('published');
    $criteria->setOrder('DESC');
    $entries =& $entry_handler->getObjects($criteria);

    foreach($entries as $entry) {
        $item['title'] = xoops_convert_encoding(htmlspecialchars($entry->getVar('title', 'n'), ENT_QUOTES));
        $item['link'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid());
        $item['date'] = d3blog_iso8601_date($entry->published());
        // blogger's info
        $blogger = $entry->blogger();
        $item['creater'] = xoops_convert_encoding($blogger->getVar('uname'));
        $item['description'] = xoops_convert_encoding($entry->pingExcerpt());
        $items[] = $item;
    }

    $tpl->assign('channel', $feed);
    $tpl->assign('entries', $items);
    $tpl->assign('mydirname', $mydirname4show);
    $tpl->assign('mod_url', sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show));
}

header ('Content-Type:text/xml; charset=utf-8');
$tpl->display("db:{$mydirname}_main_rdf.xml");
?>
