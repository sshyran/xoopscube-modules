<?php
require_once 'Sabai/Controller/ModelEntityPaginate.php';

class Xigg_Admin_Node_Vote_List extends Sabai_Controller_ModelEntityPaginate
{
    var $_sortBy = array('created', 'DESC');

    function Xigg_Admin_Node_Vote_List()
    {
        $options = array('tplVarPages'         => 'vote_pages',
                         'tplVarPageRequested' => 'vote_page_requested',
                         'tplVarEntities'      => 'vote_objects');
        parent::Sabai_Controller_ModelEntityPaginate('Vote', $options);
    }

    function &_getRequestedCriteria(&$request)
    {
        $criteria =& Sabai_Model_Criteria::createValue('vote_node_id', $request->getAsInt('node_id'));
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
        $context->response->setVars(array('vote_sortby'        => implode(',', $this->_sortBy),
                                 'breadcrumb_current' => _('Listing votes')));
        $entities =& $entities->with('User');
        return $entities;
    }

    function &_getModel(&$context)
    {
        $model =& $context->application->locator->getService('Model');
        return $model;
    }
}