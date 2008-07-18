<?php
/**
 * $Id: blocks_archives.php 334 2008-03-07 08:15:44Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright Takeshi Kuriyama <kuri@keynext.co.jp>
 */

/**
 * $options[0] is always weblog dirname.
 * $options[1] = max size of months
 */

function b_d3blog_archives_show($options) {
    global $currentUser, $xoopsConfig;
    $db =& Database::getInstance();

    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' ) ;
    $max_size = intval($options[1]);
    $this_template = empty( $options[2] ) ? 'db:'.$mydirname.'_block_archives.html' : trim( $options[2] );
    $constpref = '_MB_' . strtoupper( $mydirname );

    $offset = isset($_GET['offset'])? intval($_GET['offset']) : 0;
    
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    $block = array();
    if($currentUser->blog_perm_view($myModule->module_id)) {
        $currentuid = $currentUser->uid();
        $useroffset = $currentUser->getTimeoffset();

        if(!defined('_CAL_SUNDAY')) {
            if (file_exists(XOOPS_ROOT_PATH.'/language/'.$xoopsConfig["language"].'/calendar.php')) {
                require_once XOOPS_ROOT_PATH.'/language/'.$xoopsConfig["language"].'/calendar.php';
            } else {
                require_once XOOPS_ROOT_PATH.'/language/english/calendar.php';
            }
        }
        $month_arr = array(
            1 => _CAL_JANUARY,
            2 => _CAL_FEBRUARY,
            3 => _CAL_MARCH,
            4 => _CAL_APRIL,
            5 => _CAL_MAY,
            6 => _CAL_JUNE,
            7 => _CAL_JULY,
            8 => _CAL_AUGUST,
            9 => _CAL_SEPTEMBER,
            10 => _CAL_OCTOBER,
            11 => _CAL_NOVEMBER,
            12 => _CAL_DECEMBER
        );
    
        $sql = "SELECT FROM_UNIXTIME(published+$useroffset, '%Y%m') as thismonth, count(*) as entries FROM ".$db->prefix($mydirname.'_entry');
        // check if user is an editor
        if(!$currentUser->isEditor($myModule->module_id)) {
            $sql .= sprintf(" WHERE (uid=%d OR (approved=1 AND published+%d <= %d))",$currentuid, $useroffset, time());
            $entry_handler =& $myModule->getHandler('entry');
			$criteria =& $entry_handler->entryPermCriteria(null);
			if(is_object($criteria))
                $sql .= ' AND '.$criteria->render();  
        }
        $sql .= " GROUP BY thismonth";
        $sql .= " ORDER BY thismonth DESC";

        $count = $db->getRowsNum( $db->query($sql) );
        $lines = $db->query($sql, $max_size, $offset);
    
        $archives = array();
        $i = 0;
        $months = array();
        while($line = $db->fetchArray($lines)) {
            $months[$i]['year'] = strval(substr($line['thismonth'], 0, 4));
            $months[$i]['month'] = strval(substr($line['thismonth'], 4, 2));
            $months[$i]['monthname'] = $month_arr[intval(substr($line['thismonth'], 4, 2))];
            $months[$i]['entries'] = $line['entries'];
            $i++;
        }
        $archives['months'] = $months; 
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
            $archives['page_navigator'] = $nav->renderNav();
        } else {
            $archives['page_navigator'] = "";
        }

        $archives['currentuid'] = $currentuid;
        $archives['lang_sort_archives'] = constant($constpref.'_LANG_SORT_ARCHIVE');
        $block['mydirname'] = $mydirname4show;
        $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
        $block['archives'] = $archives;
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

function b_d3blog_archives_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_ARCHIVE_NUMBER_PER_PAGE, intval($options[1]));
    $form .= '</table>';
    return $form;
}

?>