<?php
/**
 * @version $Id: blocks_latest_trackbacks.php 488 2008-07-18 10:27:01Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

/**
 * $options[0] = mydirname
 * $options[1] = max number of trackbacks to show
 * $options[2] = max length of the title
 * $options[3] = date format
 * $options[4] = type (1=list, 2=table)
 */

function b_d3blog_latest_trackbacks_show($options) {
    global $currentUser, $xoopsConfig ;
    $db =& Database::getInstance();

    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    
    $max_trackbacks = $options[1];
    $max_titlelength = $options[2];
    $date_format = $options[3];
    $block_type = $options[4];
    $this_template = empty( $options[5] ) ? 'db:'.$mydirname.'_block_latest_trackbacks.html' : trim( $options[5] );

    $constpref = '_MB_' . strtoupper( $mydirname );

    // GET MODULE INFO
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    $block = array();

    if($currentUser->com_perm_view($myModule->module_id)) {
        $currentuid = $currentUser->uid();

        $myts =& MyTextSanitizer::getInstance();

        $block['trackbacks'] = array();
        $sql = sprintf("SELECT e.uid, t.bid, t.tid, t.url, t.blog_name, t.title, t.created, e.title as entry_title, e.excerpt FROM %s t LEFT JOIN %s e ON t.bid=e.bid",
                   $db->prefix($mydirname.'_trackback') ,$db->prefix($mydirname.'_entry'));
        $sql .= " WHERE (t.direction=2 AND t.approved=1)";

        // filter
        $uid = isset($_GET['uid'])? intval($_GET['uid']) : 0;
        if(!empty($uid)) {
            $sql .= " AND e.uid = $uid";
        }

        // check if user is an editor
        if(!$currentUser->isEditor($myModule->module_id)) {
			$entry_handler =& $myModule->getHandler('entry');
			$criteria =& $entry_handler->entryPermCriteria(null, false, 'e');
			if(is_object($criteria))
                $sql .= ' AND '.$criteria->render();
        }
        $sql .= ' ORDER BY t.created DESC';

        $result = $db->query($sql, $max_trackbacks, 0);
        while ($row = $db->fetchArray($result)) {
            $trackback = array();
            $tb_title = $myts->htmlSpecialChars($row['title']);
            if ( $block_type == 2) {
                $tb_title = xoops_substr($tb_title, 0, $max_titlelength);
            }
            $trackback['tb_title'] = $tb_title;
            $trackback['blog_name'] = $myts->htmlSpecialChars($row['blog_name']);
            $trackback['url'] = $myts->htmlSpecialChars($row['url']);
            $trackback['entry_url'] = sprintf('%s/modules/%s/details.php?bid=%d#trackback%d', XOOPS_URL, $mydirname4show, intval($row['bid']), intval($row['tid']));
            $trackback['date'] = formatTimestamp(intval($row['created']), $date_format);
            $trackback['entry_title'] = $myts->htmlSpecialChars($row['entry_title']);
            $block['trackbacks'][] = $trackback;
        }

        $block['mydirname'] = $mydirname4show;
        $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
        $block['type'] = $block_type;
        $block['lang_latesttrackbacks_summary'] = constant($constpref.'_SUMMARY_LATEST_TRACKBACKS');
        $block['lang_tbtitle'] = constant($constpref.'_LANG_TB_TITLE');
        $block['lang_entrytitle'] = constant($constpref.'_LANG_TB_ENTRYTITLE');
        $block['lang_blogname'] = constant($constpref.'_LANG_TB_BLOGNAME');
        $block['lang_posted'] = constant($constpref.'_LANG_TB_POSTED');
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

function b_d3blog_latest_trackbacks_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_NUMBER_OF_TRACKBACKS, intval($options[1]));
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
