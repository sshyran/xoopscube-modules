<?php
/**
 * Sabai_User_IdentityFetcher
 */
require_once 'Sabai/User/IdentityFetcher.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   SabaiXOOPS
 * @package    SabaiXOOPS
 * @copyright  Copyright (c) 2008 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/gpl-license.php GNU GPL
 * @link       http://sourceforge.net/projects/sabai
 * @since      Class available since Release 0.1.0
 */
class SabaiXOOPS_User_IdentityFetcher extends Sabai_User_IdentityFetcher
{
    function SabaiXOOPS_User_IdentityFetcher()
    {
        parent::Sabai_User_IdentityFetcher('uid', 'uname');
    }

    function _doFetchUserIdentities($userIds)
    {
        require_once 'Sabai/User/Identity.php';
        $users = array();
        $member_h =& xoops_gethandler('member');
        $xoops_users = $member_h->getUsers(new Criteria('uid', '(' . implode(',', array_map('intval', $userIds)) . ')', 'IN'), true);
        foreach ($userIds as $uid) {
            if (isset($xoops_users[$uid])) {
                $identity =& SabaiXOOPS::getUserIdentity($xoops_users[$uid]);
            } else {
                $identity =& SabaiXOOPS::getGuestIdentity();
            }
            $users[$uid] =& $identity;
            unset($identity);
        }
        return $users;
    }

    function _doFetchIdentities($limit, $offset, $sort, $order)
    {
        require_once 'Sabai/User/Identity.php';
        $users = array();
        $member_h =& xoops_gethandler('member');
        $criteria =& new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($limit);
        $criteria->setStart($offset);
        $xoops_users = $member_h->getUsers($criteria, false);
        foreach (array_keys($xoops_users) as $i) {
            $users[] =& SabaiXOOPS::getUserIdentity($xoops_users[$i]);
        }
        return $users;
    }

    function countIdentities()
    {
        $member_h =& xoops_gethandler('member');
        return $member_h->getUserCount();
    }
}