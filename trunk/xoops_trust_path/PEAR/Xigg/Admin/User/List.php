<?php
require_once 'Sabai/Controller/UserIdentityPaginate.php';

class Xigg_Admin_User_List extends Sabai_Controller_UserIdentityPaginate
{
    var $_sortBy = array('id', 'ASC');

    function Xigg_Admin_User_List()
    {
        parent::Sabai_Controller_UserIdentityPaginate(array('perpage' => 15));
    }

    function _getRequestedSort(&$request)
    {
        if ($sort_by = $request->getAsStr('sortby')) {
            $sort_by = explode(',', $sort_by);
            if (count($sort_by) == 2) {
                $this->_sortBy = $sort_by;
            }
        }
        return $this->_sortBy[0];
    }

    function _getRequestedOrder(&$request)
    {
        if (!empty($this->_sortBy[1])) {
            return $this->_sortBy[1];
        }
    }

    function &_onPaginateIdentities(&$identities, &$context)
    {
        $model =& $context->application->locator->getService('Model');
        $role_r =& $model->getRepository('Role');
        $roles =& $role_r->fetchAll();;
        $vars['roles'] = $roles->getArray();
        $vars['requested_sortby'] = implode(',', $this->_sortBy);
        $identities->rewind();
        while ($identity =& $identities->getNext()) {
            $user_ids[] = $identity->getId();
        }
        if (!empty($user_ids)) {
            $member_r =& $model->getRepository('Member');
            $members =& $member_r->fetchByUser($user_ids);
            while ($member =& $members->getNext()) {
                $vars['user_roles'][$member->getUserId()][$member->getVar('role_id')] = true;
            }
        }
        $context->response->setVars($vars);
        return $identities;
    }

    function &_getUserIdentityFetcher(&$context)
    {
        $identity_fetcher =& $context->application->locator->getService('UserIdentityFetcher');
        return $identity_fetcher;
    }
}
