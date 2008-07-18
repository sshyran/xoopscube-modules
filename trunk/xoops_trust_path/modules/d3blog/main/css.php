<?php
/**
 *  @version $Id: css.php 281 2008-02-23 09:49:31Z hodaka $
 *  @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! headers_sent() ) {
    $cache_limit = intval($myModule->getConfig('meta_cachetime'))*60 ;

    session_cache_limiter('public');
    header("Expires: ".date('r', intval(time()/$cache_limit)*$cache_limit+$cache_limit));
    header("Cache-Control: public, max-age=$cache_limit");
    header("Last-Modified: ".date('r',intval(time()/$cache_limit)*$cache_limit));

    // send header
    header('Content-Type: text/css');
    $matches = array();
    if(ini_get('zlib.output_compression') && preg_match('/\b(gzip|deflate)\b/i', $_SERVER['HTTP_ACCEPT_ENCODING'], $matches)) {
        header('Content-Encoding: ' . $matches[1]);
        header('Vary: Accept-Encoding');
    }
}

require_once(XOOPS_ROOT_PATH.'/class/template.php');

// type
$type = isset($_GET['type'])? $_GET['type'] : '';

// Media
$media   = isset($_GET['media'])   ? $_GET['media']    : '';
if ($media != 'print') $media = 'screen';

// browser
$agent = stristr( $_SERVER['HTTP_USER_AGENT'] , 'MSIE' )? 'IE' : '';

$tpl = new XoopsTpl();

$tpl->assign('agent', $agent);
$tpl->assign('xoops_url', XOOPS_URL);
$tpl->assign('mod_url', sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show));
$tpl->assign('mydirname', $mydirname4show);
$tpl->assign('mytrustdirname', $mytrustdirname4show);

if($type == 'module') {
    $tpl->display("db:{$mydirname}_main_style.css");
    if($agent == 'IE') {
        $tpl->display("db:{$mydirname}_main_styleIE.css");
    }
} elseif($type == 'block') {
    $tpl->display("db:{$mydirname}_block_style.css");
    if($agent == 'IE') {
        $tpl->display("db:{$mydirname}_block_styleIE.css");
    }
}
exit;

?>