<?php
/**
 * @version $Id: blocks.php 419 2008-04-10 02:35:26Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirpath = dirname( __FILE__ );

require $mytrustdirpath.'/include/prepend.inc.php';

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php' ;
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'blocks_common.php' , $mydirname , $mytrustdirname ) ;
$langman->read( 'blocks_each.php' , $mydirname , $mytrustdirname , false ) ;

if(!defined('D3BLOG_BLOCK_FUNCTIONS_DEFINED')) {
    define('D3BLOG_BLOCK_FUNCTIONS_DEFINED', 1);	
    // include all block files
    $block_path = $mytrustdirpath.'/blocks' ;

    if( $handler = @opendir( $block_path . '/' ) ) {
        while( ( $file = readdir( $handler ) ) !== false ) {
            if( substr( $file , 0 , 1 ) == '.' ) continue ;
            $file_path = $block_path . '/' . $file ;
            if( is_file( $file_path ) && substr( $file , -4 ) == '.php' ) {
                include_once $file_path ;
            }
        }
    }
}

if(!isset($_GET['mode']) || $_GET['mode'] != 'admin') {
    // assign block_header
    global $xoopsTpl;
    if($myModule->getConfig('dynamic_css')) {
        $metalink = "\n".sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s/modules/%s/index.php?page=css&amp;type=block" />'."\n" , XOOPS_URL , $mydirname4show );
        $xoopsTpl->assign('xoops_module_header',$xoopsTpl->get_template_vars('xoops_module_header').$metalink);
    } else {
        $css_file_name = 'block_style.css';
        $css_file_url = XOOPS_URL.'/modules/'.$mydirname4show.'/css/'.$css_file_name;
        $css_file_path = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/css/'.$css_file_name;
        $iecss_file_name = 'block_styleIE.css';
        $iecss_file_url = XOOPS_URL.'/modules/'.$mydirname4show.'/css/'.$iecss_file_name;
        $iecss_file_path = XOOPS_ROOT_PATH.'/modules/'.$mydirname.'/css/'.$iecss_file_name;
        if(is_file($css_file_path)) {
            $metalink = "\n".sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s" />', $css_file_url)."\n";
            if(is_file($iecss_file_path)) {
                $ieworkaround = <<<DOC_END
<!--[if IE]>
%s
<![endif]-->
DOC_END;
                $metalink .= "\n".sprintf($ieworkaround, sprintf('<link rel="stylesheet" type="text/css" media="all" href="%s" />' , $iecss_file_url));
                
            }
            $xoopsTpl->assign('xoops_module_header', $xoopsTpl->get_template_vars('xoops_module_header').$metalink);
        }
    }
}
?>