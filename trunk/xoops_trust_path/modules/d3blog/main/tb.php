<?php
/**
 * @version $Id: tb.php 398 2008-03-26 02:20:50Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

$mytrustdirname = basename( dirname( __FILE__ ) ) ;
$mytrustdirpath = dirname( __FILE__ ) ;

require_once dirname(dirname(__FILE__)).'/include/filter/TrackbackFilter.class.php';

// check if user has perm
if(!$currentUser->blog_perm()) {
    exit(d3blog_responseError("Thanks, but you don't have permission to access this entry", 1));
}

$entry_handler =& $myModule->getHandler('entry');
$tb_handler =& $myModule->getHandler('trackback');

// get id from PATH_INFO
$id = $tb_handler->getId();
if(!$id) {
    exit(d3blog_responseError('Invalid trackback key', 1));
}

switch( $_SERVER['REQUEST_METHOD'] ) {

case 'GET':
default:
    if($myModule->getConfig('trackback_ticket')) {  
        // get blog ID when a ticket url system is on.
        if(preg_match("/^[0-9a-z]+$/", $id) && strlen($id) == 12) {
            // get bid
            $obj =& $tb_handler->getByTbkey($id);
            if(!$obj) {
                exit(d3blog_responseError('No such key id found. Re-get trackback ticket.', 1));
            }       
            $bid = $obj->getVar('bid');
        } else {
            $bid = intval($id);
        }
    } else {
        $bid = intval($id);
    }

    $entry =& $entry_handler->getEntry($bid, false);
    if(!$entry) {
        exit(d3blog_responseError('No such blog entry found', 1));
    }

    if( isset($_GET['__mode']) && $_GET['__mode'] == "rss" ) {
        $rss = array();
        $rss['title'] = xoops_convert_encoding($entry->getVar('title'));
        $rss['excerpt'] = xoops_convert_encoding($entry->pingExcerpt());
        $rss['url'] = xoops_convert_encoding(sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname4show, $entry->bid()));
        $rss['encoding'] = 'UTF-8';
        $rss['language'] = _LANGCODE;

        // gather received trackback data
        $tbs = $tb_handler->getTrackback($entry->bid(), D3BLOG_TRACKBACK_DIRECTION_RECEIVED, true);
        foreach($tbs['inbound'] as $tb) {
            $rss['items'][] = array(
                'title' => xoops_convert_encoding($tb->getVar('title')),
                'url' => xoops_convert_encoding($tb->getVar('url')),
                'excerpt' => xoops_convert_encoding($tb->getVar('excerpt'))
                );
        }
        echo $tb_handler->getPingList($rss);
        exit;
    } else {
        header('Location:' . sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $mydirname, $bid )) ;
        exit;
    }
    break;

case 'POST':
    if($myModule->getConfig('trackback_ticket')) {
        if(!preg_match("/^[0-9a-z]+$/", $id) || strlen($id)!=12) {
            exit(d3blog_responseError('Invalid trackback key', 1));
        }
        // get bid
        $trackback =& $tb_handler->getByTbkey($id);
        if(!$trackback) {
            exit(d3blog_responseError('No such key id found. Re-get trackback id.', 1));
        }
        $bid = $trackback->getVar('bid');
    } else {
        $bid = intval($id);
    }

    $entry =& $entry_handler->getEntry($bid);
    if(!$entry) {
        exit(d3blog_responseError('No such blog entry found', 1));
    }

    if(!isset($trackback)) {
        $trackback =& $tb_handler->create();
    }
    $trackback->tbkey_ = $id;
    $trackback->setVar('bid', $bid);
    $trackback->setVar('host', $_SERVER['REMOTE_ADDR']);
    $trackback->setVar('direction', D3BLOG_TRACKBACK_DIRECTION_RECEIVED);
    $trackback->setVar('created', time());
    if($myModule->getConfig('trackback_approval')) {
        $trackback->setVar('approved', 0);
    } else {
        $trackback->setVar('approved', 1);
    }
    
    // receive trackback
    if(!$trackback->receive()) {
        exit(d3blog_responseError(implode('',$trackback->getErrors()), 1));
    }

    // check if the trackback data sent to again
    $criteria = new criteriaCompo(new criteria('direction', D3BLOG_TRACKBACK_DIRECTION_RECEIVED));
    $criteria->add(new criteria('bid', $bid));
    $criteria->add(new criteria('url', addslashes($trackback->getVar('url'))));
    $objs =& $tb_handler->getObjects($criteria);
    if(count($objs)) {
        exit(d3blog_responseError('Thanks again, you sent this trackback before', 1));
    }

    // spam check
    if(!$trackback->spamCheck()) {
        exit(d3blog_responseError(implode(' ',$trackback->getErrors()).' Your trackback smells like spam. If not, please contact the webmaster of this site.', 1));
    }
// debug
//ob_start();$fp=fopen('/tmp/debug.log','a+');var_dump($trackback);fputs($fp,ob_get_contents());ob_end_clean();

    // save trackback
    if(!$tb_handler->insert($trackback, true)) {
        exit(d3blog_responseError('Sorry, server error occurred', 1));
    }

    // send notifications
    $notification_handler =& xoops_gethandler('notification');
    $tags = array(
        'TITLE' => $entry->title(),
        'TRACKBACK_TITLE' => $trackback->getVar('title'),
        'BLOGGER_NAME' => $entry->uname(),
        'TRACKBACK_URI' => sprintf('%s/modules/%s/details.php?bid=%d#trackback', XOOPS_URL, $mydirname4show, $bid)
    );

    if($trackback->isApproved()) {
        // notify
        $notification_handler->triggerEvent('global', 0, 'trackback', $tags);
        $notification_handler->triggerEvent('entry', $bid, 'trackback', $tags);
        
        // increment trackback count
        $entry->synchronizeTrackbacks();
        $entry_handler->insert($entry);
    } else {
        // request for approval
        $tags['WAITING_URI'] = sprintf('%s/modules/%s/admin/index.php?page=approval_manager', XOOPS_URL, $mydirname4show);
        require_once dirname(dirname(__FILE__)).'/lib/perm.php';
        $notification_handler->triggerEvent('global', 0, 'tb_received', $tags, array_keys(myPerm::getUsersByName('blog_editor')));
    }
/*
    // export comment
    if($myModule->getCnfig('dblog_comment_system')) {
        $com_handler =& $myModule->getHandler('commnet');
        $comment =& $com_handler->create();
        $comment->setVar('com_bid', $obj->getVar('bid', 'n'));
        $comment->setVar('com_tid', $obj->getVar('tid', 'n'));
        $comment->setVar('com_type', D3BLOG_COM_TYPE_TRACKBACK);
        $comment->setVar('com_status', $obj->getVar('approved')? D3BLOG_COM_ACTIVE : D3BLOG_COM_PENDING);
        $comment->setVar('com_title', $obj->getVar('title', 'n'));
        $text = $obj->getVar('excerpt', 'n');
        $text .= "\n".'[trackback from]';
        $text .= "\n".'[url='.$obj->getVar('url', 'n').']'.$obj->getVar('blog_name', 'n').'[/url]';
        $comment->setVar('com_text', $text);
        $comment->setVar('com_created', $obj->getVar('created', 'n'));
        $comment->setVar('com_modified', $obj->getVar('created', 'n'));
        $comment->setVar('user_id', 0);
        $comment->setVar('user_name', $obj->getVar('blog_name', 'n'));
        $comment->setVar('user_url', $obj->getVar('url', 'n'));
        $comment->setVar('user_host', $obj->getVar('host', 'n'));
        $comment->cleanVars();
        if(!empty($comment->_errors)) {
            exit( d3blog_responseError('Sorry, server error occurred', 1));
        }
        if(!$com_handler->insert($comment)) {
            exit( d3blog_responseError('Sorry, server error occurred', 1));
        }

        $comment->setVar('com_rootid', $comment->getVar('com_id'));
        $comment->setVar('com_pid', 0);
        if($comment_handler->insert($comment)) {
            exit( d3blog_responseError('Sorry, server error occurred', 1));
        }
    }
*/
    // respond back success
    exit(d3blog_responseSuccess());
    break;
}
?>