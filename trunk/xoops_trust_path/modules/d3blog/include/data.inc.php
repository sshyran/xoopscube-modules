<?php
/**
 * @version $Id: data.inc.php 459 2008-06-06 02:54:38Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require dirname(dirname(__FILE__)).'/include/prepend.inc.php';

eval( '
    function '.$mydirname.'_new($limit=0, $offset=0) {
        return d3blog_new_base( "'.$mydirname.'", $limit , $offset );
    }
' );

if( ! function_exists( 'd3blog_new_base' ) ) {

    function d3blog_new_base( $mydirname, $limit=0, $offset=0 )
    {
        $return = array();
        $myts =& d3blogTextSanitizer::getInstance();
        $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);

        $myModule = call_user_func(array($mydirname, 'getInstance'));

        global $currentUser;
        if(!$currentUser->blog_perm_view($myModule->module_id)) {
        	return $return;
    	}
	            
        $entry_handler =& $myModule->getHandler('entry');
        $cat_handler =& $myModule->getHandler('category');
        $catall =& $cat_handler->getAll();

        $criteria =& $entry_handler->getDefaultCriteria(intval($offset), intval($limit));
        // CRITERIA WITH AN ENTRY PERMISSION
		$criteria =& $entry_handler->entryPermCriteria($criteria);
        $criteria->setSort('published');
        $criteria->setOrder('DESC');

        $objs =& $entry_handler->getObjects($criteria);

        if(count($objs)) {
            $xoops_comment = false;
            $com_agent = false;
            // check if xoops comment is available
            if($myModule->getConfig('com_rule') != 0) { // 0 means XOOPS_COMMENT_APPROVENONE
            	$xoops_comment = true;
                $com_counts = array();
                // check if d3comment agent
                if($myModule->getConfig('com_agent') != $mydirname) {
                    $com_agent = true;
                    // check if the com agent exists and is active
                    $module_hanlder =& xoops_gethandler('module');
                    $module =& $module_hanlder->getByDirname($myModule->getConfig('com_agent'));
                    if(is_object($module) && $module->getVar('isactive')) {
                        // fetch comments count from the comment agent
                        foreach($objs as $obj) {
                        	$link_ids[] = $obj->bid();
                        }
                        $db =& Database::getInstance();
                        $sql = sprintf('SELECT SUM(topic_posts_count) AS count, topic_external_link_id AS blogid FROM %s WHERE forum_id = %d AND ! topic_invisible AND topic_external_link_id IN (%s) GROUP BY topic_external_link_id ORDER BY topic_external_link_id',
                            $db->prefix($module->getVar('dirname').'_topics'),
                            $myModule->getConfig('com_agent_forumid'),
                            implode(',', $link_ids)
                        );
                        if(!$result = $db->query($sql))
                            die('whatsnew d3comment_error in '.__LINE__);
                        while($row = $db->fetchArray($result)) {
                            $com_counts[intval($row['blogid'])] = intval($row['count']);
                        }    
                    }
                }
            }

            foreach($objs as $obj) {
                $ret['cat_name'] = $catall[$obj->cid()]->getVar('name');
                $ret['id'] = $obj->bid();
                $ret['link'] = sprintf("%s/modules/%s/details.php?bid=%d", XOOPS_URL, $mydirname4show, $obj->bid());
                $ret['cat_link'] = sprintf("%s/modules/%s/index.php?cid=%d", XOOPS_URL, $mydirname4show, $obj->cid());
                $ret['title'] = $obj->title();
                $ret['time']  = $obj->published();
                $ret['uid'] = $obj->uid();
                $ret['hits'] = $obj->counter();
                $ret['replies'] = $com_agent? $com_counts[$obj->bid()] : ($xoops_comment? $obj->comments() : 0);
                $ret['description'] = $obj->renderContents(false);
                $return[] = $ret;
            }
        }
        return $return;
    }
}

eval( '
    function '.$mydirname.'_num() {
        return d3blog_num_base( "'.$mydirname.'" ) ;
    }
' ) ;

if( ! function_exists( 'd3blog_num_base' ) ) {
    function d3blog_num_base( $mydirname ) {
        $myModule = call_user_func(array($mydirname, 'getInstance'));

        $entry_handler =& $myModule->getHandler('entry');

        $criteria =& $entry_handler->getDefaultCriteria();
        
        $num =& $entry_handler->getCount($criteria);

        return $num;
    }
}

eval( '
    function '.$mydirname.'_data( $limit=0, $offset=0 )
    {
        return d3blog_data_base( "'.$mydirname.'", $limit=0, $offset=0 ) ;
    }
' ) ;

if( ! function_exists( 'd3blog_data_base' ) ) {

    function d3blog_data_base($mydirname, $limit=0, $offset=0)
    {
        $myModule = call_user_func(array($mydirname, 'getInstance'));
        $mydirname4show = htmlspecialchars($mydirname, ENT_QUOTES);
        
        $entry_handler =& $myModule->getHandler('entry');
        $cat_handler =& $myModule->getHandler('category');
        $catall =& $cat_handler->getAll();

        $criteria =& $entry_handler->getDefaultCriteria(intval($offset), intval($limit));
        $criteria->setSort('published');
        $criteria->setOrder('DESC');
        
        $objs =& $entry_handler->getObjects($criteria);

        $return = array();
        if(count($objs)) {
            foreach($objs as $obj) {
                $ret['category'] = $catall[$obj->cid()]->getVar('name');
                $ret['id'] = $obj->bid();
                $ret['link'] = sprintf("%s/modules/%s/details.php?bid=%d", XOOPS_URL, $mydirname4show, $obj->bid());
                $ret['title'] = $obj->title();
                $ret['time']  = $obj->published();
                $return[] = $ret;
            }
        }
        return $return;
    }
}

?>