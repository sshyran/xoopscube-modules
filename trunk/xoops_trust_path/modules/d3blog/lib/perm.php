<?php
/**
 * @version $Id: perm.php 320 2008-03-03 14:17:35Z hodaka $
 */

if(!class_exists('myPerm')) {

require_once dirname(dirname(__FILE__)).'/lib/object.php';

class myPerm
{
    function getPermsList($mid=null, $item_id=0) {
        static $__myperm_all_perms_list__;
        if($mid==null) {
            if(is_object(@$GLOBALS['xoopsModule'])) {
                $mid = $GLOBALS['xoopsModule']->mid();
            } else {
                die('module id not defined');
            }
        } else {
            $mid = intval($mid);
        }
        $item_id = intval($item_id);
        
        if(!isset($__myperm_all_perms_list__[$mid])) {
            $handler =& myXoopsGroupPermHandler::getInstance();
            $criteria = new CriteriaCompo(new Criteria('gperm_modid', $mid));
            $criteria->setSort('gperm_itemid');
            $criteria->addSort('gperm_name');
            $criteria->addSort('gperm_groupid');

            $objs=$handler->getObjects($criteria);
            if(count($objs)) {
            	foreach($objs as $obj) {
            		$__myperm_all_perms_list__[$mid][$obj->getVar('gperm_itemid')][$obj->getVar('gperm_name')][$obj->getVar('gperm_groupid')] = 1;
            	}
            }
        }
        return $__myperm_all_perms_list__[$mid][$item_id];
    }

    function getPermsByGroup($item_id=0, $mid=null)
    {
        global $xoopsModule;

        $mid = ($mid==null) ? $xoopsModule->mid() : $mid;

        $handler =& myXoopsGroupPermHandler::getInstance();

        $criteria = new CriteriaCompo(new Criteria('gperm_modid',$mid));
        if($item_id !== null)
            $criteria->add( new Criteria('gperm_itemid',intval($item_id)) );
        $criteria->setSort('gperm_itemid, gperm_groupid');
        
        $objs=$handler->getObjects($criteria);
        
        $ret = array();
        foreach($objs as $obj) {
            $ret[$obj->getVar('gperm_itemid')][$obj->getVar('gperm_groupid')][$obj->getVar('gperm_name')] = 1;
        }
        return $ret;
    }

    function &getGroupsByName($item_name, $mid=null, $item_id=0)
    {
        static $__myperm_groups_list__;
        global $xoopsModule;
        $myts =& MyTextSanitizer::getInstance();
        if($mid==null) {
            if(is_object($xoopsModule)) {
                $mid = $xoopsModule->mid();
            } else {
                die('module id not defined');
            }
        } else {
            $mid = intval($mid);
        }

        if(!isset($__myperm_groups_list__[$mid][$item_name][$item_id])) {

            $handler =& myXoopsGroupPermHandler::getInstance();
        
            $criteria = new CriteriaCompo(new Criteria('gperm_modid', $mid));
            $criteria->add(new Criteria('gperm_itemid', intval($item_id)));
            if(is_array($item_name)) {
                $item_criteria = new CriteriaCompo();
                foreach($item_name as $name) {
                    $criteria->add(new Criteria('gperm_name', $myts->addSlashes($name)), 'OR');
                }
                $criteria->add($item_criteria);
            } else {
                $criteria->add(new Criteria('gperm_name', $myts->addSlashes($item_name)));
            }
        
            $objs =& $handler->getObjects($criteria);
            $groups = array();
            foreach($objs as $obj) {
                $groups[] = $obj->getVar('gperm_groupid');
            }
            $__myperm_groups_list__[$mid][$item_name][$item_id] = array_unique($groups);
        }
        return $__myperm_groups_list__[$mid][$item_name][$item_id];
    }

    /**
     * @brief return objects of users with permission of designated
     * @return array $users array of uid 
     */
    function &getMembersByName($item_name, $mid=null, $item_id=0) {
        static $__myperm_users_object__;
        global $xoopsModule;
        if($mid==null) {
            if(is_object($xoopsModule)) {
                $mid = $xoopsModule->mid();
            } else {
                die('module id not defined');
            }
        } else {
            $mid = intval($mid);
        }
        
        if(!isset($__myperm_users_object__[$mid][$item_name][intval($item_id)])) {
            $groups =& myPerm::getGroupsByName($item_name, $mid, $item_id);
            $member_handler =& xoops_gethandler( 'member' );
            $users = array(); 
            foreach($groups as $group) {
                $members =& $member_handler->getUsersByGroup($group, true);
                foreach($members as $member) {
                    if(!array_key_exists($member->getVar('uid'), $users)) {
//                        $users[$member->getVar('uid')] = $member;
                        $users[$member->getVar('uid')] = new myXoopsUserObject($member);
                    }      
                }
            }
            $__myperm_users_object__[$mid][$item_name][intval($item_id)] = $users;
        }
        return $__myperm_users_object__[$mid][$item_name][intval($item_id)];
    }

    /**
     * @brief return array of users with permission of designated
     * @return array $users array of uid 
     */
    function &getUsersByName($item_name, $mid=null, $item_id=0) {
        static $__myperm_users_list__;

        $item_id = intval($item_id);
        if($mid==null) {
            global $xoopsModule;
            if(is_object($xoopsModule)) {
                $mid = $xoopsModule->mid();
            } else {
                die('module id not defined');
            }
        } else {
            $mid = intval($mid);
        }

        if(!isset($__myperm_users_list__[$mid][$item_name][$item_id])) {
            $members =& myPerm::getMembersByName($item_name, $mid, $item_id);

            $users = array();
            foreach($members as $uid => $member) {
                $users[$uid] = $member->uname();
            }
            $__myperm_users_list__[$mid][$item_name][$item_id] = array_unique($users);
        }
        return $__myperm_users_list__[$mid][$item_name][$item_id];
    }

    function getUserPermNames($mid=null, $item_id=0) {
        static $__myperm_users_perm__;
        global $xoopsModule, $currentUser;
        if($mid==null) {
            if(is_object($xoopsModule)) {
                $mid = $xoopsModule->mid();
            } else {
                die('module id not defined');
            }
        } else {
            $mid = intval($mid);
        }

        if(isset($__myperm_users_perm__[$mid][intval($item_id)]))
            return $__myperm_users_perm__[$mid][intval($item_id)];

        $groups = $currentUser->groups();

        $handler =& myXoopsGroupPermHandler::getInstance();
        
        $criteria = new CriteriaCompo(new Criteria('gperm_modid', $mid));

        $group_criteria = new CriteriaCompo();
        foreach($groups as $group) {
            $group_criteria->add(new Criteria('gperm_groupid', $group), 'OR');
        }
        $criteria->add($group_criteria);
        
        $criteria->add( new Criteria('gperm_itemid',intval($item_id)) );        

        $objs =& $handler->getObjects($criteria);
        
        $__myperm_users_perm__[$mid][intval($item_id)] = array();
        if(count($objs)) {
            foreach($objs as $obj) {
                $__myperm_users_perm__[$mid][intval($item_id)][$obj->getVar('gperm_name')] = 1;
            }
        }
        return $__myperm_users_perm__[$mid][intval($item_id)];
    }

    /**
     * @param int $mid(module id)
     * @return array $ret
     */
    function getPermsArray()
    {
        global $xoopsUser, $xoopsModule;
        static $__mypermarray_currentUser_cache__;
        
        if (isset($__mypermarray_currentUser_cache__))
            return $__mypermarray_currentUser_cache__;

        $__mypermarray_currentUser_cache__ = array();
        
        $handler=&myXoopsGroupPermHandler::getInstance();

        if(is_object($xoopsUser))
            $groups=$xoopsUser->getGroups();
        else {
            $groups=array();
            $groups[]=XOOPS_GROUP_ANONYMOUS;
        }

        $criteria=new CriteriaCompo();
        $gc=new CriteriaCompo();
        foreach($groups as $gid) {
            $gc->add(new Criteria('gperm_groupid', $gid),"OR");
        }
        $criteria->add($gc);
        $criteria->add(new Criteria('gperm_modid', $xoopsModule->mid()));
        $criteria->setSort('gperm_name, gperm_itemid');
        $objs =& $handler->getObjects($criteria);
        foreach($objs as $obj) {
            $__mypermarray_currentUser_cache__[$obj->getVar('gperm_itemid')][$obj->getVar('gperm_name')] = 1;
        }    
        return $__mypermarray_currentUser_cache__;
    }

    function Guard($name,$item_id=0)
    {
        $arr =& myPerm::getPermsArray();
        if(!isset($arr[$item_id]) || !is_array($arr[$item_id]))
            return false;
        return array_key_exists($name, $arr[$item_id])? true : false;

        global $xoopsUser,$xoopsModule;
        static $__myperm_currentUser_cache__;
        
        if (isset($__myperm_currentUser_cache__[$item_id][$name]))
            return $__myperm_currentUser_cache__[$item_id][$name];

        $handler=&myXoopsGroupPermHandler::getInstance();

        if(is_object($xoopsUser))
            $groups=$xoopsUser->getGroups();
        else {
            $groups=array();
            $groups[]=XOOPS_GROUP_ANONYMOUS;
        }

        $criteria=new CriteriaCompo();
        $gc=new CriteriaCompo();
        foreach($groups as $gid) {
            $gc->add(new Criteria('gperm_groupid',$gid),"OR");
        }
        $criteria->add($gc);
        $criteria->add(new Criteria('gperm_modid',$xoopsModule->mid()));
        if($item_id!==null)
            $criteria->add(new Criteria('gperm_itemid',$item_id));
        $criteria->add(new Criteria('gperm_name',$name));
        
        return $__myperm_currentUser_cache__[$item_id][$name]=$handler->getCount($criteria);
    }
    
    function isPerm($name,$item_id=0)
    {
        return myPerm::Guard($name,$item_id);
    }

    function getPermNames($item_id=0)
    {
        $arr =& myPerm::getPermsArray();
        if(!isset($arr[$item_id]))
            return array();
        return $arr[$item_id];

        global $xoopsUser,$xoopsModule;

        $handler=&myXoopsGroupPermHandler::getInstance();

        if(is_object($xoopsUser))
            $groups=$xoopsUser->getGroups();
        else {
            $groups=array();
            $groups[]=XOOPS_GROUP_ANONYMOUS;
        }

        $criteria=new CriteriaCompo();
        $gc=new CriteriaCompo();
        foreach($groups as $gid) {
            $gc->add(new Criteria('gperm_groupid', $gid),"OR");
        }
        $criteria->add($gc);
        $criteria->add(new Criteria('gperm_modid', $xoopsModule->mid()));
        if($item_id!==null)
            $criteria->add(new Criteria('gperm_itemid',$item_id));
        
        $objs=$handler->getObjects($criteria);
        
        $ret=array();
        foreach($objs as $obj) {
            $ret[$obj->getVar('gperm_name')]=1;
        }
        return $ret;
    }

    function getPermNames_global($item_id)
    {
        global $xoopsUser,$xoopsModule;

        $handler=&myXoopsGroupPermHandler::getInstance();

        if(is_object($xoopsUser))
            $groups=$xoopsUser->getGroups();
        else {
            $groups=array();
            $groups[]=XOOPS_GROUP_ANONYMOUS;
        }

        $criteria=new CriteriaCompo();
        $gc=new CriteriaCompo();
        foreach($groups as $gid) {
            $gc->add(new Criteria('gperm_groupid',$gid),"OR");
        }
        $criteria->add($gc);
        $criteria->add(new Criteria('gperm_modid',$xoopsModule->mid()));

        $ic=new CriteriaCompo();
        $ic->add(new Criteria('gperm_itemid',0),"OR");
        $ic->add(new Criteria('gperm_itemid',$item_id),"OR");
        $criteria->add($ic);

        $objs=$handler->getObjects($criteria);
        
        $ret=array();
        foreach($objs as $obj) {
            $ret[$obj->getVar('gperm_name')]=1;
        }
        return $ret;
    }

    function GuardRedirect($name,$url,$message=null,$time=1)
    {
        if(!myPerm::Guard($name)) {
            redirect_header($url,$time,$message);
            exit;
        }
    }
    
    function Guard_global($name,$item_id)
    {
        return (myPerm::Guard($name,0) or myPermission::Guard($name,$item_id));
    }

    function &getGroupPermHandler()
    {
        global $xoopsDB;
        static $myXGPermHandler;
        if(!$myXGPermHandler)
            $myXGPermHandler=new myXoopsGroupPermHandler($xoopsDB);

        return $myXGPermHandler;
    }
}

class myPermission extends myPerm {
}

class myXoopsGroupPermObject extends myXoopsObject
{
    function myXoopsGroupPermObject($id=null)
    {
        parent::myXoopsObject($id);
        $this->initVar('gperm_id',XOBJ_DTYPE_INT,0,false);
        $this->initVar('gperm_groupid',XOBJ_DTYPE_INT,0,false);
        $this->initVar('gperm_itemid',XOBJ_DTYPE_INT,0,false);
        $this->initVar('gperm_modid',XOBJ_DTYPE_INT,0,false);
        $this->initVar('gperm_name',XOBJ_DTYPE_TXTBOX,'',false,32);
    }

}

class myXoopsGroupPermHandler extends myXoopsObjectHandler
{
    function &getInstance()
    {
        global $xoopsDB;
        static $myXGPermHandler;
        if(!$myXGPermHandler)
            $myXGPermHandler = new myXoopsGroupPermHandler($xoopsDB);

        return $myXGPermHandler;
    }

    function myXoopsGroupPermHandler($db)
    {
        $this->_classname_ = "myXoopsGroupPermObject";
        $this->_tableinfo_ = new myTableInfomation('group_permission','gperm_id');
        parent::myXoopsObjectHandler($db);
    }

}

}
?>