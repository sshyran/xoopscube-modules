<?php
require_once 'Sabai/Page/Collection.php';
require_once 'Sabai/User/IdentityPage.php';

class Sabai_User_IdentityPageCollection extends Sabai_Page_Collection
{
    var $_identityFetcher;
    var $_sort;
    var $_order;

    function Sabai_User_IdentityPageCollection(&$identityFetcher, $perpage, $sort, $order, $key = 0)
    {
        parent::Sabai_Page_Collection($perpage, $key);
        $this->_identityFetcher =& $identityFetcher;
        $this->_sort = $sort;
        $this->_order = $order;
    }

    function &_getPage($pageNum, $limit, $offset)
    {
        $page =& new Sabai_User_IdentityPage($this->_identityFetcher, $pageNum, $this->_sort, $this->_order, $limit, $offset);
        return $page;
    }

    function _getElementCount()
    {
        return $this->_identityFetcher->countIdentities();
    }
}