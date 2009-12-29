<?php
/**
 * @version $Id: comment_post.php 475 2008-06-14 16:11:12Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(__FILE__)).'/include/comment_functions.php';
//require_once XOOPS_ROOT_PATH.'/include/comment_post.php';

include_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig['language'].'/comment.php';
include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';

$com_id = isset($_POST['com_id']) ? intval($_POST['com_id']) : 0;
$extra_params = '';

if (XOOPS_COMMENT_APPROVENONE == $xoopsModuleConfig['com_rule']) {
    exit();
}
if(!is_object($xoopsUser) && $xoopsModuleConfig['com_anonpost'] != 1) {
    exit();
}
$comment_config = $xoopsModule->getInfo('comments');
$com_modid = $xoopsModule->getVar('mid');
$redirect_page = $comment_config['pageName'].'?';
if (isset($comment_config['extraParams']) && is_array($comment_config['extraParams'])) {
    $myts =& MyTextSanitizer::getInstance();
    foreach ($comment_config['extraParams'] as $extra_param) {
        $extra_params .= isset($_POST[$extra_param]) ? $extra_param.'='.$myts->stripSlashesGPC($_POST[$extra_param]).'&amp;' : $extra_param.'=&amp;';
    }
    $redirect_page .= $extra_params;
}
$redirect_page .= $comment_config['itemName'];
$comment_url = $redirect_page;
$moddir = $xoopsModule->getVar('dirname');

$op = '';
if (!empty($_POST)) {

    if (isset($_POST['com_dopost'])) {
        $op = 'post';
    } elseif (isset($_POST['com_dopreview'])) {
        $op = 'preview';
    }
    if (isset($_POST['com_dodelete'])) {
        $op = 'delete';
    }

    $com_mode = isset($_POST['com_mode']) ? htmlspecialchars(trim($_POST['com_mode']), ENT_QUOTES) : 'flat';
    $com_order = isset($_POST['com_order']) ? intval($_POST['com_order']) : XOOPS_COMMENT_OLD1ST;
    $com_itemid = isset($_POST['com_itemid']) ? intval($_POST['com_itemid']) : 0;
    $com_pid = isset($_POST['com_pid']) ? intval($_POST['com_pid']) : 0;
    $com_rootid = isset($_POST['com_rootid']) ? intval($_POST['com_rootid']) : 0;
    $com_status = isset($_POST['com_status']) ? intval($_POST['com_status']) : 0;
    $dosmiley = (isset($_POST['dosmiley']) && intval($_POST['dosmiley']) > 0) ? 1 : 0;
    $doxcode = (isset($_POST['doxcode']) && intval($_POST['doxcode']) > 0) ? 1 : 0;
    $dobr = (isset($_POST['dobr']) && intval($_POST['dobr']) > 0) ? 1 : 0;
    $dohtml = (isset($_POST['dohtml']) && intval($_POST['dohtml']) > 0) ? 1 : 0;
    $doimage = (isset($_POST['doimage']) && intval($_POST['doimage']) > 0) ? 1 : 0;
    $com_icon = isset($_POST['com_icon']) ? trim($_POST['com_icon']) : '';
    $noname = isset($_POST['noname']) ? intval($_POST['noname']) : 0;
} else {
    exit();
}

switch ( $op ) {

case "delete":
    include XOOPS_ROOT_PATH.'/include/comment_delete.php';
    break;
case "preview":
    $myts =& MyTextSanitizer::getInstance();
    $doimage = 1;
    $com_title = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['com_title']));
    if ($dohtml != 0) {
        if (is_object($xoopsUser)) {
            if (!$xoopsUser->isAdmin($com_modid)) {
                $sysperm_handler =& xoops_gethandler('groupperm');
                if (!$sysperm_handler->checkRight('system_admin', XOOPS_SYSTEM_COMMENT, $xoopsUser->getGroups())) {
                    $dohtml = 0;
                }
            }
        } else {
            $dohtml = 0;
        }
    }
    $p_comment =& $myts->previewTarea($_POST['com_text'], $dohtml, $dosmiley, $doxcode, $doimage, $dobr);
    $com_text = $myts->htmlSpecialChars($myts->stripSlashesGPC($_POST['com_text']));

    $xoopsOption['template_main'] = $mydirname.'_main_comment_edit.html';
    include XOOPS_ROOT_PATH.'/header.php';

    $cat_handler = call_user_func(array($mydirname, 'getHandler'), 'category');
    $bread = $cat_handler->getNicePathArrayFromId($com_itemid,
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, htmlspecialchars($mydirname, ENT_QUOTES))); 
    $xoops_breadcrumbs = array_merge($xoops_breadcrumbs, array_reverse($bread));
    array_push($xoops_breadcrumbs, array( 'name' => _MD_D3BLOG_LANG_PREVIEW_COMMENT, 'url' => '' )); 

    $xoopsTpl->assign(array(
        'xoops_module_header' => $meta_head.$xoopsTpl->get_template_vars('xoops_module_header'),
        'xoops_breadcrumbs' => $xoops_breadcrumbs,
        'xoops_pagetitle' => $myModule->module_name,
        'myname' => $myModule->module_name,
        'mydirname' => $mydirname4show,
        'mytrustdirpath' => $mytrustdirpath4show,
        'moduleConfig' => $myModule->module_config,
        'page_subtitle' => _MD_D3BLOG_LANG_PREVIEW_COMMENT,
        'preview_comment' => array('title'=>$com_title, 'text'=>$p_comment)
        )
    );

    include_once dirname(dirname(__FILE__)).'/include/comment_form.php';
    include XOOPS_ROOT_PATH.'/footer.php';
    break;
case "post":
    $doimage = 1;
    $comment_handler =& xoops_gethandler('comment');
    $add_userpost = false;
    $call_approvefunc = false;
    $call_updatefunc = false;
    // RMV-NOTIFY - this can be set to 'comment' or 'comment_submit'
    $notify_event = false;
    if (!empty($com_id)) {
        $comment =& $comment_handler->get($com_id);
        $accesserror = false;

        if (is_object($xoopsUser)) {
            $sysperm_handler =& xoops_gethandler('groupperm');
            if ($xoopsUser->isAdmin($com_modid) || $sysperm_handler->checkRight('system_admin', 14/*XOOPS_SYSTEM_COMMENT*/, $xoopsUser->getGroups())) {
                if (!empty($com_status) && $com_status != XOOPS_COMMENT_PENDING) {
                    $old_com_status = $comment->getVar('com_status');
                    $comment->setVar('com_status', $com_status);
                    // if changing status from pending state, increment user post
                    if (XOOPS_COMMENT_PENDING == $old_com_status) {
                        $add_userpost = true;
                        if (XOOPS_COMMENT_ACTIVE == $com_status) {
                            $call_updatefunc = true;
                            $call_approvefunc = true;
                            // RMV-NOTIFY
                            $notify_event = 'comment';
                        }
                    } elseif (XOOPS_COMMENT_HIDDEN == $old_com_status && XOOPS_COMMENT_ACTIVE == $com_status) {
                        $call_updatefunc = true;
                        // Comments can not be directly posted hidden,
                        // no need to send notification here
                    } elseif (XOOPS_COMMENT_ACTIVE == $old_com_status && XOOPS_COMMENT_HIDDEN == $com_status) {
                        $call_updatefunc = true;
                    }
                }
            } else {
                $dohtml = 0;
                if ($comment->getVar('com_uid') != $xoopsUser->getVar('uid')) {
                    $accesserror = true;
                }
            }
        } else {
            $dohtml = 0;
            $accesserror = true;
        }
        if (false != $accesserror) {
            redirect_header($redirect_page.'='.$com_itemid.'&amp;com_id='.$com_id.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order, 1, _NOPERM);
            exit();
        }
    } else {
        $comment = $comment_handler->create();
        $comment->setVar('com_created', time());
        $comment->setVar('com_pid', $com_pid);
        $comment->setVar('com_itemid', $com_itemid);
        $comment->setVar('com_rootid', $com_rootid);
        $comment->setVar('com_ip', xoops_getenv('REMOTE_ADDR'));
        if (is_object($xoopsUser)) {
            $sysperm_handler =& xoops_gethandler('groupperm');
            if ($xoopsUser->isAdmin($com_modid) || $sysperm_handler->checkRight('system_admin', 14/*XOOPS_SYSTEM_COMMENT*/, $xoopsUser->getGroups())) {
                $comment->setVar('com_status', XOOPS_COMMENT_ACTIVE);
                $add_userpost = true;
                $call_approvefunc = true;
                $call_updatefunc = true;
                // RMV-NOTIFY
                $notify_event = 'comment';
            } else {
                $dohtml = 0;
                switch ($xoopsModuleConfig['com_rule']) {
                case XOOPS_COMMENT_APPROVEALL:
                case XOOPS_COMMENT_APPROVEUSER:
                    $comment->setVar('com_status', XOOPS_COMMENT_ACTIVE);
                    $add_userpost = true;
                    $call_approvefunc = true;
                    $call_updatefunc = true;
                    // RMV-NOTIFY
                    $notify_event = 'comment';
                    break;
                case XOOPS_COMMENT_APPROVEADMIN:
                default:
                    $comment->setVar('com_status', XOOPS_COMMENT_PENDING);
                    $notify_event = 'comment_submit';
                    break;
                }
            }
            if (!empty($xoopsModuleConfig['com_anonpost']) && !empty($noname)) {
                $uid = 0;
            } else {
                $uid = $xoopsUser->getVar('uid');
            }
        } else {
            $dohtml = 0;
            $uid = 0;
            if ($xoopsModuleConfig['com_anonpost'] != 1) {
                redirect_header($redirect_page.'='.$com_itemid.'&amp;com_id='.$com_id.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order, 1, _NOPERM);
                exit();
            }
        }
        if ($uid == 0) {
            switch ($xoopsModuleConfig['com_rule']) {
            case XOOPS_COMMENT_APPROVEALL:
                $comment->setVar('com_status', XOOPS_COMMENT_ACTIVE);
                $add_userpost = true;
                $call_approvefunc = true;
                $call_updatefunc = true;
                // RMV-NOTIFY
                $notify_event = 'comment';
                break;
            case XOOPS_COMMENT_APPROVEADMIN:
            case XOOPS_COMMENT_APPROVEUSER:
            default:
                $comment->setVar('com_status', XOOPS_COMMENT_PENDING);
                // RMV-NOTIFY
                $notify_event = 'comment_submit';
                break;
            }
        }
        $comment->setVar('com_uid', $uid);
    }
// in case no Japanese letters in a title or a text body
/*  $pattern = '/((?:\xA4[\xA1-\xF3])+|(?:\xA5[\xA1-\xF6])+|(?:[\xB0-\xF4][\x00-\xFF])+)/x'; // Hiragana Katakana Kanji
    $match_title = $match_text = '';
    if(preg_match_all($pattern, $_POST['com_title'], $matches1)) {
        $match_title .= join("", $matches1[1]);
    }
    if(preg_match_all($pattern, $_POST['com_text'], $matches2)) {
        $match_text .= join("", $matches2[1]);
    }
    if(strlen($match_title) < 2 || strlen($match_text) < 6) {
        include XOOPS_ROOT_PATH.'/header.php';
        xoops_error('No Japanese words. We believe your post is spam.');
        include XOOPS_ROOT_PATH.'/footer.php';
        exit();
    }*/
// hodaka end

    $com_title = xoops_trim($_POST['com_title']);
    $com_title = ($com_title == '') ? _NOTITLE : $com_title;
    $comment->setVar('com_title', $com_title);
    $comment->setVar('com_text', $_POST['com_text']);
    $comment->setVar('dohtml', $dohtml);
    $comment->setVar('dosmiley', $dosmiley);
    $comment->setVar('doxcode', $doxcode);
    $comment->setVar('doimage', $doimage);
    $comment->setVar('dobr', $dobr);
    $comment->setVar('com_icon', $com_icon);
    $comment->setVar('com_modified', time());
    $comment->setVar('com_modid', $com_modid);
    if (!empty($extra_params)) {
        $comment->setVar('com_exparams', str_replace('&amp;', '&', $extra_params));
    }
    if (false != $comment_handler->insert($comment)) {
        $newcid = $comment->getVar('com_id');

        // set own id as root id if this is a top comment
        if ($com_rootid == 0) {
            $com_rootid = $newcid;
            if (!$comment_handler->updateByField($comment, 'com_rootid', $com_rootid)) {
                $comment_handler->delete($comment);
                include XOOPS_ROOT_PATH.'/header.php';
                xoops_error();
                include XOOPS_ROOT_PATH.'/footer.php';
            }
        }

        // call custom approve function if any
        if (false != $call_approvefunc && isset($comment_config['callback']['approve']) && trim($comment_config['callback']['approve']) != '') {
            $skip = false;
            if (!function_exists($comment_config['callback']['approve'])) {
                if (isset($comment_config['callbackFile'])) {
                    $callbackfile = trim($comment_config['callbackFile']);
                    if ($callbackfile != '' && file_exists(XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile)) {
                        include_once XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile;
                    }
                    if (!function_exists($comment_config['callback']['approve'])) {
                        $skip = true;
                    }
                } else {
                    $skip = true;
                }
            }
            if (!$skip) {
                $comment_config['callback']['approve']($comment);
            }
        }

        // call custom update function if any
        if (false != $call_updatefunc && isset($comment_config['callback']['update']) && trim($comment_config['callback']['update']) != '') {
            $skip = false;
            if (!function_exists($comment_config['callback']['update'])) {
                if (isset($comment_config['callbackFile'])) {
                    $callbackfile = trim($comment_config['callbackFile']);
                    if ($callbackfile != '' && file_exists(XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile)) {
                        include_once XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile;
                    }
                    if (!function_exists($comment_config['callback']['update'])) {
                        $skip = true;
                    }
                } else {
                    $skip = true;
                }
            }
            if (!$skip) {
                $criteria = new CriteriaCompo(new Criteria('com_modid', $com_modid));
                $criteria->add(new Criteria('com_itemid', $com_itemid));
                $criteria->add(new Criteria('com_status', XOOPS_COMMENT_ACTIVE));
                $comment_count = $comment_handler->getCount($criteria);
                $func = $comment_config['callback']['update'];
                call_user_func_array($func, array($com_itemid, $comment_count, $comment->getVar('com_id')));
            }
        }

        // increment user post if needed
        $uid = $comment->getVar('com_uid');
        if ($uid > 0 && false != $add_userpost) {
            $member_handler =& xoops_gethandler('member');
            $poster =& $member_handler->getUser($uid);
            if (is_object($poster)) {
                $member_handler->updateUserByField($poster, 'posts', $poster->getVar('posts') + 1);
            }
        }

        // RMV-NOTIFY
        // trigger notification event if necessary
        if ($notify_event) {
            $not_modid = $com_modid;
            include_once XOOPS_ROOT_PATH . '/include/notification_functions.php';
            $not_catinfo =& notificationCommentCategoryInfo($not_modid);
            $not_category = $not_catinfo['name'];
            $not_itemid = $com_itemid;
            $not_event = $notify_event;

            // Build an ABSOLUTE URL to view the comment.  Make sure we
            // point to a viewable page (i.e. not the system administration
            // module).
            $comment_tags = array();

            $not_module =& $xoopsModule;

            if (!isset($comment_url)) {
                $com_config =& $not_module->getInfo('comments');
                $comment_url = $com_config['pageName'] . '?';
                if (isset($com_config['extraParams']) && is_array($com_config['extraParams'])) {
                    $extra_params = '';
                    foreach ($com_config['extraParams'] as $extra_param) {
                        $extra_params .= isset($_POST[$extra_param]) ? $extra_param.'='.$_POST[$extra_param].'&amp;' : $extra_param.'=&amp;';
                        //$extra_params .= isset($_GET[$extra_param]) ? $extra_param.'='.$_GET[$extra_param].'&amp;' : $extra_param.'=&amp;';
                    }
                    $comment_url .= $extra_params;
                }
                $comment_url .= $com_config['itemName'];
            }
            $comment_tags['X_COMMENT_URL'] = XOOPS_URL . '/modules/' . $not_module->getVar('dirname') . '/' .$comment_url . '=' . $com_itemid.'&amp;com_id='.$newcid.'&amp;com_rootid='.$com_rootid.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order.'#comment'.$newcid;
            $notification_handler =& xoops_gethandler('notification');
            $notification_handler->triggerEvent($not_category, $not_itemid, $not_event, $comment_tags, false, $not_modid);
        }

        if (!isset($comment_post_results)) {

            // if the comment is active, redirect to posted comment
            if ($comment->getVar('com_status') == XOOPS_COMMENT_ACTIVE) {
                redirect_header($redirect_page.'='.$com_itemid.'&amp;com_id='.$newcid.'&amp;com_rootid='.$com_rootid.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order.'#comment'.$newcid, 2, _CM_THANKSPOST);
            } else {
                // not active, so redirect to top comment page
                redirect_header($redirect_page.'='.$com_itemid.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order.'#comment'.$newcid, 2, _CM_THANKSPOST);
            }
        }
    } else {
        if (!isset($purge_comment_post_results)) {
            include XOOPS_ROOT_PATH.'/header.php';
            xoops_error($comment->getHtmlErrors());
            include XOOPS_ROOT_PATH.'/footer.php';
        } else {
            $comment_post_results = $comment->getErrors();
        }
    }
    break;
default:
    redirect_header(XOOPS_URL.'/',3);
    break;
}

?>