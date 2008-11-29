<?php
/**
 * @file
 * @package service
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit();
}

/**
 * Dbkmarken_AbstractService
**/
class Dbkmarken_AbstractService extends XCube_Service
{
    
    /**
     * _getServiceName
     * 
     * @param   void
     * 
     * @string
     * 
     * @protected
    **/
    function _getServiceName()
    {
        $root =& XCube_Root::getSingleton();
        return $root->mContext->mXoopsModule->get('name');
    }
    
    /**
     * _getException
     * 
     * @param   string  $section
     * @param   string  $message
     * 
     * @return  Temporary_Exception
     * 
     * @protected
    **/
    function _getException($section,$message)
    {
        return new Temporary_Exception($section,$message);
    }
}

?>
