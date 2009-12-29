<?php
/**
 * @version $Id: submit.php 555 2008-12-07 12:52:14Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

// check if user has perm
if(!$currentUser->blog_perm_edit())
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1,_MD_D3BLOG_ERROR_NO_PERM_FOR_POST);

require_once dirname(dirname(__FILE__)).'/include/gticket.php';
require_once dirname(dirname(__FILE__)).'/include/form/EntryEditForm.class.php';
require $mytrustdirpath.'/lib/session.php';
$xoopsGTicket = new xoopsGTicket();

$bid = isset($_REQUEST['bid']) ? intval($_REQUEST['bid']) : 0;

$entry_handler =& $myModule->getHandler('entry');
$myts =& d3blogTextSanitizer::getInstance();

/**************************/
/***** delete section *****/
/**************************/
// if 'delete the entry' requested
if(isset($_POST['confirm_delete'])) {
    // check ticket
    if (!$xoopsGTicket->check(true,'d3blog_admin'))
        die($xoopsGTicket->getErrors());

    // check if entry exists
    $obj = $entry_handler->get($bid);
    if(!is_object($obj))
        redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1,_MD_D3BLOG_ERROR_NO_SUCH_ENTRY);

    // check if user has permission for edit others
    if(!$currentUser->isEditor() && $obj->uid() != $currentUser->uid())
        redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1,_MD_D3BLOG_ERROR_NO_PERM_FOR_EDIT_OTHERS);

    // finally delete
    if($entry_handler->delete($obj)) {
        redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, sprintf(_MD_D3BLOG_MESSAGE_DB_DELETE_SUCCESS, $obj->title()));
        exit;
    } else {
        d3blog_error(sprintf(_MD_D3BLOG_ERROR_DB_DELETE_FAILURE, $obj->title()));
    }
}

/********************************************/
/***** post/edit/preview action section *****/
/********************************************/
$entry = $entry_handler->get($bid);

if(!is_object($entry)) {
    // reject no such entry
    if($bid > 0)
        redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1,_MD_D3BLOG_ERROR_NO_SUCH_ENTRY);

    $entry =& $entry_handler->create();
    // set default values
    $entry->setDefault($currentUser);
}

// check if has permission for edit others
if(!$currentUser->isEditor() && $entry->uid() != $currentUser->uid())
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1,_MD_D3BLOG_ERROR_NO_PERM_FOR_EDIT_OTHERS);

// ACTION FORM
$editform = new EntryEditForm($mydirname);

// fetch or load
$init = $editform->init($entry);

switch($init) {
case MYACTIONFORM_POST_SUCCESS:
    // in case DELETE
    if(isset($_POST['delete']))
        break;

    $editform->update($entry);

    // in case PREVIEW
    if(isset($_POST['preview']))
        break;

    if(!$entry_handler->insert($entry))
        d3blog_error(sprintf(_MD_D3BLOG_ERROR_DB_UPDATE_FAILURE, $entry->title()));

    // APPROVE AND NOTIFICATION
    if(!$entry->update($editform))
        d3blog_error(sprintf(_MD_D3BLOG_ERROR_DB_UPDATE_FAILURE, $entry->title()));

    $editform->pingdata($entry);
    
    // check if trackback ping requested
    $trackback_urls = array();
    if(!empty($editform->trackback_url_) && $editform->approved_) {
        $trackback_url = preg_split("/[\s]+/", $editform->trackback_url_);
        $trackback_url = array_unique($trackback_url);
        foreach($trackback_url as $url) {
            if(!d3blog_validateUrl($url)) {
                continue;
            } elseif(isset($editform->tb_url_) && in_array($url, $editform->tb_url_)) {
                continue;
            } else {
                $trackback_urls[] = $url;
            }
        }
    }
    $editform->trackback_url_ = $trackback_urls;
    
    // check if update ping requested
    $updateping_urls = array();
    if(!empty($editform->update_ping_)) {
        if(!$myModule->getConfig('url_by_entry')) {
            $updateping_urls = preg_split("/[\s]+/", $myModule->getConfig('updateping_url'));
        } else {
            $u = 0;
            foreach($form->updateping_urls_ as $url) {
                $max_urls = $myModule->getConfig('max_urls')? intval($myModule->getConfig('max_urls')) : 0;
                if(!empty($url['selected']) && $u < $max_urls) {
                    $updateping_urls[] = $url['url'];
                    $u++;   
                }   
            }
        }
    }
    $editform->updateping_urls_ = $updateping_urls;

    // SEND TRACKBACK PING
    if(count( $trackback_urls)) {
        D3blogSession::register('entry_form', $editform);
        $message = _MD_D3BLOG_MESSAGE_ENTRY_POSTED_SUCCESSFULLY."<br /><br />";
        $message .= _MD_D3BLOG_MESSAGE_STARTING_TRACKBACK;
        redirect_header('trackback_send.php', 1, $message);
        exit;
    }
    // SEND UPDATE PING
    if(count( $updateping_urls)) {
        D3blogSession::register('entry_form', $editform);
        $message = _MD_D3BLOG_MESSAGE_ENTRY_POSTED_SUCCESSFULLY."<br /><br />";
        $message .= _MD_D3BLOG_MESSAGE_STARTING_UPDATEPING;
        redirect_header('update_ping.php', 1, $message);
        exit;
    }

    // final        
    if($entry->isApproved())
        $rmsg = _MD_D3BLOG_MESSAGE_ENTRY_POSTED_SUCCESSFULLY;
    else
        $rmsg = _MD_D3BLOG_MESSAGE_WAIT_UNTIL_ENTRY_APPROVED_BY_ADMIN;

    redirect_header(XOOPS_URL."/modules/$mydirname/details.php?bid=".$entry->bid(), 1, $rmsg);
    exit;

    break;

case MYACTIONFORM_INIT_FAIL:
    $editform->update($entry);
    break;

case MYACTIONFORM_INIT_SUCCESS:
default:
    break;
}

/***************************/
/***** listing section *****/
/***************************/
// for category box
$cat_handler =& $myModule->getHandler('category');
$criteria =& $cat_handler->getDefaultCriteria();
$categories =& $cat_handler->getChildTreeArray();

// trackback
$tb_handler =& $myModule->getHandler('trackback' );
$trackback = $tb_handler->getTrackback($bid);

// breadcrumbs
$xoops_breadcrumbs[] = array('name'=>_MD_D3BLOG_LANG_POST_ENTRY, 'url'=>'');

// for group list
$member_handler =& xoops_gethandler('member');
$currentUser4show =& $currentUser->getStructure();
$currentUser4show['user_perm'] =& $currentUser->_userPerm[$myModule->module_id]->getArray();

$xoopsOption['template_main'] = $mydirname.'_main_submit.html';
// Include the page header
include(XOOPS_ROOT_PATH.'/header.php');

$xoopsTpl->assign( array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => _MD_D3BLOG_LANG_POST_ENTRY
    )
);

$xoopsTpl->assign( array(
    'form_error' => ($init==MYACTIONFORM_INIT_FAIL)? $editform->getHtmlErrors() : '',
    'mymid' => $myModule->module_id,
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mydirpath' => $mydirpath4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => _MD_D3BLOG_LANG_POST_ENTRY,
    'isSubmit' => 1,
    'isError' => ($init==MYACTIONFORM_INIT_FAIL)? 1 : 0,
    'isPreview' => isset($_POST['preview'])? 1 : 0,
    'isDelete' => isset($_POST['delete'])? 1 : 0,
    'categorypath' => $cat_handler->getNicePathArrayFromId($entry->cid(), XOOPS_URL."/modules/$mydirname/index.php"),
    'currentUser' => $currentUser4show,
    'groupList' => $member_handler->getGroupList(),
    'categories' => $categories,
    'entry' => $entry->getStructure(),
    'form' => get_object_vars($editform),
    'images' => d3blog_getCatImages($imagepath),
    'imagepath' => str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $imagepath),
    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , $myModule->getConfig('ticket_lifetime')*60 , 'd3blog_admin') )
);

// Include the page footer
include(XOOPS_ROOT_PATH.'/footer.php');

?>
