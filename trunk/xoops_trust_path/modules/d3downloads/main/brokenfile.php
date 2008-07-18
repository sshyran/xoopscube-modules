<?php

// $Id: brokenfile.php,v 1.1 2004/01/29 14:45:12 buennagel Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//
//  modify by photosite 2008/03/07 10:11:20 for d3downloads
//

include XOOPS_ROOT_PATH.'/header.php';
include_once dirname( dirname(__FILE__) ).'/class/user_access.php' ;
include_once dirname( dirname(__FILE__) ).'/class/mytree.php' ;
require_once dirname( dirname(__FILE__) ).'/include/common_functions.php' ;

$db =& Database::getInstance() ;

$xoopsOption['template_main'] = $mydirname.'_main_brokenfile.html';

$cid = ! empty( $_GET['cid'] ) ? intval( $_GET['cid'] ) : 0 ;
$lid = ! empty( $_GET['lid'] ) ? intval( $_GET['lid'] ) : 0 ;

$user_access = new user_access( $mydirname ) ;
$whr_cat = "cid IN (".implode(",", $user_access->can_read() ).")" ;

$mytree = new MyTree( $db->prefix( $mydirname."_cat" ) , "cid" , "pid" ) ;
if( ! empty( $xoopsModuleConfig['show_breadcrumbs'] ) ){
	$pathstring = d3download_pathstring( $mytree, $cid, $whr_cat );
	$xoopsTpl->assign('category_path', $pathstring);
}
$breadcrumbs[0] = d3download_breadcrumbs( $mydirname ) ;
$bc_arr =  $mytree->getNicePathArrayFromId( $cid, "title", $whr_cat, "index.php?" );
foreach( $bc_arr as $bc ) {
	$breadcrumbs[] = array(
		'name' => $bc['name'] ,
		'url' => $bc['url'] ,
	) ;
}

$download4assign = d3download_get_title( $mydirname, $lid, $whr_cat );
$title4assign = $download4assign['title'] ;

$breadcrumbs[] = array( 'name' => $title4assign ) ;

if ( ! empty($_POST['submit']) ) {
	if ( empty( $xoopsUser ) ) {
		$sender = 0;
	} else {
		$sender = $xoopsUser->getVar('uid');
	}

	$ip = getenv( "REMOTE_ADDR" );
	$lid = intval( $_POST['lid'] );
	$cid = intval( $_POST['cid'] );
	if ( $sender != 0 ) {
		// Check if REG user is trying to report twice.
		$result=$db->query("SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$lid AND sender=$sender");
		list ($count) = $db->fetchRow($result);
		if ( $count > 0 ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/",2,_MD_D3DOWNLOADS_ALREADYREPORTED);
			exit();
		}
	} else {
		// Check if the sender is trying to vote more than once.
		$result=$db->query("SELECT COUNT(*) FROM ".$db->prefix( $mydirname."_broken")." WHERE lid=$lid AND ip = '$ip'");
		list ( $count )=$db->fetchRow( $result );
		if ( $count > 0 ) {
			redirect_header( XOOPS_URL."/modules/$mydirname/",2,_MD_D3DOWNLOADS_ALREADYREPORTED);
			exit();
		}
	}
	$newid = $db->genId($db->prefix( $mydirname."_broken" )."_reportid_seq");
    $sql = sprintf("INSERT INTO %s (reportid, lid, sender, ip) VALUES (%u, %u, %u, '%s')", $db->prefix( $mydirname."_broken"), $newid, $lid, $sender, $ip);
	$db->query($sql) or exit();
	$tags = array(
		'POST_TITLE' => $download4assign['title'] ,
		'BROKENREPORTS_URL' => XOOPS_URL . '/modules/index.php?page=singlefile&cid='.$cid.'&lid='.$lid ,
	) ;
	d3download_main_trigger_event( 'global' , 0 , 'broken' , $tags, 0 ) ;
	redirect_header( XOOPS_URL."/modules/$mydirname/", 2 , _MD_D3DOWNLOADS_ALREADYREPORTED );
	exit();
}

$xoops_module_header = d3download_dbmoduleheader( $mydirname );
$xoopsTpl->assign('xoops_module_header', $xoops_module_header . "\n" . $xoopsTpl->get_template_vars( 'xoops_module_header' ) );

$xoopsTpl->assign( array(
	'mydirname' => $mydirname ,
	'mod_url' => XOOPS_URL.'/modules/'.$mydirname ,
	'page' => 'brokenfile' ,
	'down' => $download4assign ,
	'lang_reportbroken' => _MD_D3DOWNLOADS_REPORTBROKEN ,
	//'file_id' => intval( $HTTP_GET_VARS['lid'] ) ,
	'lang_thanksforhelp' => _MD_D3DOWNLOADS_THANKSFORHELP ,
	'lang_forsecurity' => _MD_D3DOWNLOADS_FORSECURITY ,
	'lang_rateit' =>  _MD_D3DOWNLOADS_RATEIT ,
	'lang_cancel' => _CANCEL ,
	'xoops_pagetitle' => $title4assign ,
	'xoops_breadcrumbs' => $breadcrumbs ,
	'mod_config' => $xoopsModuleConfig ,
) ) ;

include_once XOOPS_ROOT_PATH.'/footer.php';

?>
