<?php
require_once 'Sabai/Page.php';

class Sabai_Page_Custom extends Sabai_Page
{
    var $_getElementsFunc;
    var $_extraParams;

    function Sabai_Page_Custom($getElementsFunc, $extraParams, $pageNumber, $limit, $offset)
    {
        parent::Sabai_Page($pageNumber, $limit, $offset);
        $this->_getElementsFunc = $getElementsFunc;
        $this->_extraParams = $extraParams;
    }

    function &getElements()
    {
        $ret = call_user_func_array($this->_getElementsFunc, array_merge(array($this->_limit, $this->_offset), $this->_extraParams));
        // for php4
        if (is_array($ret)) {
            return $ret[0];
        }
        return $ret;
    }
}