<?php
/**
 * @version $Id: blocks_latest_comments.php 488 2008-07-18 10:27:01Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

/**
 * $options[0] = mydirname
 * $options[1] = max number of comments to show
 * $options[2] = max size of the title
 * $options[3] = date format
 * $options[4] = type (1=list, 2=table)
 */

function b_d3blog_latest_comments_show($options) {
    global $currentUser, $xoopsConfig ;
    $db =& Database::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $mydirname = empty( $options[0] ) ? basename(dirname( dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $max_comments = intval($options[1]);
    $max_titlesize = intval($options[2]);
    $date_format = $options[3];
    $block_type = $options[4];
    $this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_latest_comments.html' : trim( $options[5] );

    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    $block = array();

    include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
    if (XOOPS_COMMENT_APPROVENONE == $myModule->getConfig('com_rule')) {
    	return $block;
    }
 
    if($currentUser->com_perm_view($myModule->module_id)) {
        $constpref = '_MB_' . strtoupper( $mydirname ) ;
        $currentuid = $currentUser->uid();

        $block['comments'] = array();

        $sql = sprintf("SELECT c.com_id, c.com_modified, c.com_uid, c.com_title, c.com_itemid, e.title, e.excerpt, u.uname FROM %s c LEFT JOIN %s e ON c.com_itemid=e.bid LEFT JOIN %s u ON c.com_uid=u.uid" , 
                    $db->prefix('xoopscomments'), $db->prefix($mydirname.'_entry'), $db->prefix('users'));
        $sql .= " WHERE (c.com_modid=$myModule->module_id AND c.com_status=2)";

        // filter
        $uid = isset($_GET['uid'])? intval($_GET['uid']) : 0;
        if(!empty($uid)) {
            $sql .= " AND e.uid = $uid";
        }

        // check if user is an editor
        if(!$currentUser->isEditor($myModule->module_id)) {
			$entry_handler =& $myModule->getHandler('entry');
            $criteria =& $entry_handler->getDefaultCriteria(0, 0, 'e');
			$criteria =& $entry_handler->entryPermCriteria($criteria, false, 'e');
            $sql .= ' AND '.$criteria->render();
        }
        $sql .= " ORDER BY c.com_modified DESC"; 

        $result = $db->query($sql, $max_comments, 0);
        while ($row = $db->fetchArray($result)) {
            $comment = array();
            $com_title = $myts->htmlSpecialChars($row['com_title']);
            if ( $block_type == 2) {
                $com_title = xoops_substr($com_title, 0, $max_titlesize);
            }
            $comment['com_title'] = $com_title;
            $comment['date'] = formatTimestamp(intval($row['com_modified']), $date_format);
            $comment['entry_url'] = sprintf('%s/modules/%s/details.php?bid=%d#comment%d', XOOPS_URL, $mydirname, intval($row['com_itemid']), intval($row['com_id']));
            $comment['entry_title'] = $myts->htmlSpecialChars($row['title']);
            $comment['com_uname'] = ( $row['com_uid'] == 0 )? $xoopsConfig['anonymous'] : $myts->htmlSpecialChars($row['uname']);
            if( $row['com_uid'] != 0 )
                $comment['profile_uri'] = sprintf('%s/userinfo.php?uid=%d', XOOPS_URL, intval($row['com_uid']));
            $block['comments'][] = $comment;
        }

        $block['mydirname'] = $mydirname4show;
        $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
        $block['type'] = $block_type;
        $block['lang_comuname'] = constant($constpref.'_LANG_COM_UNAME');
        $block['lang_comtitle'] = constant($constpref.'_LANG_COM_TITLE');
        $block['lang_entrytitle'] = constant($constpref.'_LANG_COM_ENTRYTITLE');
        $block['lang_posted'] = constant($constpref.'_LANG_COM_POSTED');
        $block['lang_comments_summary'] = constant($constpref.'_SUMMARY_COMMENTS_LIST');
    }

    if(empty($options['disable_renderer'])) {
        require_once XOOPS_ROOT_PATH.'/class/template.php';
        $tpl = new XoopsTpl();
        $tpl->assign('block', $block);
        $ret['content'] = $tpl->fetch($this_template);
        return $ret ;
    } else {
        return $block ;
    }

}

function b_d3blog_latest_comments_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_NUMBER_OF_COMMENTS, intval($options[1]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_MAX_TITLE_LENGTH, intval($options[2]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%s" /></td></tr>',
                     _MB_D3BLOG_EDIT_DATE_FORMAT, $options[3]);
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%s" /></td></tr>',
                     _MB_D3BLOG_EDIT_TYPE, $options[4]);
    $form .= '</table>';
    return $form;
}

?>
