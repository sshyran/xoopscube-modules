<?php
/**
 * @version $Id: blocks_bloggers.php 517 2008-08-20 00:57:57Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

function b_d3blog_bloggers_list_show($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    $max_size = intval($options[1]);

    $offset = isset($_GET['offset'])? intval($_GET['offset']) : 0;

    // language prefix
    $constpref = '_MB_' . strtoupper( $mydirname );
    // block template
    $this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_bloggers_list.html' : trim( $options[2] );

    // GET MODULE BASE INFO
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);
    global $currentUser;
    $bloggers =& myPerm::getMembersByName('blog_perm_edit', $myModule->module_id);

    $block = array();
    if($currentUser->blog_perm_view($myModule->module_id)) {
   	    $db =& Database::getInstance();
    	$currentuid = $currentUser->uid();
    	$sql = "SELECT uid, count(uid) as count FROM ".$db->prefix($mydirname.'_entry');
        $sql .= sprintf(' WHERE uid in(%s)', implode(',', array_keys($bloggers)));
        // check if user is a editor
        if(!$currentUser->isEditor($myModule->module_id)) {
            $sql .= sprintf(" AND (uid=%d OR (approved=1 AND published <= %d))", $currentuid, time());
            $entry_handler =& $myModule->getHandler('entry');
            $criteria =& $entry_handler->entryPermCriteria(null);
            if(is_object($criteria))
                $sql .= ' AND '.$criteria->render();  
        }
        $sql .= " GROUP BY uid";
        $sql .= " ORDER BY uid ASC";

        $count = $db->getRowsNum( $db->query($sql) );
        $lines = $db->query($sql, $max_size, $offset);

        $bloggers_list = array();
        while($line = $db->fetchArray($lines)) {
            $bloggers_list[intval($line['uid'])]['name'] = $bloggers[intval($line['uid'])]->getVar('uname');
            $bloggers_list[intval($line['uid'])]['handlename'] = $bloggers[intval($line['uid'])]->getVar('name');
            $bloggers_list[intval($line['uid'])]['title'] = sprintf(constant($constpref.'_LANG_READ_ENTRIES_OF_BLOGGER'), $bloggers[intval($line['uid'])]->getVar('uname'));
            $bloggers_list[intval($line['uid'])]['count'] = intval($line['count']);
            if($myModule->getConfig('show_avatar')) {
                $avatar = $bloggers[intval($line['uid'])]->getVar('user_avatar');
                $bloggers_list[intval($line['uid'])]['avatar'] = array();
                if (!empty($avatar) && $avatar != 'blank.gif') {
                    $bloggers_list[intval($line['uid'])]['avatar']['url'] = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, XOOPS_UPLOAD_PATH.'/'.$avatar);
                    $dimension = getimagesize( XOOPS_UPLOAD_PATH.'/'.$avatar);
                    if(is_array($dimension)) {
                        $bloggers_list[intval($line['uid'])]['avatar']['width'] = $dimension[0];
                        $bloggers_list[intval($line['uid'])]['avatar']['height'] = $dimension[1];
                    }
                }
            }
        }
        $block['bloggers'] = $bloggers_list; 

        // add page navigator if entries > per page
        if( $count > $max_size ) {
            if( !empty($_SERVER['QUERY_STRING'])) {
                if( ereg("^offset=[0-9]+$", $_SERVER['QUERY_STRING']) ) {
                    $url = "";
                } else {
                    $url = preg_replace("/^(.*)\&offset=[0-9]+$/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = "";
            }
            include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
            $nav = new XoopsPageNav($count, $max_size, $offset, "offset", $url);
            $block['page_navigator'] = $nav->renderNav();
        } else {
            $block['page_navigator'] = "";
        }

        $block['mydirname'] = $mydirname4show;
        $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
        $block['moduleConfig'] = $myModule->module_config;
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
    
function b_d3blog_bloggers_list_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_NUMBER_OF_BLOGGERS, intval($options[1]));
    $form .= '</table>';
    return $form;
}

?>
