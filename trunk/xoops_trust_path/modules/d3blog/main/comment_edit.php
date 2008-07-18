<?php
/**
 * @version $Id: comment_edit.php 436 2008-05-13 15:20:04Z hodaka $
 */

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
$dohtml = $comment->getVar('dohtml');
$dosmiley = $comment->getVar('dosmiley');
$dobr = $comment->getVar('dobr');
$doxcode = $comment->getVar('doxcode');
$com_icon = $comment->getVar('com_icon');
$com_itemid = $comment->getVar('com_itemid');
$com_title = $comment->getVar('com_title', 'E');
$com_text = $comment->getVar('com_text', 'E');
$com_pid = $comment->getVar('com_pid');
$com_status = $comment->getVar('com_status');
$com_rootid = $comment->getVar('com_rootid');

$xoopsOption['template_main'] = $mydirname.'_main_comment_edit.html';
include XOOPS_ROOT_PATH.'/header.php';

$cat_handler = call_user_func(array($mydirname, 'getHandler'), 'category');
$bread = $cat_handler->getNicePathArrayFromId($com_itemid,
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, $mydirname)); 
$xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($bread));
array_push($xoops_breadcrumbs, array( 'name' => _MD_D3BLOG_LANG_EDIT_COMMENT, 'url' => '' )); 

$xoopsTpl->assign(array(
    'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
    'xoops_breadcrumbs' => $xoops_breadcrumbs,
    'xoops_pagetitle' => $myModule->module_name,
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mydirpath' => $mydirpath4show,
    'mytrustdirname' => $mytrustdirname4show,
    'mytrustdirpath' => $mytrustdirpath4show,
	'moduleConfig' => $myModule->module_config,
    'page_subtitle' => _MD_D3BLOG_LANG_EDIT_COMMENT
    )
);


include_once dirname(dirname(__FILE__)).'/include/comment_form.php';

include XOOPS_ROOT_PATH.'/footer.php';

?>