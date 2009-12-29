<?php
/**
 * @version $Id: d3blogD3commentEntry.class.php 570 2009-01-27 14:57:21Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 * @package a class for d3forum comment integration
 */

require_once XOOPS_TRUST_PATH.'/modules/d3forum/class/D3commentAbstract.class.php' ;

class d3blogD3commentEntry extends D3commentAbstract {

function fetchSummary( $external_link_id )
{
    $db =& Database::getInstance();

    $return = array();
    
    if( preg_match( '/[^0-9a-zA-Z_-]/' , $this->mydirname ) ) die( 'Invalid mydirname' );

    $mydirname = $this->mydirname;  // just to get module instance
    require_once dirname(dirname(__FILE__)).'/include/prepend.inc.php';
    $myModule = call_user_func(array($mydirname, 'getInstance'));

	// PERMISSION
    global $currentUser;
    if($currentUser->blog_perm($myModule->module_id) < D3BLOG_CAN_VIEW) {
        return $return;
    }
	
    $entry_handler =& $myModule->getHandler('entry');
    $criteria = new criteriaCompo(new criteria('bid', intval($external_link_id)));
    $entry = $entry_handler->getOne($criteria);

    if(is_object($entry)){
        $return['dirname'] = htmlspecialchars($mydirname, ENT_QUOTES);
        $return['module_name'] = $myModule->module_name;
        $return['uri'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, htmlspecialchars($mydirname, ENT_QUOTES), intval($external_link_id));  
        $return['subject'] = $entry->title();
        $return['summary'] = $entry->pingExcerpt();
    }

    return $return;
}

function validate_id($link_id)
{
    $link_id = intval($link_id);
    if($link_id <= 0)
        return false;

    $db =& Database::getInstance() ;

    $mydirname = $this->mydirname;  // just to get module instance
    require_once dirname(dirname(__FILE__)).'/include/prepend.inc.php';
    $myModule = call_user_func(array($mydirname, 'getInstance'));
    $entry_handler =& $myModule->getHandler('entry');
    $entry =& $entry_handler->getEntry(intval($link_id), false);
    
    if(is_object($entry))
        return intval($link_id);
    else
        return false;
}

// get id from <{$entry.bid}>
function external_link_id( $params )
{
    $entry = $this->smarty->get_template_vars( 'entry' ) ;
    return intval( $entry['bid'] ) ;
}


// get escaped subject from <{$entry.title}>
function getSubjectRaw( $params )
{
    $entry = $this->smarty->get_template_vars( 'entry' ) ;
    return $this->unhtmlspecialchars( $entry['title'] , ENT_QUOTES ) ;
}

// set forum_dirname from config.com_agent
function setD3forumDirname( $d3forum_dirname = '' )
{
    $this->d3forum_dirname = $this->mod_config['com_agent'] ;
}


// get forum_id from config.com_agent_forumid
function getForumId( $params )
{
    return $this->mod_config['com_agent_forumid'] ;
}


}

?>
