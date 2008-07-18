<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Node_Comment_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_select;
    var $_sortBy = array('created', 'DESC');

    function Xigg_Admin_Node_Comment_List()
    {
        $options = array('tplVarPages'         => 'comment_pages',
                         'tplVarPageRequested' => 'comment_page_requested',
                         'tplVarEntities'      => 'comment_objects');
        parent::Sabai_Controller_ModelEntityPaginate('Comment', $options);
    }

    function &_getRequestedCriteria(&$request)
    {
        $criteria =& Sabai_Model_Criteria::createComposite();
        $criteria->addAnd(Sabai_Model_Criteria::createValue('comment_node_id', $request->getAsInt('node_id')));
        $criteria->addAnd(Sabai_Model_Criteria::createValue('comment_parent', 'NULL'));
        return $criteria;
    }

    function _getRequestedSort(&$request)
    {
        if ($sort_by = $request->getAsStr('sortby')) {
            $sort_by = explode(',', $sort_by);
            if (count($sort_by) == 2) {
                $this->_sortBy = $sort_by;
            }
        }
        if ($this->_sortBy[0] == 'created') {
            return 'created';
        }
        return array($this->_sortBy[0], 'created');
    }

    function _getRequestedOrder(&$request)
    {
        if ($this->_sortBy[0] != 'created') {
            return array($this->_sortBy[1], 'DESC');
        }
        return $this->_sortBy[1];
    }

    function &_onPaginateEntities(&$entities, &$context)
    {
        $context->response->setVars(array(
                                      'comment_select'     => $this->_select,
                                      'comment_sortby'     => implode(',', $this->_sortBy),
                                      'breadcrumb_current' => _('Listing comments')));
        if ($comment_id = $context->request->getAsInt('comment_id')) {
            while ($comment =& $entities->getNext()) {
                if ($comment->getId() == $comment_id) {
                    $model =& $context->application->locator->getService('Model');
                    $comment_r =& $model->getRepository('Comment');
                    $children[$comment_id] =& $comment_r->fetchDescendantsAsTreeByParent($comment_id);
                    $children[$comment_id]->with('User');
                    $context->response->setVar('child_comments', $children);
                    break;
                }
            }
        }
        $entities =& $entities->with('DescendantsCount');
        $entities =& $entities->with('User');
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}