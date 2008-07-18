<?php
require_once 'Sabai/Page.php';

class Sabai_User_IdentityPage extends Sabai_Page
{
    var $_identityFetcher;
    var $_sort;
    var $_order;

    function Sabai_User_IdentityPage(&$identityFetcher, $pageNumber, $sort, $order, $limit = 0, $offset = 0)
    {
        parent::Sabai_Page($pageNumber, $limit, $offset);
        $this->_identityFetcher =& $identityFetcher;
        $this->_sort = $sort;
        $this->_order = $order;
    }

    function &getElements()
    {
        $identities =& $this->_identityFetcher->fetchIdentities($this->_limit, $this->_offset, $this->_sort, $this->_order);
        return $identities;
    }
}