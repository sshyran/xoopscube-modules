<?php
/*
 * $Id: search.inc.php 408 2008-03-26 05:48:54Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require dirname(dirname(__FILE__)).'/include/prepend.inc.php';

eval( '

function '.$mydirname.'_global_search( $keywords , $andor , $limit , $offset , $userid )
{
    return d3blog_global_search_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}

' ) ;

if( ! function_exists( 'd3blog_global_search_base' ) ) {

function d3blog_global_search_base($mydirname, $queryarray, $andor, $limit, $offset, $userid)
{
    global $currentUser;
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $myts =& d3blogTextSanitizer::getInstance();
    
    $return = array();
	
	// PERMISSION
    if(!$currentUser->blog_perm($myModule->module_id)) {
        return $return;
    }
    $usergroup = $currentUser->groups();
	
    $entry_handler =& $myModule->getHandler('entry');
    $criteria =& $entry_handler->getDefaultCriteria(intval($offset), intval($limit));
    // CRITERIA WITH AN ENTRY PERMISSION
	$criteria =& $entry_handler->entryPermCriteria($criteria);
    $criteria->setSort('published');
    $criteria->setOrder('DESC');
    if(!empty($userid))
        $criteria->add(new criteria('uid', intval($userid)));            

    $showcontext = !empty( $_GET['showcontext'] ) ? 1 : 0 ;

    $count = count($queryarray);
    if ( $count > 0 && is_array($queryarray) ) {
        $key_criteria = new criteriaCompo();
        foreach($queryarray as $key) {
            $keyword4sql = addslashes(stripslashes($key));
            $k_criteria = new criteriaCompo();
            $k_criteria->add(new criteria('title', "%$keyword4sql%", 'LIKE'), 'OR');
            $k_criteria->add(new criteria('excerpt', "%$keyword4sql%", 'LIKE'), 'OR');

            // permission by entry
            $body_criteria = new CriteriaCompo(new criteria('body', "%$keyword4sql%", 'LIKE'));
            if($myModule->getConfig('perm_by_entry')) {
                $group_criteria = new CriteriaCompo(new criteria('groups', '%|0|%', 'like'), 'OR');
                foreach($usergroup as $group) {
                    $group_criteria->add(new Criteria('groups', '%|'.$group.'|%', 'like'), 'OR');
                }
                $body_criteria->add($group_criteria);
                unset($group_criteria);
            }
            $k_criteria->add($body_criteria, 'OR');
            
            $key_criteria->add($k_criteria, $andor);
            unset($body_criteria);
            unset($k_criteria);
        }
        $criteria->add($key_criteria);
    }
    $objs =& $entry_handler->getObjects($criteria);
    if(count($objs)) {
        foreach($objs as $obj) {
            $ret['image'] = "images/d3blog.png";
            $ret['link'] = "details.php?bid=".$obj->bid();
            $ret['title'] = $obj->title();
            $ret['time'] = xoops_getUserTimestamp($obj->published(), '');
            $ret['uid'] = $obj->uid();
            if( $showcontext == 1 && function_exists('search_make_context')){
//                $obj->renderContents();
                $ret['context'] = search_make_context($obj->renderContents(true), $queryarray);
            }
            $return[] = $ret;
        }
    }
    return $return;
}


}
?>