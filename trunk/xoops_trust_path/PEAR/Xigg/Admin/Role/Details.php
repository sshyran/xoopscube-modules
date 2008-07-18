<?php
require_once 'Sabai/Controller/ModelEntityRead.php';

class Xigg_Admin_Role_Details extends Sabai_Controller_ModelEntityRead
{
    function Xigg_Admin_Role_Details()
    {
        parent::Sabai_Controller_ModelEntityRead('Role', 'role_id', array('errorURL' => array('base' => '/role')));
    }

    function _onReadEntity(&$entity, &$context)
    {
        $sort = 'userid';
        $order = 'ASC';
        if (($sortby = explode(',', $context->request->getAsStr('sortby', ''))) && (count($sortby) == 2)) {
            list($sort, $order) = $sortby;
        }
        $pages =& $entity->paginateMembers(20, 'member_' . $sort, $order);
        $page_num = $context->request->getAsInt('page', 1, null, 0);
        $page =& $pages->getValidPage($page_num);
        $members =& $page->getElements();
        $members =& $members->with('User');
        require dirname(__FILE__) . '/permissions.php';
        $context->response->setVars(array(
                            'member_entities'       => &$members,
                            'member_sortby'         => "$sort,$order",
                            'member_pages'          => &$pages,
                            'member_page_requested' => $page_num,
                            'permissions'           => $permissions,
                          ));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}