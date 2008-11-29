<?php
/**
 * @file
 * @package dbkmarken
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

require_once DBKMARKEN_TRUST_PATH . "/class/AbstractEditAction.class.php";

/**
 * Dbkmarken_AbstractDeleteAction
**/
abstract class Dbkmarken_AbstractDeleteAction extends Dbkmarken_AbstractEditAction
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
        return parent::prepare() && is_object($this->mObject);
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
            return DBKMARKEN_FRAME_VIEW_SUCCESS;
        }
    
        return DBKMARKEN_FRAME_VIEW_ERROR;
    }
}

?>
