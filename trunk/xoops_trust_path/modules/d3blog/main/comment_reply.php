<?php
/**
 * @version $Id: comment_reply.php 436 2008-05-13 15:20:04Z hodaka $
 */

if (XOOPS_COMMENT_APPROVENONE == $myModule->getConfig('com_rule')) {
    exit();
}

if(!is_object($xoopsUser) && $myModule->getConfig('com_anonpost') != 1) {
    exit();
}

include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/comment.php';

$com_id = isset($_GET['com_id']) ? intval($_GET['com_id']) : 0;
$com_mode = isset($_GET['com_mode']) ? htmlspecialchars(trim($_GET['com_mode']), ENT_QUOTES) : '';
if ($com_mode == '') {
    if (is_object($xoopsUser)) {
        $com_mode = $xoopsUser->getVar('umode');
    } else {
        $com_mode = $xoopsConfig['com_mode'];
    }
}
if (!isset($_GET['com_order'])) {
    if (is_object($xoopsUser)) {
        $com_order = $xoopsUser->getVar('uorder');
    } else {
        $com_order = $xoopsConfig['com_order'];
    }
} else {
    $com_order = intval($_GET['com_order']);
}
$comment_handler =& xoops_gethandler('comment');
$comment =& $comment_handler->get($com_id);
$r_name = XoopsUser::getUnameFromId($comment->getVar('com_uid'));
$r_head = _CM_POSTER.': <strong>'.$r_name.'</strong>&nbsp;&nbsp;'._CM_POSTED.': <strong>'.formatTimestamp($comment->getVar('com_created')).'</strong>';
$r_text = $comment->getVar('com_text');
$com_title = $comment->getVar('com_title', 'E');
if (!preg_match("/^re:/i", $com_title)) {
    $com_title = "Re: ".xoops_substr($com_title, 0, 56);
}
$com_pid = $com_id;
$com_text = '';
$com_id = 0;
$dosmiley = 1;
$dohtml = 0;
$doxcode = 1;
$dobr = 1;
$doimage = 1;
$com_icon = '';
$com_rootid = $comment->getVar('com_rootid');
$com_itemid = $comment->getVar('com_itemid');

$xoopsOption['template_main'] = $mydirname.'_main_comment_edit.html';
include XOOPS_ROOT_PATH.'/header.php';

$cat_handler = call_user_func(array($mydirname, 'getHandler'), 'category');
$bread = $cat_handler->getNicePathArrayFromId($com_itemid,
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, htmlspecialchars($mydirname, ENT_QUOTES))); 
$xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($bread));
array_push($xoops_breadcrumbs, array( 'name' => _MD_D3BLOG_LANG_REPLY_TO_COMMENT, 'url' => '' )); 

$xoopsTpl->assign(array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => $myModule->module_name,
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => _MD_D3BLOG_LANG_REPLY_TO_COMMENT,
    'confer_comment' => array('title'=>$comment->getVar('com_title'), 'head'=>$r_head, 'text'=>$r_text)
    )
);

include_once dirname(dirname(__FILE__)).'/include/comment_form.php';

include XOOPS_ROOT_PATH.'/footer.php';

?>