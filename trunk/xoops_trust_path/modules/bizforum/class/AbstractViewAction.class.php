<?php
/**
 * @file
 * @package bizforum
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

/**
 * Bizforum_AbstractViewAction
**/
abstract class Bizforum_AbstractViewAction extends Bizforum_AbstractAction
{
    /**
     * @brief   XoopsSimpleObject
    **/
    public $mObject = null;

    /**
     * @brief   XoopsObjectGenericHandler
    **/
    public $mObjectHandler = null;

    /**
     * _getId
     * 
     * @param   void
     * 
     * @return  int
    **/
    protected function _getId()
    {
    }

    /**
     * &_getHandler
     * 
     * @param   void
     * 
     * @return  &XoopsObjectGenericHandler
    **/
    protected function &_getHandler()
    {
    }

    /**
     * _setupObject
     * 
     * @param   void
     * 
     * @return  void
    **/
    protected function _setupObject()
    {
        $id = $this->_getId();
    
        $this->mObjectHandler =& $this->_getHandler();
    
        $this->mObject =& $this->mObjectHandler->get($id);
    }

    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  bool
    **/
    public function prepare()
    {
        $this->_setupObject();
        return is_object($this->mObject);
    }

    /**
     * getDefaultView
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function getDefaultView()
    {
        if($this->mObject == null)
        {
            return BIZFORUM_FRAME_VIEW_ERROR;
        }
    
        return BIZFORUM_FRAME_VIEW_SUCCESS;
    }

    /**
     * execute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    public function execute()
    {
        return $this->getDefaultView();
    }
}

?>
