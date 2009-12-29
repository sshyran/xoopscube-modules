<?php
/**
 * @version $Id: EntryEditForm.class.php 558 2008-12-10 01:04:16Z hodaka $
 * @author Takeshi Kuriyama <kuri@keynext.co.jp>
 */

require_once dirname(dirname(dirname(__FILE__))).'/lib/Form.php';

class EntryEditForm extends myActionFormEx
{
    var $bid_;
    var $cid_;
    var $title_;
    var $excerpt_;
    var $body_;
    var $dohtml_;
    var $doxcode_;
    var $doimage;
    var $dobr_;
    var $approved_;
    var $notified_;
    var $published_;
    var $created_;
    var $uid_;
    var $groups_;
    // extra
	var $groupids_;    // just used in the submit.html tpl
    var $contents_;
    var $publishable_ = false;
    var $update_ping_ = false;
    var $updateping_urls_;
    var $trackback_url_;
    var $tb_url_;
    var $trackback_;
    var $autodiscovery_ = true;
    var $delete_sent_;
    var $delete_rcvd_;
    var $approve_rcvd_;
    var $removable_;
    var $pingdata_;
    var $blogger_;
    var $subscribe_;
    var $mydirname_;

    function EntryEditForm($dirname) {
    	parent::myActionFormEx();
        $this->mydirname_ = $dirname;
    }

    function fetch(&$master) {
        global $currentUser, $xoopsGTicket;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $myts =& MyTextSanitizer::getInstance();
        
        if ( ! $xoopsGTicket->check(true,'d3blog_admin') ) {
            redirect_header(XOOPS_URL.'/', 3, $xoopsGTicket->getErrors());
            exit;
        }

        $this->bid_ = intval(@$_POST['bid']);
        
        $this->cid_ = intval(@$_POST['cid']);
        if(!$this->cid_) {
            $this->addError(_MD_D3BLOG_ERROR_CATEGORY_REQUIRED);
        }

        $this->title_ = trim(@$_POST['title']);
        if(!$this->title_) {
            $this->addError(_MD_D3BLOG_ERROR_TITLE_REQUIRED);
        }
        if(!$this->validateMaxLength($this->title_, 255)) {
            $this->addError(sprintf(_MD_D3BLOG_ERROR_TITLE_SIZEOVER, 255));
        }

        $this->contents_ = trim(@$_POST['contents']);
        if(!$this->contents_) {
            $this->addError(_MD_D3BLOG_ERROR_CONTENTS_REQUIRED);
        }

        $this->dohtml_ = isset($_POST['dohtml'])? 1 : 0;
        $this->doxcode_ = isset($_POST['doxcode'])? 1 : 0;
        $this->doimage_ = isset($_POST['doimage'])? 1 : 0;
        $this->dobr_ = isset($_POST['dobr'])? 1 : 0;
        $this->approved_ = isset($_POST['approved'])? 1 : 0;
        $this->subscribe_ = isset($_POST['subscribe'])? 1 : 0;
        $this->publishable_ = isset($_POST['publishable'])? true : false;
        if($this->publishable_) {
            $published = $_POST['published'];
            if(isset($published) && is_array($published))
                $this->published_ = mktime(intval($published['Time_Hour']), intval($published['Time_Minute']), 0,
                    intval($published['Date_Month']), intval($published['Date_Day']), intval($published['Date_Year']));
            else
                $this->published_ = time();
        } else {
            $this->published_ = $master->getVar('published') + $currentUser->getTimeoffset();
        }

        if(!$myModule->getConfig('perm_by_entry')) {
            $groups = is_array($myModule->getConfig('default_groups'))? $myModule->getConfig('default_groups') : array('1');
        } else {
            $groups = @($_POST['groups']);
        }
        $this->groups_ = array();
        if(is_array($groups)) {
        	foreach($groups as $group) {
 	        	$this->groups_[] = intval($group); 	
        	}
        }
		$this->groupids_ = array_flip($this->groups_);
		array_walk($this->groupids_, create_function('&$v,$k', '$v = 1;'));   // reset all values true 

        // trackback related
        $this->autodiscovery_ = isset($_POST['autodiscovery'])? true : false;
        $this->trackback_url_ = @($_POST['trackback_url']);
        $this->tb_url_ = @($_POST['tb_url']);
        $this->delete_sent_ = @($_POST['delete_sent']);
        $this->delete_rcvd_ = @($_POST['delete_rcvd']);
        $this->approve_rcvd_ = @($_POST['approve_rcvd']);
//        $this->removable_ = @($_POST['removable']);
        $this->update_ping_ = isset($_POST['update_ping'])? true : false;

        $this->updateping_urls_ = array();
        if($myModule->getConfig('url_by_entry')) {
            $updateping_urls = @($_POST['updateping_urls']);
            $configUrls = preg_split("/[\s]+/", $myModule->getConfig('updateping_url'));
            $u =0;
            $max_urls = $myModule->getConfig('max_urls')? intval($myModule->getConfig('max_urls')) : 4;
            foreach($configUrls as $ukey=>$url) {
                $this->updateping_urls_[$ukey]['url'] = $url;
                if($u < $max_urls && isset($updateping_urls) && in_array($ukey, $updateping_urls)) {
                    $this->updateping_urls_[$ukey]['selected'] = 1; 
                    $u++;
                } else {
            	   $this->updateping_urls_[$ukey]['selected'] = 0;
                }
            }
        }
    }

    function load(&$master) {
        global $currentUser;
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $this->bid_ = $master->getVar ( 'bid', 'e' );
        $this->cid_ = $master->getVar ( 'cid', 'e' );
        $this->title_ = $master->getVar ( 'title', 'e' );
        $this->excerpt_ = $master->getVar ( 'excerpt', 'e' );
        $this->body_ = $master->getVar ( 'body', 'e' );
        $this->contents_ = $master->reuniteContents('e');
        $this->dohtml_ = $master->getVar ( 'dohtml', 'e' );
        $this->doxcode_ = $master->getVar ( 'doxcode', 'e' );
        $this->doimage_ = $master->getVar ( 'doimage', 'e' );
        $this->dobr_ = $master->getVar ( 'dobr', 'e' );
        $this->approved_ = $master->getVar ( 'approved', 'e' );
        $this->notified_ = $master->getVar ( 'notified', 'e' );
        $this->published_ = $master->getVar ( 'published', 'e' ) + $currentUser->getTimeoffset();
        $this->uid_ = $master->getVar ( 'uid', 'e' );

        $this->groups_ = $master->groups();
        $this->groupids_ = array_flip($this->groups_);
        array_walk($this->groupids_, create_function('&$v,$k', '$v = 1;'));

        if($myModule->getConfig('url_by_entry')) {
            $configUrls = preg_split("/[\s]+/", $myModule->getConfig('updateping_url'));
            $this->updateping_urls_ = array();
            $u = 0;
            $max_urls = $myModule->getConfig('max_urls')? intval($myModule->getConfig('max_urls')) : 0;
            foreach($configUrls as $url) {
                $this->updateping_urls_[$u]['url'] = $url;
                if($u < $max_urls) {
                    $this->updateping_urls_[$u]['selected'] = 1;
                } else {
            	   $this->updateping_urls_[$u]['selected'] = 0;
                }
                $u++;
            }
        }
    }

    function update(&$master) {
        global $currentUser;
        $ts =& MyTextSanitizer::getInstance();
        $myModule = call_user_func(array($this->mydirname_, 'getInstance'));
        $master->setVar ( 'cid', intval($this->cid_) );
        $master->setVar ( 'title', $this->title_ );
        $master->setVar ( 'dohtml', $this->dohtml_ );
        $master->setVar ( 'doxcode', $this->doxcode_ );
        $master->setVar ( 'doimage', $this->doimage_ );
        $master->setVar ( 'dobr', $this->dobr_ );
        if($master->getVar('approved') != $this->approved_)
            $master->setVar ( 'approved', $this->approved_ );
        $master->setVar ( 'published', $this->published_ - $currentUser->getTimeoffset());
        $master->setVar ( 'groups', '|'.implode('|', $this->groups_).'|' );

        // divide contents into excerpt and body by seperator
        $master->divideContents($this->contents_);

        // blogger's info
        $user_handler =& myXoopsUserHandler::getInstance();
        $blogger = $user_handler->get($master->uid());
        if(is_object($blogger))
            $this->blogger_ =& $blogger;
    }

    function pingdata(&$master) {
        // data for trackback
        $this->pingdata_ = array();
        $this->pingdata_['bid'] = $master->bid();
        $this->pingdata_['title'] = $master->title();
        $this->pingdata_['blog_name'] = htmlspecialchars(sprintf('%s - %s', $GLOBALS['xoopsConfig']['sitename'], $this->mydirname_), ENT_QUOTES);
        $this->pingdata_['blog_topurl'] = sprintf('%s/modules/%s/index.php', XOOPS_URL, $this->mydirname_);
        $this->pingdata_['url'] = sprintf('%s/modules/%s/details.php?bid=%d', XOOPS_URL, $this->mydirname_, $master->bid());
        $this->pingdata_['trackback_url'] = $master->trackbackUrl();
        $this->pingdata_['excerpt'] = $master->pingExcerpt();    	
    }

}
?>
