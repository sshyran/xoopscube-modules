<?php
/**
 * @version $Id: approval_manager.php 398 2008-03-26 02:20:50Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(__FILE__)).'/include/gticket.php';

$start = isset($_GET['start'])? intval($_GET['start']) : 0;

// obtain class instances
$db =& Database::getInstance();
$myts =& MyTextSanitizer::getInstance();

$entry_handler =& $myModule->getHandler('entry');
//$com_handler =& $myModule->getHandler('comment');
$tb_handler =& $myModule->getHandler('trackback');

$xoopsGTicket = new xoopsGTicket();
$return_message = array();

if(isset($_POST['approve_tb']) || isset($_POST['delete_tb'])) {
    // check ticket
    if (!$xoopsGTicket->check(true,'d3blog_admin'))
        die($xoopsGTicket->getErrors());

    $bids = array();
    if(isset($_POST['delete_tb']) and is_array($_POST['delete_tb'])) {
        $criteria = new criteriaCompo();
        foreach($_POST['delete_tb'] as $bid=>$tid_array) {
            $bids[] = $bid;
            foreach(array_keys($tid_array) as $tid) {
                $criteria->add(new criteria('tid', intval($tid)), 'OR');
            }
        }
                
        if($tb_handler->deletes($criteria)) {
            $return_message[] = sprintf(_MD_A_D3BLOG_MESSAGE_DB_DELETE_SUCCESS, 'trackback');
        }
    }

    if(isset($_POST['approve_tb']) and is_array($_POST['approve_tb'])) {
        foreach($_POST['approve_tb'] as $bid=>$tid_array) {
            $bids[] = $bid;
            foreach(array_keys($tid_array) as $tid) {
                $tb = $tb_handler->get($tid);
                $tb->setVar('approved', 1);
                $tb_handler->insert($tb);
            }
        }
        $return_message[] = sprintf(_MD_A_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS, 'trackback');
    }
    
    // SYNCHRONIZE TRACKBACK COUNT
    $bids = array_unique($bids);
    foreach($bids as $bid) {
        $entry = $entry_handler->get($bid);
        $entry->synchronizeTrackbacks();
        $entry_handler->insert($entry);
    }
    $return_message[] = sprintf(_MD_A_D3BLOG_MESSAGE_DB_UPDATE_SUCCESS, 'entry '.$entry->title());

}

if(count($return_message)) {
    $message = "";
    foreach($return_message as $msg) {
        $message .= htmlspecialchars($msg, ENT_QUOTES).'<br />';
    }
    redirect_header(XOOPS_URL."/modules/$mydirname/admin/index.php?page=approval_manager", 1, $message);
    exit;
}

// GET ENTRY TO BE APPROVED
$e_sql = sprintf("SELECT bid, title, created FROM %s WHERE approved = 0 ORDER BY bid", $db->prefix($mydirname."_entry"));
$e_result = $db->query($e_sql);
$e_unapproved = array();
if($e_result) {
    while(list($bid, $title, $created) = $db->fetchRow($e_result)) {
        $e_unapproved[intval($bid)]['bid'] = intval($bid);
        $e_unapproved[intval($bid)]['title'] = htmlspecialchars($title, ENT_QUOTES);
        $e_unapproved[intval($bid)]['posted'] = intval($created);
        $e_unapproved[intval($bid)]['approved'] = 0;
    } 
}

// GET TRACKBACK TO BE APPROVED
$sql = sprintf("SELECT e.bid, e.title, e.created as posted, t.tid, t.blog_name, t.excerpt, t.created as transmitted, t.url FROM %s e LEFT JOIN %s t ON e.bid=t.bid",
    $db->prefix($mydirname."_entry"), $db->prefix($mydirname."_trackback"));
$sql_where = " WHERE (t.direction = 2 AND t.approved = 0)";
$order = " ORDER BY bid, tid";

$result = $db->query($sql.$sql_where.$order);
$rows = array();
$t_unapproved = array();
if($result) {
    while(list($bid, $title, $posted, $tid, $blog_name, $excerpt, $transmitted, $url) = $db->fetchRow($result)) {
        $row['tid'] = intval($tid);
        $row['blog_name'] = htmlspecialchars($blog_name, ENT_QUOTES);
        $row['excerpt'] = strip_tags($myts->displayTarea(strip_tags($excerpt), 0, 0, 0, 0, 0));
        $row['transmitted'] = intval($transmitted);
        $row['url'] = htmlspecialchars($url, ENT_QUOTES);
        if(in_array($bid, array_keys($e_unapproved)) ) {
            $e_unapproved[intval($bid)]['trackback'][intval($tid)] = $row;
        } else {
            if(!in_array($bid, array_keys($t_unapproved))) {
                $t_unapproved[intval($bid)]['bid'] = intval($bid);
                $t_unapproved[intval($bid)]['title'] = htmlspecialchars($title, ENT_QUOTES);
                $t_unapproved[intval($bid)]['posted'] = intval($posted);
                $t_unapproved[intval($bid)]['approved'] = 1;
            }
            $t_unapproved[intval($bid)]['trackback'][intval($tid)] = $row;
        }
    }   
}

$unapproved = $e_unapproved + $t_unapproved;

uksort($unapproved, 'cmp');

$rows = array();
$count = 0;
foreach($unapproved as $unapp) {
    $row = array();
    $row['bid'] = $unapp['bid'];
    $row['title'] = $unapp['title'];
    $row['posted'] = $unapp['posted'];
    $row['approved'] = $unapp['approved'];
    if(isset($unapp['trackback'])) {
        foreach($unapp['trackback'] as $tb) {
            $row['tid'] = $tb['tid'];
            $row['blog_name'] = $tb['blog_name'];
            $row['excerpt'] = $tb['excerpt'];
            $row['transmitted'] = $tb['transmitted'];
            $row['url'] = $tb['url'];
            $rows[$count++] = $row;
        }
    } else {
        $rows[$count++] = $row;
    }
}

// PAGE NAVIGATION
$page_navigater = "";
$perpage = $myModule->getConfig('archive_numperpage')? intval($myModule->getConfig('archive_numperpage')) : 10;
if ( $count > $perpage ) {
    require_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $nav = new XoopsPageNav($count, $perpage, $start, "start", "page=approval_manager");
    $page_navigater = $nav->renderNav();
}

xoops_cp_header();
include dirname(__FILE__).'/mymenu.php';
$tpl = new XoopsTpl();
$tpl->assign( array(
    'myname' => $myModule->module_name,
    'mydirname' => $mydirname4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'moduleConfig' => $myModule->module_config,
    'page_subtitle' => htmlspecialchars(_MD_A_D3BLOG_LANG_APPROVAL_MANAGER, ENT_QUOTES),
    'rows' => $rows,
    'start' => $start,
    'limit' => $start + $perpage,
    'page_navigater' => $page_navigater,
    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3blog_admin')
    )
);

//$xoopsTpl->xoops_setDebugging(true);  // smarty debug
$tpl->display( 'db:'.$mydirname.'_admin_approval_manager.html' ) ;
xoops_cp_footer();

function cmp($a, $b) {
    return ($a < $b)? -1 : 1;
}

?>