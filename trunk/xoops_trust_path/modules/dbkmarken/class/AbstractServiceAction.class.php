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
 * Service_AbstractServiceAction
**/
class Service_AbstractServiceAction extends Service_AbstractAction
{
    /**
     * @var string
     * 
     * @protected
    **/
    var $_mServiceName = '';
    
    /**
     * getDefaultView
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    function getDefaultView()
    {
        return SERVICE_FRAME_VIEW_INDEX;
    }
    
    /**
     * execute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    function execute()
    {
        return SERVICE_FRAME_VIEW_INDEX;
    }
    
    /**
     * executeViewIndex
     * 
     * @param   XCube_RenderTarget  &$render
     * 
     * @return  void
    **/
    function executeViewIndex(&$render)
    {
        $server =& $this->mRoot->mServiceManager->createServer(
            $this->mRoot->mServiceManager->getService($this->_mServiceName)
        );
        $server->executeService();
        exit;
    }
}

?>
