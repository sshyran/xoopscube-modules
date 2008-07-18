<?php
/**
 * @version $Id: blocks_latest_entries.php 449 2008-06-03 16:11:16Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 * @copyright (c) 2007 by Takeshi Kuriyama <kuri@keynext.co.jp>
 */

/*
 * $options[1] = number of entries to show
 * $options[2] = max size of the title
 * $options[3] = date format
 * $options[4] = type (1=list, 2=table)
 * $options[5] = show entry content(0:no, 1:excerpt, 2:whole contents)
 * $options[6] = show but the latest entry only
 * $options[7] = max size of entry.(0:no limits)
 * $options[8] = original template file
 */

function b_d3blog_latest_entries_show($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );

    // GET MODULE INFO
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

    $max_entries = !empty($options[1])? intval($options[1]) : 5;
    $title_max_size = !empty($options[2])? intval($options[2]) : 25;
    $date_format = !empty($options[3])? trim($options[3]) : 'Y/m/d';
    $block_type = !empty($options[4])? intval($options[4]) : 1;
    $show_contents = !empty($options[5])? intval($options[5]) : 0;
    $show_first_only = !empty($options[6])? intval($options[6]) : 0;
    $contents_max_size = !empty($options[7])? intval($options[7]) : 0;
    $show_avatar = $myModule->getConfig('show_avatar')? 1 : 0;
    $this_template = empty( $options[8] ) ? 'db:'.$mydirname.'_block_latest_entries.html' : trim( $options[8] );

    $constpref = '_MB_' . strtoupper( $mydirname );

    $block = array();

	// CURRENT USER'S INFO 
	global $currentUser; 

    if($currentUser->blog_perm_view($myModule->module_id)) {
        $entry_handler =& $myModule->getHandler('entry');
        // CRITERIA WITH AN ENTRY PERMISSION
		$criteria =& $entry_handler->getDefaultCriteria(0, $max_entries);
		$criteria =& $entry_handler->entryPermCriteria($criteria);
		$criteria->setSort('published');
        $criteria->setOrder('DESC');
        $objs =& $entry_handler->getObjects($criteria);

        $entries = array();
        $first = true;
        $cat_handler =& $myModule->getHandler('category');
        $catall =& $cat_handler->getAll();

        $myts =& d3blogTextSanitizer::getInstance();
        
        foreach($objs as $obj) {
            $entry = $obj->getStructure();
            // shorten title
            if(strlen($entry['title']) > $title_max_size) {
                $entry['title'] = xoops_substr($entry['title'], 0, ($title_max_size -1)) ;
            }
        
            // date format
            $entry['date'] = formatTimestamp($entry['published'], $date_format);
        
            unset($entry['contents']);
            // contents
            if($show_contents) {
                if(!$show_first_only || $first) {
                    $first = false;
                    $contents = $obj->getVar('excerpt', 'n');
                    $body = $obj->getVar('body', 'n');
                    if(!empty($body) && $obj->canReadBody()) {
                        if($show_contents == 2) {
                            $contents .= "\n".$body;
                        } elseif($show_contents == 1) {
                            $entry['readMore'] = 1;                       	
                        }
                    }
                    // truncate ? then strip tags
                    if($contents_max_size > 0) {
                        $entry['contents'] = xoops_substr(strip_tags($myts->displayTarea(strip_tags($contents), $obj->dohtml(), 1, $obj->doxcode(), $obj->doimage(), $obj->dobr())), 0, $contents_max_size, '...');
                    } else {
                    	$entry['contents'] = $myts->displayTarea($contents, $obj->dohtml(), 1, $obj->doxcode(), $obj->doimage(), $obj->dobr());
                    }
                }
            }

            if(is_object($catall[$obj->cid()])) {
                $category =& $catall[$obj->cid()];
                $entry['category'] = $category->getArray();
            }

            $entries[] = $entry;
        }

        $block['mydirname'] = $mydirname4show;
        $block['mod_url'] = sprintf('%s/modules/%s', XOOPS_URL, $mydirname4show);
        $block['moduleConfig'] = $myModule->module_config;
        $block['currentUser'] =& $currentUser->getStructure();
        $block['currentUser']['user_perm'] =& $currentUser->userPermNames($myModule->module_id);
        $block['entries'] = $entries;
        $block['block_type'] = $block_type;
        $block['show_contents'] = $show_contents;
        $block['show_avatar']= $show_avatar;
        $block['lang_latestblogs_summary'] = constant($constpref.'_SUMMARY_LATEST_BLOGS');
        $block['lang_category'] = constant($constpref.'_LANG_CATEGORY');
        $block['lang_title'] = constant($constpref.'_LANG_TITLE');
        $block['lang_author'] = constant($constpref.'_LANG_AUTHOR');
        $block['lang_comments'] = constant($constpref.'_LANG_COMMENTS');
        $block['lang_trackbacks'] = constant($constpref.'_LANG_TRACKBACKS');
        $block['lang_posted'] = constant($constpref.'_LANG_POSTED');
        $block['lang_counter'] = constant($constpref.'_LANG_COUNTER');
        $block['lang_blogtop'] = sprintf(constant($constpref.'_LANG_BLOGTOP'), $myModule->module_name);
        $block['lang_readmore'] = constant($constpref.'_LANG_READMORE');
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

function b_d3blog_latest_entries_edit($options) {
    $mydirname = empty( $options[0] ) ? basename(dirname(dirname( __FILE__ ))) : $options[0];
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $mydirname ) ) die( 'Invalid dirname' );
    $form  = '<table>';
    $form .= "<input type='hidden' name='options[]' value='".htmlspecialchars($mydirname, ENT_QUOTES)."' />\n" ;
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_NUMBER_OF_ENTRIES, intval($options[1]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_MAX_TITLE_LENGTH, intval($options[2]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%s" /></td></tr>',
                     _MB_D3BLOG_EDIT_DATE_FORMAT, $options[3]);
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%s" /></td></tr>',
                     _MB_D3BLOG_EDIT_TYPE, $options[4]);
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_SHOW_CONTENTS, intval($options[5]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_FIRST_ONLY, $options[6]);
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d" /></td></tr>',
                     _MB_D3BLOG_EDIT_MAX_CONTENTS_LENGTH, intval($options[7]));
    $form .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%s" /></td></tr>',
                     _MB_D3BLOG_EDIT_TEMPLATE, htmlspecialchars($options[8], ENT_QUOTES));
    $form .= '</table>';
    return $form;
}

?>