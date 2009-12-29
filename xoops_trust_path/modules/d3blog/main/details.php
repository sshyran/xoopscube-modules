<?php
/**
 * @version $Id: details.php 480 2008-06-16 05:59:27Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

//$currentUser->_userCookie = new myXoopsUserCookie();
//$currentUser->_userCookie->getCookie($mydirname.'_user');

// check if user has perm
if(!$currentUser->blog_perm_view()) {
    redirect_header(XOOPS_URL.'/index.php', 1, _MD_D3BLOG_ERROR_NO_PERM_FOR_VIEW);
    exit();
}

// obtain GET parameters
$bid = !empty($_GET['bid']) ? intval($_GET['bid']) : 0;

// obtain class instances
$myts =& MyTextSanitizer::getInstance();
$cat_handler =& $myModule->getHandler('category');
$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');

// CRITERIA WITH AN ENTRY PERMISSION
$criteria =& $entry_handler->getCriteria();
$criteria =& $entry_handler->entryPermCriteria($criteria);

if(!$criteria) {
    $ermsg = $entry_handler->result_message_;
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, $ermsg);
}

// fetch blog details
$criteria->add(new Criteria('bid', $bid));
$entry = $entry_handler->getOne($criteria, true);
if(!$entry) {
    if(!empty($entry_handler->filter_->extra_uri_)) {
        if(ereg("cid", $entry_handler->filter_->extra_uri_))
            $exp = sprintf(_MD_D3BLOG_MESSAGE_YOU_CHOICED, _MD_D3BLOG_LANG_CATEGORY);
        elseif(ereg("uid", $entry_handler->filter_->extra_uri_))
            $exp = sprintf(_MD_D3BLOG_MESSAGE_YOU_CHOICED, _MD_D3BLOG_LANG_PUBLISH_DATE);
        elseif(ereg("date", $entry_handler->filter_->extra_uri_))
            $exp = sprintf(_MD_D3BLOG_MESSAGE_YOU_CHOICED, _MD_D3BLOG_LANG_BLOGGER_NAME);
    } else {
        $exp = sprintf(_MD_D3BLOG_MESSAGE_YOU_CHOICED, _MD_D3BLOG_LANG_BLOG_ID);
    }  
    redirect_header(sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname), 1, sprintf(_MD_D3BLOG_MESSAGE_SORRY_WAIT_UNTILL_PUBLISHED, $exp));
    exit();
}

$entry_array =& $entry->getStructure();

// obtain trackback
$entry_array['trackback'] = $tb_handler->getTrackback($bid);

// count up view counter
if(empty($_GET['com_id'])) {
    if($myModule->getConfig('increment_by_owner') || $entry->uid() != $currentUser->uid()) {
        $entry->incrementViewCounter();
    }
}

$xoopsOption['template_main'] = $mydirname.'_main_details.html';

// Include the page header
include(XOOPS_ROOT_PATH.'/header.php');

// BREADCRUMBS and PAGE TITLE
if(!isset($entry_handler->filter_->breadcrumb_info_)) {
    $entry_handler->filter_->breadcrumb_info_ = $cat_handler->getNicePathArrayFromId($entry->cid(),
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname4show)); 
    $entry_handler->filter_->subtitle_ = $entry->title();
}
$xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($entry_handler->filter_->breadcrumb_info_));
// and current page
array_push($xoops_breadcrumbs, array( 'name' => $entry->title(), 'url' => '' )); 

$bloggers =& myPerm::getMembersByName('blog_perm_edit');
$currentUser4show =& $currentUser->getStructure();
$currentUser4show['user_perm'] =& $currentUser->_userPerm[$myModule->module_id]->getArray();

// WHAT'S FEEDER
if(count($entry_handler->filter_->feeder_)) {
    if(!isset($entry_handler->filter_->uid_) || count($bloggers) > 1) {
//        array_walk($feeder, create_function('&$v,$k', '$v = $v . "'.$entry_handler->filter_->feeder_['uri'].'";'));
        $feeder['what_feeder']['uri'] = $entry_handler->filter_->feeder_['uri'];
        $feeder['what_feeder']['lang'] = $entry_handler->filter_->feeder_['lang'];
    }
}

$xoopsTpl->assign( array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => $entry_handler->filter_->subtitle_
    )
);
$xoopsTpl->assign( array(
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mydirpath' => $mydirpath4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => $entry_handler->filter_->subtitle_,
    'feeder' => $feeder,
    'isDetails' => 1,
    'currentUser' => $currentUser4show,
    'bloggers' => count($bloggers),
    'entry' => $entry_array,
    'imagepath' => htmlspecialchars(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $imagepath), ENT_QUOTES),
    'images' => d3blog_getCatImages($imagepath),
    'backandforth' => $entry_handler->getBackandforth($entry)
    )
);

/*if($myModule->getConfig('d3blog_comment_system')) {
    if($currentUser->com_perm_view()) {
        // cookie
        if($currentUser->isGuest()) {
            $currentUser->_userCookie = new myXoopsUserCookie();
            $currentUser->_userCookie->getCookie();
        }
        
        // show comments received
        $com_handler =& $myModule->getHandler('comment');
        $comments = $com_handler->getByEntry($entry->bid());

        if($entry->canReadBody()) {
            $xoopsTpl->assign( array(
                'com_count' => $comments['count'],
                'comments' => $comments['thread']
                )
            );
        }
        if($currentUser->com_perm_edit()) {
            // show comment form
            require $mytrustdirpath.'/include/d3blog_comment_new.php';
        }
    }
} else {
    // Include the commenting module
    require XOOPS_ROOT_PATH.'/include/comment_view.php';
}*/

//include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
if (XOOPS_COMMENT_APPROVENONE != $myModule->getConfig('com_rule')) {
    // show comment form
    include_once dirname(dirname(__FILE__))."/include/comment_new.php";
    // show comments received
    require dirname(dirname(__FILE__)).'/include/comment_view.php';
}

include(XOOPS_ROOT_PATH.'/footer.php');

?>
