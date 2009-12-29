<?php
/**
 * @version $Id: permission_manager.php 316 2008-03-01 12:44:36Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(__FILE__)).'/lib/perm.php';
require_once dirname(dirname(__FILE__)).'/include/gticket.php';

$cid = isset($_POST['cid'])? intval($_POST['cid']) : 0;
$gperm_handler =& myXoopsGroupPermHandler::getInstance();
$member_handler =& xoops_gethandler('member');
$group_list =& $member_handler->getGroupList();

// renew group permissions
if(!empty( $_POST['gperm_renew'])) {
    if ( ! $xoopsGTicket->check( true , 'd3blog_admin' ) ) {
        redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
    }

    // delete once
    $criteria = new CriteriaCompo( new criteria('gperm_modid', $myModule->module_id) );
    $criteria->add( new criteria('gperm_itemid', $cid) );
    $gperm_handler->deletes($criteria);
    
    // And renew
    foreach(array_keys($group_list) as $gid ) {
        foreach(array_keys($gperm_config) as $gperm_name) {
            if(!empty($_POST[$gperm_name][$gid])) {
                $gperm_row = array(
                    'gperm_item_id' => $cid,
                    'gperm_modid'   => $myModule->module_id,
                    'gperm_groupid' => intval($gid),
                    'gperm_name'    =>  addslashes($gperm_name)  
                );
                $gperm =& $gperm_handler->create();
                $gperm->assignVars($gperm_row);
                $gperm->setDirty();
                if(!$gperm_handler->insert($gperm)) {
                    redirect_header(XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=permission_manager', 2, _MD_A_D3BLOG_MESSAGE_DBUPDATE_FAILED);
                    exit();
                }
                unset($gperm);
            }
        }        
    }
    
    redirect_header( XOOPS_URL.'/modules/'.$mydirname.'/admin/index.php?page=permission_manager&amp;cid='.$cid, 1, _MD_A_D3BLOG_MESSAGE_DBUPDATE_SUCCESS ) ;
    exit ;
}

// get permission by group_id
$gperms = myPerm::getPermsByGroup();
$groupperm[$cid] = array();     // array by category id, extensible for future
foreach( $group_list as $gid=>$gname ) {
    $gid = intval($gid);
    $gname = htmlspecialchars($gname, ENT_QUOTES);
    $groupperm[$cid][$gid] = array();
    $groupperm[$cid][$gid]['gid'] = $gid;
    $groupperm[$cid][$gid]['gname'] = $gname;
    $groupperm[$cid][$gid]['perms'] = array();
    foreach(array_keys($gperm_config) as $gperm_name) {
        if(isset($gperms[$cid][$gid][$gperm_name]))
            $groupperm[$cid][$gid]['perms'][$gperm_name] = 1;
        else
            $groupperm[$cid][$gid]['perms'][$gperm_name] = 0;
    }
}      
    
xoops_cp_header();
include dirname(__FILE__).'/mymenu.php' ;
$tpl = new XoopsTpl() ;
$tpl->assign( array(
    'mydirname' => $mydirname4show,
    'mod_url' => sprintf("%s/modules/%s", XOOPS_URL, $mydirname4show),
    'myname' => $myModule->module_name,
    'categoryicon_url' => htmlspecialchars(str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $myModule->getConfig('categoryicon_path')), ENT_QUOTES),
    'modConfig' => $myModule->module_config,
    'cid' => $cid ,
    'category_name' => _MD_A_D3BLOG_LANG_CATEGORY_GLOBAL,
    'gperm_config' => $gperm_config,
    'groupperms' => $groupperm,
    'group_list' => $group_list,
    'gticket_hidden' => $xoopsGTicket->getTicketHtml( __LINE__ , 1800 , 'd3blog_admin') ,
) ) ;
$tpl->display( 'db:'.$mydirname.'_admin_permission_manager.html' ) ;
xoops_cp_footer();

?>