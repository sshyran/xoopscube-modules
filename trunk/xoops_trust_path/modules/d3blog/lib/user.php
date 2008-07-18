<?php
/**
 * @file
 * @version $Id: user.php 436 2008-05-13 15:20:04Z hodaka $ 
*/

if(!class_exists('myXoopsUserObject')) {

require_once dirname(dirname(__FILE__)).'/lib/object.php';
require_once dirname(dirname(__FILE__)).'/lib/perm.php';
require_once XOOPS_ROOT_PATH.'/include/comment_constants.php';

class myXoopsUserObject extends myXoopsObject {
    var $_xoopsUser_;
    var $_userCookie;
    var $_groups_ = array();
    var $_isAdmin_ = null;
    var $_rank_ = null;
    var $_isOnline_ = null;
    var $_userPerm;

    function myXoopsUserObject($arr=null) {
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 60);
        $this->initVar('uname', XOBJ_DTYPE_TXTBOX, null, true, 25);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, true, 60);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('user_avatar', XOBJ_DTYPE_TXTBOX, null, false, 30);
        $this->initVar('user_regdate', XOBJ_DTYPE_INT, null, false);
        $this->initVar('user_icq', XOBJ_DTYPE_TXTBOX, null, false, 15);
        $this->initVar('user_from', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('user_sig', XOBJ_DTYPE_TXTAREA, null, false, null);
        $this->initVar('user_viewemail', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('actkey', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('user_aim', XOBJ_DTYPE_TXTBOX, null, false, 18);
        $this->initVar('user_yim', XOBJ_DTYPE_TXTBOX, null, false, 25);
        $this->initVar('user_msnm', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('pass', XOBJ_DTYPE_TXTBOX, null, false, 32);
        $this->initVar('posts', XOBJ_DTYPE_INT, null, false);
        $this->initVar('attachsig', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('rank', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('level', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('theme', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('timezone_offset', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('last_login', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('umode', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('uorder', XOBJ_DTYPE_INT, 1, false);
        // RMV-NOTIFY
        $this->initVar('notify_method', XOBJ_DTYPE_OTHER, 1, false);
        $this->initVar('notify_mode', XOBJ_DTYPE_OTHER, 0, false); 
        $this->initVar('user_occ', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('bio', XOBJ_DTYPE_TXTAREA, null, false, null);
        $this->initVar('user_intrest', XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar('user_mailok', XOBJ_DTYPE_INT, 1, false);

        if(is_object($arr)) {
            $this->assginByObject($arr);
        }
        $this->_userPerm = array();
    }

    function assginByObject(&$xoopsUser) {
        $this->_xoopsUser_ =& $xoopsUser;
        $this->vars = $xoopsUser->vars;
    }

    function groups() {
        return $this->_groups_;
    }
    
    function isAdmin($mid=null) {
        if($this->isUser())
            return $this->_xoopsUser_->isAdmin($mid);
        else
            return false;       
    }

    function isGuest() {
        return is_object($this->_xoopsUser_)? false : true;
    }

    function isUser() {
        return is_object($this->_xoopsUser_);
    }

    function uid($type='s') {
        if($this->isUser())
            return $this->getVar('uid', $type);
        else
            return 0;
    }
    
    function uname($type='s') {
        if($this->isUser())
            return $this->getVar('uname', $type);
        else
            return null;
    }
    
    function name($type='s') {
        if($this->isUser())
            return $this->getVar('name', $type);
        else
            return null;
    }
        
    function timeoffset($sec=true) {
        return $this->getTimeoffset($sec);   
    }

    function getTimeoffset($sec=true) {
        if($this->isUser())
            $timeoffset = $this->_xoopsUser_->getVar('timezone_offset') - $GLOBALS['xoopsConfig']['server_TZ'];
        else    
            $timeoffset = $GLOBALS['xoopsConfig']['default_TZ'] - $GLOBALS['xoopsConfig']['server_TZ'];

        if($sec)
            return $timeoffset*3600;
        else
            return $timeoffset;  
    }

    function checkMid($mid) {
        if($mid==null) {
            global $xoopsModule;
            if(is_object($xoopsModule)) {
                return $xoopsModule->getVar('mid');
            } else {
                die('module id not defined');
            }
        }
        return intval($mid);        
    }

    function isEditor($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('blog_editor');
    }
    
    function blog_perm_view($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('blog_perm_view');
    }
    
    function blog_perm_edit($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('blog_perm_edit');
    }
            
    function blog_perm($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('blog_perm');
    }
    
    function blog_autoapprove($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('blog_autoapprove');
    }
    
    function com_perm($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_perm');
    }
    
    function com_perm_view($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_perm_view');
    }
    
    function com_perm_edit($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_perm_edit');
    }
    
    function com_perm_delete($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_perm_delete');
    }
    
    function com_perm_reply($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_perm_reply');
    }
                
    function com_autoapprove($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('com_autoapprove');
    }
    
    function allow_html($mid=null) {
        $mid = $this->checkMid($mid);
        return $this->_userPerm[$mid]->getVar('allow_html');
    }
     

    function hasPerm($name, $item_no=0, $mid=null) {
        if(is_array($name)) {
            return count( array_intersect( $name, array_keys($this->userPermNames($mid, $item_no)) ) );
        } else {
            return in_array($name, array_keys($this->userPermNames($mid, $item_no)));
        }
    }

    function userPermNames($mid=null, $item_no=0) {
        return myPerm::getUserPermNames($mid, $item_no);       
    }

    function getGroups() {
        if($this->isUser()) {
			return $this->_xoopsUser_->getGroups();
        } else {
            return array(XOOPS_GROUP_ANONYMOUS);
        }
    }
    
    function &getStructure($type='s') {
        $ret = parent::getStructure($type);
        if($this->isUser()) {
            $ret['isAdmin']=$this->_xoopsUser_->isAdmin();
        } else {
            $ret['uid'] = 0;
        }

//        if(isset($this->_userPerm[$mid]) && is_object($this->_userPerm[$mid])) {
//            $ret['user_perm'] = $this->_userPerm[$mid]->getArray();
//        }
        $ret['timeoffset'] = $this->timeoffset();
        $ret['groups'] = $this->getGroups();
//        if(is_object($this->_userCookie))
//            $ret['cookie'] = $this->_userCookie->getArray();

        unset ($ret['pass']);

        return $ret;
    }

}

class myXoopsUserHandler extends myXoopsObjectHandler
{
    function &getInstance()
    {
        global $xoopsDB;
        static $myUserHandler;
        if(!$myUserHandler)
            $myUserHandler = new myXoopsUserHandler($xoopsDB);

        return $myUserHandler;
    }

    function myXoopsUserHandler($db)
    {
        $this->_classname_ = "myXoopsUserObject";
        $this->_tableinfo_ = new myTableInfomation('users','uid');
        parent::myXoopsObjectHandler($db);
    }

}
}

if(!(class_exists('myXoopsUserPermission'))) {
require_once dirname(dirname(__FILE__)).'/lib/object.php';
require_once dirname(dirname(__FILE__)).'/lib/perm.php';
class myXoopsUserPermission extends myXoopsObject {

    function myXoopsUserPermission(&$user, &$module) {
        $this->initVar('blog_perm_view', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('blog_perm_edit', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('blog_autoapprove', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('blog_perm', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_perm_view', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_perm_edit', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_perm_delete', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_perm_reply', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_autoapprove', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('com_perm', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('allow_html', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('blog_editor', XOBJ_DTYPE_INT, 0, false);        
        
        $perm_array = $user->userPermNames($module->module_id);
        if(is_array($perm_array)) {
            $this->assignVars($perm_array);
            $this->init($user, $module);
        }
    }

    function init(&$user, &$module) {
        if($this->getVar('blog_editor')) {
            $this->setVar('blog_perm_view', true);
            $this->setVar('blog_perm_edit', true);
            $this->setVar('blog_perm', D3BLOG_CAN_EDIT);
            $this->setVar('blog_autoapprove', true);
            $this->setVar('com_perm_view', true);
            $this->setVar('com_perm_edit', true);
            $this->setVar('com_perm_delete', true);
            $this->setVar('com_perm_reply', true);
            $this->setVar('com_perm', D3BLOG_CAN_EDIT);
            $this->setVar('com_autoapprove', true);
            $this->setVar('allow_html', true); 
        } else {
            if($this->getVar('blog_perm_view'))
                $this->setVar('blog_perm', D3BLOG_CAN_VIEW);
            if($this->getVar('blog_perm_edit'))
                $this->setVar('blog_perm', D3BLOG_CAN_EDIT);                

            if($this->getVar('blog_perm') >= D3BLOG_CAN_VIEW && XOOPS_COMMENT_APPROVENONE != $module->getConfig('com_rule')) {
                $this->setVar('com_perm_view', true);
                $this->setVar('com_perm', D3BLOG_CAN_VIEW);                
            }
            if($this->getVar('com_perm_view')) {
                if($user->isUser()) {
                    $this->setVar('com_perm_edit', true);
                } elseif($module->getConfig('com_anonpost')) {
                    $this->setVar('com_perm_edit', true);
                }
            }
            if($this->getVar('com_perm_edit')) {
                $this->setVar('com_perm', D3BLOG_CAN_EDIT);
                if($user->isUser()) {
                	$this->setVar('com_perm_delete', true);
                }
                
//                if(!$module->getConfig('reject_reply')) {
//                	$this->setVar('com_perm_reply', true);
//                }
            }
            
            if(XOOPS_COMMENT_APPROVEALL == $module->getConfig('com_rule')) {
                $this->setVar('com_autoapprove', true);
            } elseif($user->isUser() && XOOPS_COMMENT_APPROVEUSER == $module->getConfig('com_rule')) {
                $this->setVar('com_autoapprove', true);
            }
        }    	
    }
}
}

if(!class_exists('myXoopsUserCookie')) {
require_once dirname(dirname(__FILE__)).'/lib/object.php';
class myXoopsUserCookie extends myXoopsObject {
    function myXoopsUserCookie($name=null, $email=null, $url=null) {
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 60);
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, null, true, 60);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, '', false, 100);
        if(is_array($name))
            $this->assignVars($name);
    }
    
    function setCookie($lifetime=365) {
        if($this->getVar('name', 'e'))
        	setcookie('blogcommenter', $this->getVar('name', 'e'), time()+60*60*24*intval($lifetime), '/', '', '');
        if($this->getVar('email', 'e'))
            setcookie('blogcomemail', $this->getVar('email', 'e'), time()+60*60*24*intval($lifetime), '/', '', '');
        if($this->getVar('url', 'e'))
            setcookie('blogcomurl', $this->getVar('url', 'e'), time()+60*60*24*intval($lifetime), '/', '', '');
        return true;
    }

    function getCookie() {
        if(!empty($_COOKIE['blogcommenter']))
            $this->setVar('name', $_COOKIE['blogcommenter']);
        if(!empty($_COOKIE['blogcomemail']))
            $this->setVar('email', $_COOKIE['blogcomemail']);
        if(!empty($_COOKIE['blogcomurl']))
            $this->setVar('url', $_COOKIE['blogcomurl']);
    }

    function fetch() {
        $this->setVar('name', @$_POST['user_name']);
        $this->setVar('email', @$_POST['user_email']);
        $this->setVar('url', @$_POST['user_url']);
    }
    
    function clearCookie() {
        $this->setVar('name', '');
        $this->setVar('email', '');
        $this->setVar('url', '');
        setcookie('blogcommenter', false, time() - 3600);
        setcookie('blogcomemail', false, time() - 3600);
        setcookie('blogcomurl', false, time() - 3600);
    }

}
}
?>