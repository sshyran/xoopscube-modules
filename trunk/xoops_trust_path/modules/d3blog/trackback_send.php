<?php
/**
 * @version $Id: trackback_send.php 398 2008-03-26 02:20:50Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Copyrighted(c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

// session_start
require $mytrustdirpath.'/lib/session.php';
include_once XOOPS_ROOT_PATH.'/include/common.php';

// GET THIS MODULE HANDLER
require_once $mytrustdirpath.'/include/prepend.inc.php';

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php';
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' ) ;
require_once( $langmanpath ) ;
$langman =& D3LanguageManager::getInstance() ;
$langman->read( 'main.php' , $mydirname , $mytrustdirname );

require_once $mytrustdirpath.'/include/form/EntryEditForm.class.php';

$tb_handler =& $myModule->getHandler('trackback');

$form =& D3blogSession::get('entry_form');

if(!count($form->trackback_url_)) {
    if(empty($form->update_ping_)) {
        D3blogSession::unregister('entry_form');
        redirect_header('details.php?bid='.$form->bid_, 1, _MD_D3BLOG_MESSAGE_TRACKBACK_FINISHED_SUCCESSFULLY);
        exit;
    } else {
        redirect_header('update_ping.php', 1, _MD_D3BLOG_MESSAGE_TRACKBACK_FINISHED_SUCCESSFULLY);
        exit;
    }    
}

$trackback_urls = $form->trackback_url_;
foreach(array_keys($trackback_urls) as $key) {
    $url = $trackback_urls[$key];
    $url4show = htmlspecialchars($url, ENT_QUOTES);
    unset($form->trackback_url_[$key]);
    D3blogSession::register('entry_form', $form);

    if(!d3blog_validateUrl($url)) {
        redirect_header('trackback_send.php', 3, 'URL is invalid.<br />'.sprintf(_MD_D3BLOG_MESSAGE_TRACKBACK_FAILED, $url4show));
        exit;
    }

    $trackback = & $tb_handler->create();
    $trackback->setVar('bid', $form->bid_);
    $trackback->setVar('direction', 1);
    $trackback->setVar('approved', 1);
    $trackback->setVar('trackback_url', $url);
    $trackback->setVar('url', $url);
    $trackback->_data['url'] = xoops_convert_encoding($form->pingdata_['url']);
    $trackback->_data['title'] = xoops_convert_encoding($form->pingdata_['title']);
    $trackback->_data['blog_name'] = xoops_convert_encoding($form->pingdata_['blog_name']);
    $trackback->_data['excerpt'] = xoops_convert_encoding($form->pingdata_['excerpt']);
        
    // fetch and autodiscovery of trackback url
    if(!empty($form->autodiscovery_)) {
        if(!$trackback->autodiscover()) {
            redirect_header('trackback_send.php', 3, $trackback->getHtmlErrors().'<br />'.sprintf(_MD_D3BLOG_MESSAGE_AUTODISCOVERY_FAILED, $url4show));
            exit;
        }
    }

    if(!$trackback->send()) {
        redirect_header('trackback_send.php', 3, $trackback->getHtmlErrors().'<br />'.sprintf(_MD_D3BLOG_MESSAGE_TRACKBACK_FAILED, $url4show));
        exit;
    }

    // save a new trackback
    if(!$tb_handler->insert($trackback, true)) {
        d3blog_error(_MD_D3BLOG_MESSAGE_DB_TRACKBACK_FAILED);
    }
    unset($trackback);
    redirect_header('trackback_send.php', 1, sprintf(_MD_D3BLOG_MESSAGE_TRACKBACK_SUCCESS, $url));
    exit;
}    

?>