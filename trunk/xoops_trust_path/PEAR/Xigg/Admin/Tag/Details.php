<?php
require_once 'Sabai/Controller/ModelEntityRead.php';

class Xigg_Admin_Tag_Details extends Sabai_Controller_ModelEntityRead
{
    function Xigg_Admin_Tag_Details()
    {
        parent::Sabai_Controller_ModelEntityRead('Tag', 'tag_id', array('errorURL' => array('base' => '/tag')));
    }

    function _onReadEntity(&$entity, &$context)
    {
        $model =& $this->_getModel($context);
        $node_r =& $model->getRepository('Node');

        // fetch nodes for this tag
        $select = $context->request->getAsStr('select');
        switch($select) {
            case 'published':
                $criteria =& Sabai_Model_Criteria::createValue('node_status', XIGG_NODE_STATUS_PUBLISHED);
                break;
            case 'upcoming':
                $criteria =& Sabai_Model_Criteria::createValue('node_status', XIGG_NODE_STATUS_UPCOMING);
                break;
            case 'hidden':
                $criteria =& Sabai_Model_Criteria::createValue('node_hidden', 1);
                break;
            default:
                $select = 'all';
                $criteria = false;
                break;
        }
        $sort = 'created';
        $order = 'DESC';
        if (($sortby = explode(',', $context->request->getAsStr('sortby', ''))) && (count($sortby) == 2)) {
            list($sort, $order) = $sortby;
        }
        if ($criteria) {
            $pages =& $node_r->paginateByTagAndCriteria($entity->getId(), $criteria, 20, 'node_' . $sort, $order);
        } else {
            $pages =& $node_r->paginateByTag($entity->getId(), 20, 'node_' . $sort, $order);
        }
        $page_num = $context->request->getAsInt('page', 1, null, 0);
        $page =& $pages->getValidPage($page_num);
        $nodes =& $page->getElements();
        $nodes =& $nodes->with('User');
        $nodes =& $nodes->with('Category');

        $context->response->setVars(array(
                            'node_entities'       => &$nodes,
                            'node_select'         => $select,
                            'node_sortby'         => "$sort,$order",
                            'node_pages'          => &$pages,
                            'node_page_requested' => $page_num,
                          ));
        return true;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}