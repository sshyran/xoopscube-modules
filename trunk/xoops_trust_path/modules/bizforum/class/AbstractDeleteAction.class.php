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

require_once BIZFORUM_TRUST_PATH . '/class/AbstractEditAction.class.php';

/**
 * Bizforum_AbstractDeleteAction
**/
abstract class Bizforum_AbstractDeleteAction extends Bizforum_AbstractEditAction
{
    /**
     * _isEnableCreate
     * 
     * @param   void
     * 
     * @return  bool
    **/
    protected function _isEnableCreate()
    {
        return false;
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
    	//kilica
    	//return parent::prepare() && is_object($this->mObject);
        parent::prepare();
    }

    /**
     * _doExecute
     * 
     * @param   void
     * 
     * @return  Enum
    **/
    protected function _doExecute()
    {
        if($this->mObjectHandler->delete($this->mObject))
        {
            return BIZFORUM_FRAME_VIEW_SUCCESS;
        }
    
        return BIZFORUM_FRAME_VIEW_ERROR;
    }
}

?>
