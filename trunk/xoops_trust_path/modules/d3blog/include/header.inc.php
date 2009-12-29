<?php
/**
 * @version $Id: header.inc.php 596 2009-05-17 16:37:13Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

// site breadcrumbs
$xoops_breadcrumbs[] = array('name'=>$myModule->module_name, 'url'=>sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname4show));

// remove trailing slash
$imagepath = preg_replace("|^(.+)/$|", "$1", $myModule->getConfig('categoryicon_path'));

// META HEADER
// feeder
$feeder['rss'] = sprintf('%s/modules/%s/index.php?page=rss', XOOPS_URL, $mydirname4show);
$feeder['rdf'] = sprintf('%s/modules/%s/index.php?page=rdf', XOOPS_URL, $mydirname4show);
$feeder['atom'] = sprintf('%s/modules/%s/index.php?page=atom', XOOPS_URL, $mydirname4show);

$meta_head = sprintf('<link rel="alternate" type="application/rss+xml" title="RSS2.0" href="%s" />', $feeder['rss'] );
$meta_head .= "\n".sprintf('<link rel="alternate" type="application/rdf+xml" title="RDF" href="%s" />', $feeder['rdf'] );
$meta_head .= "\n".sprintf('<link rel="alternate" type="application/atom+xml" title="ATOM" href="%s" />', $feeder['atom'] );
if($myModule->getConfig('dynamic_css')) {
    $meta_head .= "\n".sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s/modules/%s/index.php?page=css&amp;type=module" />', XOOPS_URL, $mydirname4show );
} else {
    $meta_head .= "\n".sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s/modules/%s/css/main_style.css" />', XOOPS_URL, $mydirname4show );
    $ieworkaround = <<<DOC_END
<!--[if IE]>
%s
<![endif]-->
DOC_END;
    $meta_head .= "\n".sprintf($ieworkaround, sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s/modules/%s/css/main_styleIE.css" />', XOOPS_URL, $mydirname4show ));
}

// figure handler
if($myModule->getConfig('figure_handler')) {
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/prototype.js"></script>', XOOPS_URL, $mydirname4show );
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/FigureHandler.js"></script>', XOOPS_URL, $mydirname4show );
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/d3blog.js"></script>', XOOPS_URL, $mydirname4show );
}

if($page == 'details' && $myModule->getConfig('trackback_ticket')) {
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/xmlhttp.js"></script>', XOOPS_URL, $mydirname4show );
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/tbkey.js"></script>', XOOPS_URL, $mydirname4show );
}

// WYSIWYG EDITOR
if($page == 'submit') {
    if($myModule->getConfig('wysiwyg_editor') == 1) {
        $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/common/fckeditor/fckeditor.js"></script>', XOOPS_URL );
        $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/fckexe.js"></script>', XOOPS_URL, $mydirname4show );
    } else {
        $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/quicktag.js"></script>', XOOPS_URL, $mydirname4show );
    }
}
/*
// comment
if($page == 'comment' || $page == 'details') {
    $meta_head .= "\n".sprintf('<script type="text/javascript" src="%s/modules/%s/js/comment.js"></script>', XOOPS_URL, $mydirname4show );
}*/

?>
