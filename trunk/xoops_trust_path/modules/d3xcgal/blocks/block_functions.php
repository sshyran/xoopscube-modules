<?php
// $Id: d3xcgal_blocks.php,v 1.3 2005/12/16 14:53:56 mcleines Exp $
//  ------------------------------------------------------------------------ //
//                    xcGal 2.0 - XOOPS Gallery Modul                        //
//  ------------------------------------------------------------------------ //
//  Based on      xcGallery 1.1 RC1 - XOOPS Gallery Modul                    //
//                    Copyright (c) 2003 Derya Kiran                         //
//  ------------------------------------------------------------------------ //
//  Based on Coppermine Photo Gallery 1.10 http://coppermine.sourceforge.net///
//                      developed by GrñÈory DEMAR                           //
//  ------------------------------------------------------------------------ //
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

//define("BLOCK_FIRST_USER_CAT", 10000);
//define('RANDPOS_MAX_PIC_BLOCK', 200);


function d3xcgal_block_scroll_func($options) {
    global $d3xcgalModule;
    global $ALBUM_SET_BLOCK, $GLOBALS, $xoopsDB, $xoopsUser;
    
    $mydirname = empty( $options[0] ) ? 'd3xcgal' : $options[0] ;
    $album_type = empty( $options[1] ) ? 1 : intval( $options[1] ) ;
    $wh = empty( $options[2] ) ? 100 : intval( $options[2] ) ;
    $set_caption = empty( $options[3] ) ? 1 : intval( $options[3] ) ;
    $count = empty( $options[4] ) ? 5 : intval( $options[4] ) ;

    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;
    $this_template = 'db:'.$mydirname.'_block_scroll.html';

    $thumb_list= array();
    $block= array();
    //d3xcgal_block_album_set();
    //******************************
    // start d3xcgal_block_album_set
    //******************************
    if (is_object ($xoopsUser)){
        $usergroups= $xoopsUser->getgroups();
            $usergroup= implode(",",$usergroups);
        $buid= $xoopsUser->uid();
    } else {
        $usergroup= XOOPS_GROUP_ANONYMOUS;
        $buid = 0;
    }
    $module_handler= & xoops_gethandler('module');
    $d3xcgalModule = $module_handler->getByDirname($mydirname);
    if(is_object($xoopsUser) && ($xoopsUser->isAdmin($d3xcgalModule->mid()))) $ALBUM_SET_BLOCK= "";
    else {
        $result = $xoopsDB->query("SELECT aid FROM ".$xoopsDB->prefix($mydirname."_albums")." WHERE visibility NOT IN ($usergroup, 0,".(10000 + $buid).")");
        if (($xoopsDB->getRowsNum($result))) {
                $set ='';
            while($album=$xoopsDB->fetchArray($result)){
                    $set .= $album['aid'].',';
            } // while
                $ALBUM_SET_BLOCK .= 'AND aid NOT IN ('.substr($set, 0, -1).') ';
        }
        $xoopsDB->freeRecordSet($result);
    }
    //******************************
    // end d3xcgal_block_album_set
    //******************************

        //$pic_datas = d3xcgal_pic_data_block($album_type, $count, $set_caption);
    //******************************
    // start d3xcgal_pic_data_block
    //******************************
    $select_columns = 'pid, filepath, filename, url_prefix, filesize, pwidth, pheight, ctime';

        // Meta albums
        switch($album_type){
        case '5': // Last comments
                $select_columns = $select_columns.', com_id, com_uid,com_itemid,com_rootid, com_exparams, com_created, com_title';
                $member_handler =& xoops_gethandler('member');
                $module_handler= & xoops_gethandler('module');
                $d3xcgalModule = $module_handler->getByDirname($mydirname);
                include_once XOOPS_ROOT_PATH."/include/comment_constants.php";
                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix("xoopscomments").", ".$xoopsDB->prefix($mydirname."_pictures")." WHERE com_modid = ".$d3xcgalModule->mid()." AND approved = 'YES' AND pid = com_itemid AND com_status=".XOOPS_COMMENT_ACTIVE." $ALBUM_SET_BLOCK ORDER by com_id DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                $comment_config = $d3xcgalModule->getInfo('comments');
                if ($set_caption) foreach ($rowset as $key => $row){
                        if ($row['com_uid'] > 0){
                            $poster =& $member_handler->getUser($row['com_uid']);
                            if (is_object($poster)) {
                                                $posters = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$row['com_uid'].'">'.$poster->getVar('uname').'</a>';
                                        } else {
                                                 $posters = $GLOBALS['xoopsConfig']['anonymous'];
                            }}
                        else $posters = $GLOBALS['xoopsConfig']['anonymous'];
                        $comtitle='<a href="'.XOOPS_URL.'/modules/'.$mydirname.'/'.$comment_config['pageName'].'?'.$comment_config['itemName'].'='.$row['com_itemid'].'&amp;com_id='.$row['com_id'].'&amp;com_rootid='.$row['com_rootid'].'&amp;com_mode=flat&amp;'.$row['com_exparams'].'#comment'.$row['com_id'].'">'.$row['com_title'].'</a>';
                        $caption = "<span style=\" font-size: 10px;        padding: 1px; display : block;\">".$posters.'</span>'."<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['com_created'],'m').'</span>'."<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".$comtitle.'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
               $pic_datas = $rowset;
               break;

        case '2': // Last uploads
                $select_columns .= ', owner_id';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY pid DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);
                if ($set_caption) foreach ($rowset as $key => $row){
                        $user_handler =& xoops_gethandler('member');
                    $pic_owner =& $user_handler->getUser($row['owner_id']);
            if (is_object ($pic_owner)){
                            $user_link = '<br /><a href ="'.XOOPS_URL.'/userinfo.php?uid='.$pic_owner->uid().'">'.$pic_owner->uname().'</a>';
                        } else {
                                $user_link = '';
                        }
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['ctime'],'m').$user_link.'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '3': // Most viewed pictures
                $select_columns .= ', hits';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES'AND hits > 0 $ALBUM_SET_BLOCK ORDER BY hits DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".sprintf(_MB_D3XCGAL_FUNC_VIEW, $row['hits']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '4': // Top rated pictures
                $select_columns .= ', pic_rating, votes';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' AND votes > 0 $ALBUM_SET_BLOCK ORDER BY ROUND((pic_rating+1)/2000) DESC, votes DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".'<img src="'.XOOPS_URL.'/modules/'.$mydirname.'/images/rating'.round($row['pic_rating']/2000).'.gif" align="absmiddle"/>'.'<br />'.sprintf(_MB_D3XCGAL_FUNC_VOTE, $row['votes']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '1': // Random pictures
            $result = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK");
                $nbEnr = $xoopsDB->fetchArray($result);
                $pic_count = $nbEnr['count(*)'];
                $xoopsDB->freeRecordSet($result);

                // if we have more than 1000 pictures, we limit the number of picture returned
                // by the SELECT statement as ORDER BY RAND() is time consuming
                if ($pic_count > 1000) {
                    $result = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES'");
                        $nbEnr = $xoopsDB->fetchArray($result);
                        $total_count = $nbEnr['count(*)'];
                        $xoopsDB->freeRecordSet($result);

                        $granularity = floor($total_count / 200);
                        $cor_gran = ceil($total_count / $pic_count);
                        srand(time());
                        for ($i=1; $i<= $cor_gran; $i++) $random_num_set =rand(0, $granularity).', ';
                        $random_num_set = substr($random_num_set,0, -2);
                        $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE  randpos IN ($random_num_set) AND approved = 'YES' $ALBUM_SET_BLOCK ORDER BY RAND() LIMIT $count");
                } else {
                        $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY RAND() LIMIT $count");
                }

                $rowset = array();
                while($row = $xoopsDB->fetchArray($result)){
                        $row['caption_text'] = '';
                        $rowset[-$row['pid']] = $row;
                }
                $xoopsDB->freeRecordSet($result);

                $pic_datas = $rowset;
                break;
        case '6': // Top sent ecards
                $select_columns .= ', sent_card';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' AND sent_card >0 $ALBUM_SET_BLOCK ORDER BY sent_card DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".sprintf(_MB_D3XCGAL_FUNC_CARD, $row['sent_card']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
        case '7': // Last hits
                $select_columns .= ', mtime';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY mtime DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['mtime'],'m').'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;
        }
    //******************************
    // end d3xcgal_pic_data_block
    //******************************

        $i = 0;
        $piclist=array();
        switch ($album_type){
    case '1':
        $album = "random";
        break;
    case '2':
        $album = "lastup";
        break;
    case '3':
        $album = "topn";
        break;
    case '4':
        $album = "toprated";
        break;
    case '5':
        $album = "lastcom";
        break;
    case '6':
        $album = "mostsend";
        break;
    case '7':
        $album = "lasthits";
        break;

    }

    $module_handler= & xoops_gethandler('module');
    $d3xcgalModule = $module_handler->getByDirname($mydirname);
    $config_handler =& xoops_gethandler('config');
        $d3xcgalConfig =& $config_handler->getConfigsByCat(0, $d3xcgalModule->mid());
        $block = array();
        if (count($pic_datas) > 0) {
                foreach ($pic_datas as $key => $row) {
                        $i++;

                        //$image_size = compute_img_size($row['pwidth'], $row['pheight'], $xoopsModuleConfig['thumb_width']);

                        $thumb_list[$i]['pos'] = $key < 0 ? $key : $i - 1 - $count;
                        $thumb_list[$i]['image'] = "<img src=\"".XOOPS_URL .'/modules/'.$mydirname.'/'.$d3xcgalConfig['fullpath'].str_replace("%2F","/",rawurlencode($row['filepath'].$d3xcgalConfig['thumb_pfx'].$row['filename']))."\" class=\"b_image\" border=\"0\" alt=\"{$row['filename']}\" />";
                        $thumb_list[$i]['caption'] = $row['caption_text'];
                        $thumb_list[$i]['pid'] = $row['pid'];
                        $thumb_list[$i]['link_tgt']="index.php?page=displayimage&pid={$row['pid']}&amp;album={$album}&amp;pos={$key}&amp;cat=";
                    $thumb_list[$i]['i']= $i;

                }

                //$xoopsTpl->assign('no_img',0);
                //theme_display_thumbnails($thumb_list, $thumb_count, $album_name, $album, $cat, $page, $total_pages, is_numeric($album), $display_tabs);
                $block['pics'] = $thumb_list;
                $block['wh'] = $wh;
                $block['mydirname'] = $mydirname;
        }
        if( empty( $options['disable_renderer'] ) ) {
                require_once XOOPS_ROOT_PATH.'/class/template.php' ;
                $tpl =& new XoopsTpl() ;
                $tpl->assign( 'block' , $block ) ;
                $ret['content'] = $tpl->fetch( $this_template ) ;
                return $ret ;
        } else {
                return $block ;
        }
}

function d3xcgal_block_scroll_edit($options) {

	$mydirname = empty( $options[0] ) ? 'd3xcgal' : $options[0] ;
	$album_type = empty( $options[1] ) ? 1 : intval( $options[1] ) ;
	$wh = empty( $options[2] ) ? 100 : intval( $options[2] ) ;
	$set_caption = empty( $options[3] ) ? 1 : intval( $options[3] ) ;
	$count = empty( $options[4] ) ? 5 : intval( $options[4] ) ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

    $form = "<input type='hidden' name='options[0]' value='$mydirname' />";
    $form.= _MB_D3XCGAL_TYPE."&nbsp;<select name='options[1]'>";
    $sel= array();
    for ( $i = 1; $i <= 7; $i++) {
                if ($i == intval($album_type)) $sel[$i] = "selected='selected'";
                else $sel[$i] = "";
        }
        $form.= "<option value='1' $sel[1]>"._MB_D3XCGAL_RANDOM."</option>";
        $form.= "<option value='2' $sel[2]>"._MB_D3XCGAL_NEWST."</option>";
        $form.= "<option value='3' $sel[3]>"._MB_D3XCGAL_VIEW."</option>";
        $form.= "<option value='4' $sel[4]>"._MB_D3XCGAL_TOP."</option>";
        $form.= "<option value='5' $sel[5]>"._MB_D3XCGAL_COMMENTS."</option>";
        $form.= "<option value='6' $sel[6]>"._MB_D3XCGAL_MOSTSENT."</option>";
        $form.= "<option value='7' $sel[7]>"._MB_D3XCGAL_LASTHITS."</option>";
        $form.= "</select>";

        $form.= "<br />"._MB_D3XCGAL_WIDTH."&nbsp;<input type='text' name='options[2]' value='".intval($wh)."' />";

        $form .= "<br />"._MB_D3XCGAL_CAPTION."&nbsp;<input type='radio' id='scroll_cap1' name='options[3]' value='1'";
        if ( intval($set_caption) == 1 ) {
                $form .= " checked='checked'";
        }
        $form .= " />&nbsp;"._YES."&nbsp;<input type='radio' id='scroll_cap0' name='options[3]' value='0'";
        if ( intval($set_caption) == 0 ) {
                $form .= " checked='checked'";
        }
        $form .= " />&nbsp;"._NO."";
        $form.= "<br />"._MB_D3XCGAL_COUNT."&nbsp;<input type='text' name='options[4]' value='".intval($count)."' />";
    return $form;
}

function d3xcgal_block_static_func($options) {
    global $d3xcgalModule;
    global $ALBUM_SET_BLOCK, $GLOBALS, $xoopsDB, $xoopsUser;

    $mydirname = empty( $options[0] ) ? 'd3xcgal' : $options[0] ;
    $album_type = empty( $options[1] ) ? 4 : intval( $options[1] ) ;
    $position = empty( $options[2] ) ? 2 : intval( $options[2] ) ;
    $set_caption = empty( $options[3] ) ? 1 : intval( $options[3] ) ;
    $count = empty( $options[4] ) ? 5 : intval( $options[4] ) ;

    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

    $this_template = 'db:'.$mydirname.'_block_static.html';

    $thumb_list= array();
    $block= array();
    //d3xcgal_block_album_set();
    //******************************
    // start d3xcgal_block_album_set
    //******************************
    if (is_object ($xoopsUser)){
        $usergroups= $xoopsUser->getgroups();
            $usergroup= implode(",",$usergroups);
        $buid= $xoopsUser->uid();
    } else {
        $usergroup= XOOPS_GROUP_ANONYMOUS;
        $buid = 0;
    }
    $module_handler= & xoops_gethandler('module');
    $d3xcgalModule = $module_handler->getByDirname($mydirname);
    if(is_object($xoopsUser) && ($xoopsUser->isAdmin($d3xcgalModule->mid()))) $ALBUM_SET_BLOCK= "";
    else {
        $result = $xoopsDB->query("SELECT aid FROM ".$xoopsDB->prefix($mydirname."_albums")." WHERE visibility NOT IN ($usergroup, 0,".(10000 + $buid).")");
        if (($xoopsDB->getRowsNum($result))) {
                $set ='';
            while($album=$xoopsDB->fetchArray($result)){
                    $set .= $album['aid'].',';
            } // while
                $ALBUM_SET_BLOCK .= 'AND aid NOT IN ('.substr($set, 0, -1).') ';
        }
        $xoopsDB->freeRecordSet($result);
    }
    //******************************
    // end d3xcgal_block_album_set
    //******************************

        //$pic_datas = d3xcgal_pic_data_block($album_type, $count, $set_caption);
    //******************************
    // start d3xcgal_pic_data_block
    //******************************
    $select_columns = 'pid, filepath, filename, url_prefix, filesize, pwidth, pheight, ctime';

        // Meta albums
        switch($album_type){
        case '5': // Last comments
                $select_columns = $select_columns.', com_id, com_uid,com_itemid,com_rootid, com_exparams, com_created, com_title';
                $member_handler =& xoops_gethandler('member');
                $module_handler= & xoops_gethandler('module');
                $d3xcgalModule = $module_handler->getByDirname($mydirname);
                include_once XOOPS_ROOT_PATH."/include/comment_constants.php";
                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix("xoopscomments").", ".$xoopsDB->prefix($mydirname."_pictures")." WHERE com_modid = ".$d3xcgalModule->mid()." AND approved = 'YES' AND pid = com_itemid AND com_status=".XOOPS_COMMENT_ACTIVE." $ALBUM_SET_BLOCK ORDER by com_id DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                $comment_config = $d3xcgalModule->getInfo('comments');
                if ($set_caption) foreach ($rowset as $key => $row){
                        if ($row['com_uid'] > 0){
                            $poster =& $member_handler->getUser($row['com_uid']);
                            if (is_object($poster)) {
                                                $posters = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$row['com_uid'].'">'.$poster->getVar('uname').'</a>';
                                        } else {
                                                 $posters = $GLOBALS['xoopsConfig']['anonymous'];
                            }}
                        else $posters = $GLOBALS['xoopsConfig']['anonymous'];
                        $comtitle='<a href="'.XOOPS_URL.'/modules/'.$mydirname.'/'.$comment_config['pageName'].'?'.$comment_config['itemName'].'='.$row['com_itemid'].'&amp;com_id='.$row['com_id'].'&amp;com_rootid='.$row['com_rootid'].'&amp;com_mode=flat&amp;'.$row['com_exparams'].'#comment'.$row['com_id'].'">'.$row['com_title'].'</a>';
                        $caption = "<span style=\" font-size: 10px;        padding: 1px; display : block;\">".$posters.'</span>'."<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['com_created'],'m').'</span>'."<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".$comtitle.'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
               $pic_datas = $rowset;
               break;

        case '2': // Last uploads
                $select_columns .= ', owner_id';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY pid DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);
                if ($set_caption) foreach ($rowset as $key => $row){
                        $user_handler =& xoops_gethandler('member');
                    $pic_owner =& $user_handler->getUser($row['owner_id']);
            if (is_object ($pic_owner)){
                            $user_link = '<br /><a href ="'.XOOPS_URL.'/userinfo.php?uid='.$pic_owner->uid().'">'.$pic_owner->uname().'</a>';
                        } else {
                                $user_link = '';
                        }
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['ctime'],'m').$user_link.'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '3': // Most viewed pictures
                $select_columns .= ', hits';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES'AND hits > 0 $ALBUM_SET_BLOCK ORDER BY hits DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".sprintf(_MB_D3XCGAL_FUNC_VIEW, $row['hits']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '4': // Top rated pictures
                $select_columns .= ', pic_rating, votes';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' AND votes > 0 $ALBUM_SET_BLOCK ORDER BY ROUND((pic_rating+1)/2000) DESC, votes DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".'<img src="'.XOOPS_URL.'/modules/'.$mydirname.'/images/rating'.round($row['pic_rating']/2000).'.gif" align="absmiddle"/>'.'<br />'.sprintf(_MB_D3XCGAL_FUNC_VOTE, $row['votes']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;

        case '1': // Random pictures
            $result = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK");
                $nbEnr = $xoopsDB->fetchArray($result);
                $pic_count = $nbEnr['count(*)'];
                $xoopsDB->freeRecordSet($result);

                // if we have more than 1000 pictures, we limit the number of picture returned
                // by the SELECT statement as ORDER BY RAND() is time consuming
                if ($pic_count > 1000) {
                    $result = $xoopsDB->query("SELECT count(*) from ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES'");
                        $nbEnr = $xoopsDB->fetchArray($result);
                        $total_count = $nbEnr['count(*)'];
                        $xoopsDB->freeRecordSet($result);

                        $granularity = floor($total_count / 200);
                        $cor_gran = ceil($total_count / $pic_count);
                        srand(time());
                        for ($i=1; $i<= $cor_gran; $i++) $random_num_set =rand(0, $granularity).', ';
                        $random_num_set = substr($random_num_set,0, -2);
                        $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE  randpos IN ($random_num_set) AND approved = 'YES' $ALBUM_SET_BLOCK ORDER BY RAND() LIMIT $count");
                } else {
                        $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY RAND() LIMIT $count");
                }

                $rowset = array();
                while($row = $xoopsDB->fetchArray($result)){
                        $row['caption_text'] = '';
                        $rowset[-$row['pid']] = $row;
                }
                $xoopsDB->freeRecordSet($result);

                $pic_datas = $rowset;
                break;
        case '6': // Top sent ecards
                $select_columns .= ', sent_card';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' AND sent_card >0 $ALBUM_SET_BLOCK ORDER BY sent_card DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".sprintf(_MB_D3XCGAL_FUNC_CARD, $row['sent_card']).'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
        case '7': // Last hits
                $select_columns .= ', mtime';

                $result = $xoopsDB->query("SELECT $select_columns FROM ".$xoopsDB->prefix($mydirname."_pictures")." WHERE approved = 'YES' $ALBUM_SET_BLOCK ORDER BY mtime DESC LIMIT $count");
                //$rowset = d3xcgal_fetch_rowset_block($result);
                $rowset = array();
                while ($row = $xoopsDB->fetchArray($result)) $rowset[] = $row;
                $xoopsDB->freeRecordSet($result);

                if ($set_caption) foreach ($rowset as $key => $row){
                        $caption = "<span style=\" font-weight : bold; font-size: 10px; padding: 2px; display : block;\">".formatTimestamp($row['mtime'],'m').'</span>';
                        $rowset[$key]['caption_text'] = $caption;
                }
                $pic_datas = $rowset;
                break;
        }
    //******************************
    // end d3xcgal_pic_data_block
    //******************************

        $i = 0;
        $piclist=array();
        switch ($album_type){
    case '1':
        $album = "random";
        break;
    case '2':
        $album = "lastup";
        break;
    case '3':
        $album = "topn";
        break;
    case '4':
        $album = "toprated";
        break;
    case '5':
        $album = "lastcom";
        break;
    case '6':
        $album = "mostsend";
        break;
    case '7':
        $album = "lasthits";
        break;

    }

    $module_handler= & xoops_gethandler('module');
    $d3xcgalModule = $module_handler->getByDirname($mydirname);
    $config_handler =& xoops_gethandler('config');
        $d3xcgalConfig =& $config_handler->getConfigsByCat(0, $d3xcgalModule->mid());
        $block = array();
        if (count($pic_datas) > 0) {
                foreach ($pic_datas as $key => $row) {
                        $i++;

                        //$image_size = compute_img_size($row['pwidth'], $row['pheight'], $xoopsModuleConfig['thumb_width']);

                        $thumb_list[$i]['pos'] = $key < 0 ? $key : $i - 1 - $count;
                        $thumb_list[$i]['image'] = "<img src=\"".XOOPS_URL .'/modules/'.$mydirname.'/'.$d3xcgalConfig['fullpath'].str_replace("%2F","/",rawurlencode($row['filepath'].$d3xcgalConfig['thumb_pfx'].$row['filename']))."\" class=\"b_image\" border=\"0\" alt=\"{$row['filename']}\" />";
                        $thumb_list[$i]['caption'] = $row['caption_text'];
                        $thumb_list[$i]['pid'] = $row['pid'];
                        $thumb_list[$i]['link_tgt']="index.php?page=displayimage&pid={$row['pid']}&amp;album={$album}&amp;pos={$key}&amp;cat=";
                    $thumb_list[$i]['i']= $i;

                }

                //$xoopsTpl->assign('no_img',0);
                //theme_display_thumbnails($thumb_list, $thumb_count, $album_name, $album, $cat, $page, $total_pages, is_numeric($album), $display_tabs);
                $block['pics'] = $thumb_list;
                $block['position'] = $position;
                $block['mydirname'] = $mydirname;
        }
        if( empty( $options['disable_renderer'] ) ) {
                require_once XOOPS_ROOT_PATH.'/class/template.php' ;
                $tpl =& new XoopsTpl() ;
                $tpl->assign( 'block' , $block ) ;
                $ret['content'] = $tpl->fetch( $this_template ) ;
                return $ret ;
        } else {
                return $block ;
        }
}

function d3xcgal_block_static_edit($options) {

	$mydirname = empty( $options[0] ) ? 'd3xcgal' : $options[0] ;
	$album_type = empty( $options[1] ) ? 4 : intval( $options[1] ) ;
	$position = empty( $options[2] ) ? 2 : intval( $options[2] ) ;
	$set_caption = empty( $options[3] ) ? 1 : intval( $options[3] ) ;
	$count = empty( $options[4] ) ? 5 : intval( $options[4] ) ;

	if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid mydirname' ) ;

    $form = "<input type='hidden' name='options[0]' value='$mydirname' />";
    $form.= _MB_D3XCGAL_TYPE."&nbsp;<select name='options[1]'>";
    $sel= array();
    for ( $i = 1; $i <= 7; $i++) {
                if ($i == intval($album_type)) $sel[$i] = "selected='selected'";
                else $sel[$i] = "";
        }
        $form.= "<option value='1' $sel[1]>"._MB_D3XCGAL_RANDOM."</option>";
        $form.= "<option value='2' $sel[2]>"._MB_D3XCGAL_NEWST."</option>";
        $form.= "<option value='3' $sel[3]>"._MB_D3XCGAL_VIEW."</option>";
        $form.= "<option value='4' $sel[4]>"._MB_D3XCGAL_TOP."</option>";
        $form.= "<option value='5' $sel[5]>"._MB_D3XCGAL_COMMENTS."</option>";
        $form.= "<option value='6' $sel[6]>"._MB_D3XCGAL_MOSTSENT."</option>";
        $form.= "<option value='7' $sel[7]>"._MB_D3XCGAL_LASTHITS."</option>";
        $form.= "</select>";

        $form.= "<br />"._MB_D3XCGAL_DISPLAY."&nbsp;<select name='options[2]'><option value='1'";
        if ( intval($position) == 1 ) $form .= " selected='selected'";
        $form.= ">"._MB_D3XCGAL_HORIZONTALLY."</option><option value='2'";
        if ( intval($position) == 2 ) $form .= " selected='selected'";
        $form.= ">"._MB_D3XCGAL_VERTICALLY."</option></select>";

        $form .= "<br />"._MB_D3XCGAL_CAPTION."&nbsp;<input type='radio' id='static_cap1' name='options[3]' value='1'";
        if ( intval($set_caption) == 1 ) {
                $form .= " checked='checked'";
        }
        $form .= " />&nbsp;"._YES."&nbsp;<input type='radio' id='static_cap0' name='options[3]' value='0'";
        if ( intval($set_caption) == 0 ) {
                $form .= " checked='checked'";
        }
        $form .= " />&nbsp;"._NO."";
        $form.= "<br />"._MB_D3XCGAL_COUNT."&nbsp;<input type='text' name='options[4]' value='".intval($count)."' />";
    return $form;
}
?>