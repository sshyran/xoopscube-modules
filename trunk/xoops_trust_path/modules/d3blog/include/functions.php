<?php
/**
 * @version $Id: functions.php 517 2008-08-20 00:57:57Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Copyrighted(c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

if(!defined('D3BLOG_FUNCTIONS_DEFINED')) {
    define('D3BLOG_FUNCTIONS_DEFINED', '1');

    function d3blog_error($msg, $title='') {
        xoops_header();
        xoops_error($msg, $title);
        xoops_footer();
        exit;
    }

    function d3blog_encoding($text, $encoding) {
        if (XOOPS_USE_MULTIBYTES == 1) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($text, _CHARSET, $encoding);
            }
        }
        return $text;
    }

    function d3blog_iso8601_date($time) {
        $tzd  = date('O', $time);
        $tzd  = substr( chunk_split( $tzd, 3, ':' ), 0, 6 );
        $date = date('Y-m-d\TH:i:s', $time) . $tzd;
        return $date;
    }

    function d3blog_rfc2822_date($time) {
        return preg_replace("/\s\s+/", ' ', date('r', $time));
    }

    // for category imgurl box
    function d3blog_getCatImages($imagepath) {
        require_once XOOPS_ROOT_PATH.'/class/xoopslists.php';

        $images = array();

        if($imagepath) {
            return XoopsLists::getImgListAsArray( $imagepath );
        }
        return $images;
    }

    function d3blog_validateUrl($url) {
        $arr = parse_url( $url );
        if( $arr['scheme']=='http' && $arr['host'] && $arr['path'] ){
            return $arr;
        }else{
            return false ;
        }
    }

    function d3blog_responseSuccess () {
        $body = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<response>
<error>0</error>
</response>
EOD;
        $length = strlen($body) ;
        header ('Content-Type:text/xml');
        header ('Content-length: '.$length);
        return $body;
    }

    function d3blog_responseError($message, $code=1) {
        $body = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<response>
<error>%d</error>
<message>%s</message>
</response>
EOD;
        $body = sprintf($body, intval($code), htmlspecialchars($message, ENT_QUOTES));
        $length = strlen($body) ;
        header ('Content-Type:text/xml');
        header ('Content-length: '.$length);
        return $body;
    }

}
?>
