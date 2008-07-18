<?php
/**
 * @version $Id: update_ping.php 424 2008-04-18 05:29:28Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Copyrighted(c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

require $mytrustdirpath.'/lib/session.php';
include_once XOOPS_ROOT_PATH.'/include/common.php';

// GET THIS MODULE HANDLER
require_once $mytrustdirpath.'/include/prepend.inc.php';
$tb_handler =& $myModule->gethandler('trackback');

// language files
$langmanpath = XOOPS_TRUST_PATH.'/libs/altsys/class/D3LanguageManager.class.php';
if( ! file_exists( $langmanpath ) ) die( 'install the latest altsys' );
require_once( $langmanpath );
$langman =& D3LanguageManager::getInstance();
$langman->read( 'main.php' , $mydirname , $mytrustdirname ) ;

require_once $mytrustdirpath.'/include/form/EntryEditForm.class.php';
// session_start
$form =& D3blogSession::get('entry_form');

if(empty($form->updateping_urls_)) {
    D3blogSession::unregister('entry_form');
    redirect_header('details.php?bid='.$form->bid_, 1, _MD_D3BLOG_MESSAGE_NOW_FINISHING);
    exit;
}

$trackback = $tb_handler->create();
$trackback->setVar('url', $form->pingdata_['blog_topurl']);
$trackback->setVar('blog_name', $form->pingdata_['blog_name']);

foreach(array_keys($form->updateping_urls_) as $key) {
    $svr = htmlspecialchars($form->updateping_urls_[$key], ENT_QUOTES);
    unset($form->updateping_urls_[$key]);
    D3blogSession::register('entry_form', $form);
    if(!$parsed_url = d3blog_validateUrl($svr)) {
        redirect_header('update_ping.php', 1, sprintf(_MD_D3BLOG_MESSAGE_UPDATEPING_FAILED, $svr));
        exit;
    } else {           
        if(!$trackback->sendWeblogUpdateping($parsed_url, 10)) {
            redirect_header('update_ping.php', 1, sprintf(_MD_D3BLOG_MESSAGE_UPDATEPING_FAILED, $svr));
            exit;
        } else {
            redirect_header('update_ping.php', 1, sprintf(_MD_D3BLOG_MESSAGE_UPDATEPING_SUCCESS, $svr));
            exit;
        }
    }
}

?>