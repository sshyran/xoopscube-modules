<?php
/**
 * @version $Id: entry.class.php 664 2010-10-20 13:56:43Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

if( ! class_exists('d3blogEntryObjectBase') ) {

require_once dirname(dirname(__FILE__)).'/lib/object.php';
require_once dirname(dirname(__FILE__)).'/include/filter/EntryFilter.class.php';

class d3blogEntryObjectBase extends myXoopsObject {
    var $mydirname_;

    function d3blogEntryObjectBase($id=null)
    {
        $this->initVar("bid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("cid", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar("excerpt", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("body", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("groups", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("comments", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("counter", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("trackbacks", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("approved", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("notified", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("tb_acceptable", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("published", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("modified", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("created", XOBJ_DTYPE_INT, time(), false);
        $this->initVar("uid", XOBJ_DTYPE_INT, 0, true);
        if ( is_array ( $id ) ) {
            $this->assignVars ( $id );
        }
        $this->mydirname_ = ''; // abstract
    }

    function setDefault(&$user)
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

        $this->setVar('uid', $user->uid());
        $this->setVar('dohtml', ($user->allow_html() && $myModule->getConfig('dohtml_by_default'))? 1 : 0);
        $this->setVar('doxcode', $myModule->getConfig('doxcode_by_default')? 1 : 0);
//    	$this->setVar('doimage', $user->allow_html()? 0 : 1);
        $this->setVar('dobr', ($user->allow_html() && !$myModule->getConfig('dobr_by_default'))? 0 : 1);
        $this->setVar('approved', $user->blog_autoapprove()? 1 : 0);
        $this->setVar('notified', $user->blog_autoapprove()? 1 : 0);
        $this->setVar('groups', '|'.implode('|', is_array($myModule->getConfig('default_groups'))? $myModule->getConfig('default_groups') : array('1')).'|');

    }

    function bid() {
        return $this->getVar('bid');
    }

    function cid() {
        return $this->getVar('cid');
    }

    function title() {
        return $this->getVar('title');
    }

    function excerpt() {
        return $this->getVar('excerpt');
    }

    function body() {
        return $this->getVar('body');
    }

    function dohtml() {
        return $this->getVar('dohtml');
    }

    function dobr() {
        return $this->getVar('dobr');
    }

    function doxcode() {
        return $this->getVar('doxcode');
    }

    function doimage() {
        return $this->getVar('doimage');
    }

    function groups() {
        $groups = $this->getVar('groups');
        if($groups == '|0|') {
            $member_handler =& xoops_gethandler('member');
            $glist =& $member_handler->getGroupList();
            return array_keys($glist);
        }
        return array_filter(explode('|', $groups));
    }

    function setDefaultGroups() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $default = $myModule->getConfig('default_groups');
        $member_handler =& xoops_gethandler('member');
        $glist =& $member_handler->getGroupList();
        if(!is_array($default) || empty($default)) {
            $groups = '|1|';
        } elseif(!count(array_diff(array_keys($glist), $default))) {
            $groups = '|0|';
        } else {
            $groups = '|'.implode('|', $default).'|';
        }
        return $this->setVar('groups', $groups);
    }

    function resetGroups($group=null) {
        if($group == null)
            $group = $this->groups();
        $member_handler =& xoops_gethandler('member');
        $glist =& $member_handler->getGroupList();
        if(!is_array($group) || empty($group)) {
            $groups= '|1|';
        } elseif(!count(array_diff(array_keys($glist), $group))) {
            $groups= '|0|';
        } else {
            return false;
        }

        if($this->getVar('groups') != $groups) {
            $this->setVar('groups', $groups);
            return true;
        } else {
            return false;
        }
    }

    function comments() {
        return $this->getVar('comments');
    }

    function counter() {
        return $this->getVar('counter');
    }

    function trackbacks() {
        return $this->getVar('trackbacks');
    }

    function approved() {
        return $this->getVar('approved');
    }

    function notified() {
        return $this->getVar('notified');
    }

    function setNotified() {
        $this->setVar('notified', 1);
    }

    function published() {
        return $this->getVar('published');
    }

    function modified() {
        return $this->getVar('modified');
    }

    function created() {
        return $this->getVar('created');
    }

    function uid() {
        return $this->getVar('uid');
    }

    function uname() {
        $blogger = $this->blogger();
        if(is_object($blogger))
            return $blogger->getVar('uname');
        else
            return '';
    }

    function blogger() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $bloggers =& myPerm::getMembersByName('blog_perm_edit', $myModule->module_id);
        if(in_array($this->uid(), array_keys($bloggers)))
            return $bloggers[$this->uid()];
        else
            return null;
    }

    function isApproved() {
        return $this->approved();
    }

    function isNotified() {
        return $this->notified();
    }

    function newlyApproved() {
        if($this->isApproved() && $this->vars['approved']['changed'])
            return true;
        else
            return false;
    }

    function isTrackbackAcceptable() {
        return $this->getVar('tb_acceptable');
    }

    function trackbackUrl() {
        // (ex. IIS)
        if( (isset( $_SERVER['SERVER_SOFTWARE'] ) && preg_match("/Microsoft-IIS/i",$_SERVER['SERVER_SOFTWARE'])) || ! isset( $_SERVER['REQUEST_URI'] ) ){
            $delimiter = "?" ;
        }else{
            $delimiter = "/" ;
        }
        return sprintf('%s/modules/%s/tb.php%s%d', XOOPS_URL, $this->mydirname_, $delimiter, $this->bid());
    }

    function divideContents(&$text) {
        $arr = preg_split("/((\015\012)|(\015)|(\012))?\[separator\]((\015\012)|(\015)|(\012))?/", $text );
        $this->setVar ( 'excerpt', array_shift($arr) );
        $this->setVar ( 'body', implode('', $arr) );
    }

    function reuniteContents($type='e') {
        if(strlen($this->getVar('body'))) {
            return $this->getVar('excerpt', $type) . "\n[separator]\n" . $this->getVar('body', $type);
        } else {
            return $this->getVar('excerpt', $type);
        }
    }

    function embeddedRDF() {
        $data['url'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $this->mydirname_, $this->bid());
        $data['title'] = $this->getVar('title');
        $data['excerpt'] = $this->pingExcerpt();
        $blogger = $this->blogger();
        if(is_object($blogger))
            $data['author'] = $blogger->getVar('uname');
        else
            $data['author'] = '';
        $data['trackback_url'] = $this->trackbackUrl();
        $data['date'] = d3blog_iso8601_date($this->published());

        $res = <<<EOD
<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/">
    <rdf:Description
        rdf:about="%s"
        dc:identifier="%s"
        dc:title="%s"
        dc:excerpt="%s"
        dc:author="%s"
        dc:date="%s"
        trackback:ping="%s" />
</rdf:RDF>
EOD;
        $res = sprintf($res, $data['url'], $data['url'], $data['title'], $data['excerpt'], $data['author'], $data['date'], $data['trackback_url']);
        return "<!--\n".$res."\n-->\n";
    }

    function pingExcerpt($length=255, $strip_tags=true) {
        $myts =& d3blogTextSanitizer::getInstance();
        $length = intval($length);
        if($length > 0) {
            $strip_tags = true;
        }

        $excerpt = $myts->displayTarea($this->getVar('excerpt', 'n'), $this->dohtml(), 1, $this->doxcode(), $this->doimage(), $this->dobr());
        if($strip_tags) {
            $excerpt = strip_tags($excerpt);
        }

        if($length > 0) {
            return xoops_substr($excerpt, 0, $length, '...');
        }

        return $excerpt;
    }

    function renderContents($strip_tags=true, $type='s') {
        $myts =& d3blogTextSanitizer::getInstance();

        $contents = $this->getVar('excerpt', 'n');
        $body = $this->getVar('body', 'n');
        if(!empty($body)) {
            if(false != $this->canReadBody()) {
                $contents .= "\n".$body;
            }
        }

        if($type == 's') {
            if($strip_tags)
                return strip_tags($myts->displayTarea($contents, $this->dohtml(), 1, $this->doxcode(), $this->doimage(), $this->dobr()));
            else
                return $myts->displayTarea($contents, $this->dohtml(), 1, $this->doxcode(), $this->doimage(), $this->dobr());
        } elseif($type == 'e') {
            return htmlspecialchars($contents, ENT_QUOTES);
        } else {
            return $contents;
        }
    }

    function canReadBody() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

        if(($myModule->getConfig('perm_by_entry') && $this->isPermedGroup()) || !$myModule->getConfig('perm_by_entry')) {
            return true;
        } else {
            return false;
        }
    }

    function isPermedGroup() {
        global $currentUser;
        return count(array_intersect($this->groups(), $currentUser->groups()));
    }

    function blog_name() {
        return htmlspecialchars(sprintf('%s - %s', $GLOBALS['xoopsConfig']['sitename'], $this->mydirname_), ENT_QUOTES);
    }

    function incrementViewCounter() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $handler =& $myModule->getHandler('entry');
        $this->setVar('counter', $this->counter() + 1 );
        return $handler->insert($this, true);
    }

    function update(&$form)
    {
        global $xoopsConfig, $xoopsUser;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

        $entry_handler =& $myModule->getHandler('entry');
        $cat_handler =& $myModule->getHandler('category');
        $category = $cat_handler->get($this->cid());

        $notification_handler =& xoops_gethandler('notification');

        $tags = array(
            'TITLE' => $this->title(),
            'CAT_TITLE' => $category->name(),
            'ENTRY_URI' => sprintf('%s/modules/%s/details.php?bid=%u', XOOPS_URL, $this->mydirname_, $this->bid())
        );

        if($this->isNew()) {
            $form->bid_ = $this->bid();
            if(is_object($xoopsUser))
                $tags['BLOGGER_NAME'] = $xoopsUser->uname();
            else
                $tags['BLOGGER_NAME'] = $xoopsConfig['anonymous'];

            if($this->isApproved()) {
                // NOTIFY SUBSCRIBERS ON A NEW ENTRY PUBLISHED
                $notification_handler->triggerEvent('global', 0, 'new_entry', $tags);
                $this->setNotified();

                // INCREMENT USER'S POSTS
                if($myModule->getConfig('increment_userpost')) {
                    if(is_object($xoopsUser))
                        $xoopsUser->incrementPost();
                }
            } else {
                // NOTIFY ADMINSTRATORS ON AN APPROVAL REQUEST
                $tags['WAITING_URI'] = sprintf('%s/modules/%s/admin/index.php?page=approval_manager', XOOPS_URL, $this->mydirname_);
                $notification_handler->triggerEvent('global', 0, 'entry_submit', $tags, array_keys(myPerm::getUsersByName('blog_editor')));
            }
        } else {
            if( $this->newlyApproved() ) {
                // INCREMENT OWNER'S POSTS
                if($myModule->getConfig('increment_userpost')) {
                    if($this->uid() > 0) {
                        if($this->uid() == $xoopsUser->uid()) {
                            $xoopsUser->incrementPost();
                        } else {
                            $member_handler =& xoops_gethandler('member');
                            $blogger = $member_handler->getUser($this->uid());
                            if(is_object($blogger))
                                $blogger->incrementPost();
                        }
                    }
                }

                // NOTIFY THE BLOGGER ON APPROVAL and SUBSCRIBERS ON NEW ENTRY PUBLISHED
                if(!$this->isNotified()) {
                    $tags['BLOGGER_NAME'] = $this->uname();
                    $notification_handler->triggerEvent( 'global', 0, 'new_entry', $tags );
                    $notification_handler->triggerEvent( 'entry', $this->bid(), 'approved', $tags);

                    $this->setNotified();
                }
            }
        }

        if(!$this->isApproved() && !$this->isNotified() && $form->subscribe_) {
            $events =& $notification_handler->getSubscribedEvents ('entry', $this->bid(), $myModule->module_id, $this->uid());

            // SUBSCRIBE NOTIFICATION of APPROVAL
            if(!in_array('approved', $events)) {
                //require_once XOOPS_ROOT_PATH.'/include/notification_constants.php';
                $notification_handler->subscribe('entry', $this->bid(), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
            }
        }

        // DELETE OUTBOUND/INBOUND TRACKBACKS
        $delete_ids = array();
        // outbound
        if(isset($form->delete_sent_) && is_array($form->delete_sent_)) {
            $delete_ids = array_keys($form->delete_sent_);
            if(isset($form->tb_url_)) {
                foreach($delete_ids as $del_id) {
                    if(in_array($del_id, array_keys($form->tb_url_)))
                        unset($form->tb_url_[intval($del_id)]);
                }
            }
        }
        // inbound
        if(isset($form->delete_rcvd_) && is_array($form->delete_rcvd_)) {
            $delete_ids = array_merge($delete_ids, array_keys($form->delete_rcvd_));
        }

        // delete trackback data altogether
        $tb_handler =& $myModule->getHandler('trackback');
        if(count($delete_ids)) {
            $tb_criteria = new criteriaCompo();
            $tb_criteria->add(new criteria('tid', '('.implode(',', $delete_ids).')', 'IN'));
            $tb_handler->deletes($tb_criteria);
        }

        // APPROVE INBOUND TRACKBACKS
        if($myModule->getConfig('trackback_approval')) {
            if(isset($form->approve_rcvd_) && is_array($form->approve_rcvd_)) {
                $criteria = new criteriaCompo();
                foreach(array_keys($form->approve_rcvd_) as $tid) {
                    $criteria->add(new criteria('tid', $tid), 'OR');
                }
                $tbs =& $tb_handler->getObjects($criteria);
                foreach($tbs as $tb) {
                    $tb->setVar('approved', 1);
                    $tb_handler->insert($tb);
                }
            }
        }

        $this->setVar('modified', time());
        // Anyway, re-calculate trackback count
           $this->synchronizeTrackbacks();
        $this->unsetNew();
        return $entry_handler->insert($this);
    }

    function synchronizeTrackbacks() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $tb_handler =& $myModule->getHandler('trackback');
        $criteria = new criteriaCompo(new criteria('direction', D3BLOG_TRACKBACK_DIRECTION_RECEIVED));
        $criteria->add(new criteria('bid', $this->bid()));
        $criteria->add(new criteria('approved', 1));
        $count =& $tb_handler->getCount($criteria);
        $this->setVar('trackbacks', $count);
        return true;
    }

/*    function synchronizeComments() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $entry_handler =& $myModule->getHandler('entry');
        if($myModule->getConfig('d3blog_comment_system')) {
            $com_handler =& $myModule->getHandler('comment');
            $criteria = new criteriaCompo(new Criteria('com_bid', $this->bid()));
            $criteria->add(new criteria('com_type', D3BLOG_COM_TYPE_COMMENT));
            $criteria->add(new criteria('com_status', D3BLOG_COM_ACTIVE));
            $count =& $com_handler->getCount($criteria);
            $this->setVar('comments', $count);
            return $entry_handler->insert($this);
        } else {

        }
    }
*/
    function &getStructure($type='s')
    {
        global $xoopsModule;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

        $ret =& parent::getStructure($type);

        $ret['groups'] = $this->groups();
        $ret['permed_group'] = $this->isPermedGroup();

//        $ret['publish_date'] = formatTimestamp($this->published(), "Y/m/d");
//        $ret['publish_time'] = formatTimestamp($this->published(), "H:i");

        $ret['pingExcerpt'] = $this->pingExcerpt();

        $ret['title4edit'] = $this->getVar('title', 'e');
        $ret['contents4edit'] = $this->reuniteContents('e');

        if(is_object($xoopsModule) && $xoopsModule->dirname() == $this->mydirname_) {
            $ret['trackback_url'] = $this->trackbackUrl();
            if($this->isTrackbackAcceptable()) {
                $ret['embeddedRDF'] = $this->embeddedRDF();
            }

            $cat_handler =& $myModule->getHandler('category');
            $ret['categorypath'] = array_reverse($cat_handler->getNicePathArrayFromId($this->cid(), XOOPS_URL."/modules/".$this->mydirname_."/index.php"));
            $catall =& $cat_handler->getAll();
            if(!$this->isNew() && is_object($catall[$this->cid()])) {
                $category =& $catall[$this->cid()];
                $ret['category'] = $category->getArray();
            }
            $page = @$_GET['page'];
            if($page == 'details' || $page == 'submit') {
                $tb_handler =& $myModule->getHandler('trackback');
                $ret['trackback'] = $tb_handler->getTrackback($this->bid());
            }
        }

        // blogger's info
        $blogger = $this->blogger();
        if(is_object($blogger)) {
            $ret['blogger'] =& $blogger->getArray();
            unset($ret['blogger']['pass']);

            // avatar info
            $avatar = $blogger->getVar('user_avatar');
            if (!empty($avatar) && $avatar != 'blank.gif') {
                $ret['blogger']['avatar']['url'] = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, XOOPS_UPLOAD_PATH.'/'.$avatar);
                $dimension = getimagesize( XOOPS_UPLOAD_PATH.'/'.$avatar);
                if(is_array($dimension)) {
                    $ret['blogger']['avatar']['width'] = $dimension[0];
                    $ret['blogger']['avatar']['height'] = $dimension[1];
                }
            }
        }
        return $ret;
    }

}

class d3blogEntryObjectHandlerBase extends myXoopsObjectHandler {

    var $result_message_ = array();
    var $parsed_url_ = array();
    var $filter_;
    var $mydirname_ ;

    function d3blogEntryObjectHandlerBase($db,$classname=null) {
        parent::myXoopsObjectHandler($db,$classname);
    }

    function &getCriteria($start=0, $limit=0) {
        // get criteria thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'EntryFilter', 'getInstance'));
        $criteria =& $this->filter_->getCriteria($start, $limit);
        if($this->filter_->isError()) {
            $this->result_message_ = $this->filter_->getHtmlErrors();
            return false;
        }
        return $criteria;
    }

    function &getDefaultCriteria($start=0, $limit=0, $prefix='') {
        // get criteria thru filter
        $this->filter_ = call_user_func(array($this->mydirname_.'EntryFilter', 'getInstance'));
        $criteria =& $this->filter_->getDefaultCriteria($start, $limit, $prefix);
        if($this->filter_->isError()) {
            $this->result_message_ = $this->filter_->getHtmlErrors();
            return false;
        }

        return $criteria;
    }

    function &entryPermCriteria($criteria, $show_excerpt=true, $prefix='') {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& d3blogTextSanitizer::getInstance();

        // permission by entry
        if($myModule->getConfig('perm_by_entry')) {
            // CURRENT USER'S INFO
            global $currentUser;
            $usergroup = $currentUser->groups();

            if(!is_object($criteria)) {
                $criteria = new CriteriaCompo();
            }

            $prefix = $myts->addSlashes($prefix);
            $eperm_criteria = new CriteriaCompo(new criteria('groups', '%|0|%', 'like', $prefix), 'OR');
            foreach($usergroup as $group) {
                $eperm_criteria->add(new Criteria('groups', '%|'.$group.'|%', 'like', $prefix), 'OR');
            }
            if($show_excerpt && $myModule->getConfig('can_read_excerpt')) {
                $eperm_criteria->add(new criteria('body', '', '<>', $prefix), 'OR');
            }
            $criteria->add($eperm_criteria);
        }

        return $criteria;
    }

    function getEntry($id, $show_excerpt=true, $criteria_prefix='') {
        if(empty($id))
            return false;
        $myts =& d3blogTextSanitizer::getInstance();

        $criteria =& $this->getDefaultCriteria();
        $criteria =& $this->entryPermCriteria($criteria, $show_excerpt, $criteria_prefix);
        $prefix = $myts->addSlashes($criteria_prefix);
        $criteria->add(new criteria('bid', intval($id), '=', $prefix));

        $obj = $this->getOne($criteria);
        if(!$obj)
            return false;
        return $obj;
    }

    function insert(&$obj, $force=false)
    {
        $obj->resetGroups();
//        $obj->setVar('modified', time());
        return parent::insert($obj, $force);
    }

    function incrementTrackbacks(&$obj, $increment=1) {
        if($obj->isApproved()) {
            $obj->setVar('trackbacks', $obj->trackbacks() + $increment);
            return $this->insert($obj);
        } else {
            return false;
        }
    }
/*
    function incrementComments(&$obj, $increment=1) {
        if($obj->isApproved()) {
            $obj->setVar('trackbacks', $obj->comments() + $increment);
            return $this->insert($obj);
        } else {
            return false;
        }
    }

    function updateComments(&$obj, $total_num) {
        $obj->setVar('comments', $total_num);
        return $this->insert($obj);
    }
*/
    function updateCommentCount(&$obj) {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $com_handler =& $myModule->getHandler('comment');
        $criteria = new criteriaCompo(new Criteria('com_bid', $this->com_bid()));
        $criteria->add(new criteria('com_status', D3BLOG_COM_ACTIVE));
        $count =& $com_handler->getCount($criteria);
        $obj->setVar('comments', $count);
        return $this->insert($obj, true);
    }

    function getBackandforth(&$obj) {
        $return = array();

        // Next
        $criteria =& $this->getCriteria(0, 1);
        $criteria =& $this->entryPermCriteria($criteria);
        $criteria->add(new criteria('published', $obj->published(), '>'));
        $criteria->setSort('published');
        $criteria->setOrder('ASC');

        $next_obj = $this->getOne($criteria);

        $return['next_entry'] = array();
        if(!empty($next_obj)) {
            $return['next_entry'] =& $next_obj->getArray();
            $return['next_entry']['url'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, htmlspecialchars($this->mydirname_, ENT_QUOTES), $next_obj->bid());
            $return['next_entry']['url'] .= !empty($this->filter_->extra_uri_)? '&amp;'.$this->filter_->extra_uri_ : '';
        }
        unset($criteria);

        // Prev
        $criteria =& $this->getCriteria(0, 1);
        $criteria =& $this->entryPermCriteria($criteria);
        $criteria->add(new criteria('published', $obj->published(), '<'));
        $criteria->setSort('published');
        $criteria->setOrder('DESC');

        $prev_obj = $this->getOne($criteria);

        $return['prev_entry'] = array();
        if(!empty($prev_obj)) {
            $return['prev_entry'] =& $prev_obj->getArray();
            $return['prev_entry']['url'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, htmlspecialchars($this->mydirname_, ENT_QUOTES), $prev_obj->bid());
            $return['prev_entry']['url'] .= !empty($this->filter_->extra_uri_)? '&amp;'.$this->filter_->extra_uri_ : '';
        }
        unset($criteria);

        return $return;
    }

    function getBreadInfo() {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $this->result_message_ = array();
        $myts =& MyTextSanitizer::getInstance();

        $criteria =& $this->getCriteria();
        $return = array();

        if($this->filter_->date_) {
            switch(strlen(strval($this->filter_->date_))) {
            case 8:
                preg_match("/(\d{4})(\d{2})(\d{2})/", $this->filter_->date_, $matches);
                $subtitle = $matches[1].'/'.$matches[2].'/'.$matches[3];
                break;
            case 6:
                preg_match("/(\d{4})(\d{2})/", $this->filter_->date_, $matches);
                $subtitle = $matches[1].'/'.$matches[2];
                break;

            case 4:
                preg_match("/(\d{4})/", $this->filter_->date_, $matches);
                $subtitle = $matches[1];
                break;

            default:
                $this->result_message_[] = sprintf(_MD_D3BLOG_ERROR_DATE_FORMAT_ILLEGAL, $myts->htmlSpecialChars($myts->stripSlashesGPC($this->filter_->date_)));
                return false;
                break;
            }
            $return['page_subtitle'] = sprintf(_MD_D3BLOG_LANG_ENTRIES_IN_PERIOD, $subtitle);
            $return['breadcrumbs'] = array(
                'name' => sprintf(_MD_D3BLOG_LANG_ENTRIES_IN_PERIOD, $subtitle),
                'url' => sprintf('%s/modules/%s/index.php?date=%s', XOOPS_URL, $this->mydirname_, strval($this->filter_->date_))
            );
        }

        if($this->filter_->uid_) {
            $blogger = new XoopsUser(intval($this->filter_->uid_));
            if(!$blogger) {
                $this->result_message_[] = sprintf(_MD_D3BLOG_ERROR_NO_SUCH_USER, intval($this->filter_->uid_));
                return false;
            }
            $return['page_subtitle'] = sprintf(_MD_D3BLOG_LANG_ENTRIES_OF, $blogger->getVar('uname'));
            $return['breadcrumbs'] = array(
                'name '=> sprintf(_MD_D3BLOG_LANG_ENTRIES_OF, $blogger->getVar('uname')),
                'url' => sprintf('%s/modules/%s/index.php?uid=%d', XOOPS_URL, $this->mydirname_, intval($this->filter_->uid_))
            );
        }

        if($this->filter_->cid_) {
            $handler =& $myModule->getHandler('category');
            $category = $handler->get(intval($this->filter_->cid_));
            if(!$category) {
                $this->result_message_[] = sprintf(_MD_D3BLOG_ERROR_NO_SUCH_CATEGORY, intval($this->filter_->cid_));
                return false;
            }
            $return['page_subtitle'] = sprintf(_MD_D3BLOG_LANG_ENTRIES_OF_CATEGORY, $category->getVar('name'));
            $return['breadcrumbs'] = $handler->getNicePathArrayFromId(intval($this->filter_->cid_),
                            sprintf('%s/modules/%s/index.php', XOOPS_URL, $this->mydirname_));
        }

        return $return;
    }

    function getDateSelbox() {
        if(!defined('_CAL_JANUARY')) {
            $language = $GLOBALS['xoopsConfig']['language'];
            if(file_exists(XOOPS_ROOT_PATH."/language/$language/calendar.php")) {
                require XOOPS_ROOT_PATH."/language/$language/calendar.php";
            } else {
                require XOOPS_ROOT_PATH.'/language/english/calendar.php';
            }
        }
        $calendar = array(
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

        global $currentUser, $xoopsDB;

        $criteria =& $this->getDefaultCriteria();
        $criteria =& $this->entryPermCriteria($criteria);
        $sql = 'SELECT DATE_FORMAT(FROM_UNIXTIME(published+'.$currentUser->timeoffset().'), "%X%m") as date, DATE_FORMAT(FROM_UNIXTIME(published+'.$currentUser->timeoffset().'), "%X") as year, DATE_FORMAT(FROM_UNIXTIME(published+'.$currentUser->timeoffset().'), "%m") as month FROM '.implode(",", array_map(array($this->db_, "prefix"), $this->_tableinfo_->tablenames_));
        $sql .= " ".$criteria->renderWhere();
        $sql .= ' GROUP BY date ORDER BY date DESC';

        $result = $this->db_->query($sql) ;
        $last_year = 9999;
        $months = array();
        while( list($date, $year, $month) = $this->db_->fetchRow($result) ){
            if( $last_year > $year ){
                $last_year = $year ;
                $months[$year] = $year.'&nbsp;'._MD_D3BLOG_LANG_SELECT_ALL;
            }
            $months[$date] = $year.'&nbsp;'.$calendar[intval($month)];
        }

        return $months;

    }

    function deleteByCat($cid) {
        if(empty($cid)) return false;
        $criteria = new criteriaCompo(new criteria('cid',intval($cid)));

        $objs =& $this->getObjects($criteria);
        if(count($objs)) {
            foreach($objs as $obj) {
                $this->delete($obj);
            }
        }
        return true;
    }

    function delete(&$obj,$force=false)
    {
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));

        // delete comments if exists
        if($obj->comments() > 0) {
            if($myModule->getConfig('d3blog_comment_system')) {
                $com_handler =& $myModule->getHandler('comment');
                $com_handler->deleteByEntry($obj);
            } else {
                xoops_comment_delete($myModule->module_id, $obj->bid());
            }
        }

        // delete trackbacks if exists
        if($obj->trackbacks() > 0) {
            $tb_handler =& $myModule->getHandler('trackback');
            $tb_criteria = new CriteriaCompo(new Criteria('bid', $obj->bid()));
            $tb_handler->deletes($tb_criteria);
        }

        // delete notifications
        xoops_notification_deletebyitem($myModule->module_id, 'entry', $obj->bid());

        // discrement blogger's posts
        if($myModule->getConfig('increment_userpost') && $obj->uid() > 0 && $obj->isApproved()) {
            $member_handler =& xoops_gethandler('member');
            $blogger = $member_handler->getUser($obj->uid());
            if(is_object($blogger))
                $member_handler->updateUserByField($blogger, 'posts', $blogger->getVar('posts') - 1);
        }

        return parent::delete($obj,$force);
    }

    function getOne($criteria, $d3comment=false) {
        $obj = parent::getOne($criteria);
        if(is_object($obj) && $d3comment) {
            $this->_getD3commentCount($obj);
        }
        return $obj;
    }

    function &getObjects($criteria=null,$id_as_key='',$order=null) {
        $objs = parent::getObjects($criteria, false, $order);
        if($id_as_key) {
            $ret = array();
            foreach($objs as $obj){
               $ret[$obj->getVar('bid')] = $obj;
            }
            $objs = $ret;
            $this->_getD3commentCount($objs);
        }
        return $objs;
    }

    function _getD3commentCount(&$objs) {
        if(is_array($objs) || is_object($objs)) {
            $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
            // check if xoops comment is available
            if($myModule->getConfig('com_rule') != 0) { // 0 means XOOPS_COMMENT_APPROVENONE
                $com_counts = array();
                // check if d3comment agent
                if($myModule->getConfig('com_agent') != '' && $myModule->getConfig('com_agent_forumid') > 0) {
                    // check if the com agent exists and is active
                    $module_hanlder =& xoops_gethandler('module');
                    $module =& $module_hanlder->getByDirname($myModule->getConfig('com_agent'));
                    if(is_object($module) && $module->getVar('isactive')) {
                        // fetch comments count from the comment agent
                        $link_ids = array();
                        if(is_array($objs)) {
                            foreach($objs as $obj) {
                                $link_ids[] = $obj->bid();
                            }
                        } elseif(is_object($objs)) {
                            $link_ids[] = $objs->bid();
                        }
                        $db =& Database::getInstance();
                        $sql = sprintf('SELECT SUM(topic_posts_count) AS count, topic_external_link_id AS blogid FROM %s WHERE forum_id = %d AND ! topic_invisible AND topic_external_link_id IN (%s) GROUP BY topic_external_link_id ORDER BY topic_external_link_id',
                            $db->prefix($module->getVar('dirname').'_topics'),
                            $myModule->getConfig('com_agent_forumid'),
                            implode(',', $link_ids)
                        );
                        if($result = $db->query($sql)) {
                            while($row = $db->fetchArray($result)) {
                                if(is_array($objs)) {
                                    $objs[intval($row['blogid'])]->setVar('comments', intval($row['count']));
                                } elseif(is_object($objs)) {
                                    $objs->setVar('comments', intval($row['count']));
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}
}

if( ! class_exists($object_class_name) ) {
require dirname(dirname(__FILE__)).'/include/filter/EntryFilter.class.php';
eval('
class '. $object_class_name .' extends d3blogEntryObjectBase {
    var $mydirname_;
    function '. $object_class_name .'($id=null) {
        $this->d3blogEntryObjectBase();
        $this->mydirname_ = "'.$mydirname.'";
    }
    function getTableInfo() {
        $tinfo = new myTableInfomation("'.$mydirname.'_entry", "bid");
        return ($tinfo);
    }
}
');
eval('
class '. $object_class_name .'Handler extends d3blogEntryObjectHandlerBase {
    var $mydirname_;
    function '. $object_class_name .'Handler($db) {
        parent::myXoopsObjectHandler($db, "'. $object_class_name .'");
        $this->mydirname_ = "'.$mydirname.'";
    }
}
');
}

?>
