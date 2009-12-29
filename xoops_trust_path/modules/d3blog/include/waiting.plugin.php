<?php
/**
 * @version $Id: waiting.plugin.php 313 2008-02-29 12:52:07Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if(!function_exists('b_waiting_d3blog')) {

function b_waiting_d3blog($mydirname) {
    $block = array();

    require dirname(dirname(__FILE__)).'/include/prepend.inc.php';

    $myModule = call_user_func(array($mydirname, 'getInstance'));
    global $currentUser;

	// PERMISSION
    if(!$currentUser->isEditor($myModule->module_id)) {
        return $block;
    }

    $entry_handler =& $myModule->getHandler('entry');
    $tb_handler =& $myModule->getHandler('trackback');
	    
    // new entry
	$criteria =& $entry_handler->getDefaultCriteria();
	// CRITERIA WITH AN ENTRY PERMISSION
	$criteria =& $entry_handler->entryPermCriteria($criteria);
    $criteria->add(new criteria('approved', '0'));
    $criteria->add(new criteria('notified', '0'));
    $count_entry =& $entry_handler->getCount($criteria);

    if($count_entry > 0) {
        $entry['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/index.php?page=approval_manager";
        $entry['pendingnum'] = $count_entry;
        $entry['lang_linkname'] = sprintf(_PI_WAITING_WAITINGS_FMT, _PI_WAITING_BLOGS);
        $block[] = $entry;
    }
    unset($criteria);
    
    // new trackback
//    if(!$myModule->getConfig('d3blog_comment_system') && $myModule->getConfig('trackback_approval')) {	// TO DO permission check
    if($myModule->getConfig('trackback_approval')) {	// TO DO permission check
        $criteria = new criteriaCompo(new criteria('direction', '2'));
        $criteria->add(new criteria('approved', '0'));
        $count_trackback =& $tb_handler->getCount($criteria);    
    
        if($count_trackback > 0) {
            $trackback['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/index.php?page=approval_manager";
            $trackback['pendingnum'] = $count_trackback;
            $trackback['lang_linkname'] = sprintf(_PI_WAITING_WAITINGS_FMT, _PI_WAITING_LINKS);
            $block[] = $trackback;
        }
    }
    unset($criteria);    

/*    // new comment
    if($myModule->getConfig('d3blog_comment_system')) {
        if(XOOPS_COMMENT_APPROVENONE != $myModule->getConfig('com_rule') && XOOPS_COMMENT_APPROVEALL != $myModule->getConfig('com_rule')) {
            $com_handler =& $myModule->getHandler('comment');
            $criteria = new criteriaCompo();
            $criteria->add(new criteria('com_status', D3BLOG_COM_PENDING));
            $criteria->setSort('com_bid', 'ASC');
            $criteria->addSort('created', 'DESC');
            $count_comment =& $com_handler->getCount($criteria);    
    
            if($count_comment > 0) {
                $comment['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/index.php?page=approval_manager";
                $comment['pendingnum'] = $count_comment;
                $comment['lang_linkname'] = sprintf(_PI_WAITING_WAITINGS_FMT, _PI_WAITING_COMMENTS);
                $block[] = $comment;
            }
        }
    }*/ 
    return $block;
}

}

?>