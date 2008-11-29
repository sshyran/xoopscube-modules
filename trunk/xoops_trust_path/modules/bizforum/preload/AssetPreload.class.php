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

if(!defined('BIZFORUM_TRUST_PATH'))
{
    define('BIZFORUM_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/bizforum');
}

require_once BIZFORUM_TRUST_PATH . '/class/BizforumUtils.class.php';

Bizforum_AssetPreloadBase::prepare();


/**
 * Bizforum_AssetPreloadBase
**/
class Bizforum_AssetPreloadBase extends XCube_ActionFilter
{
    /**
     * prepare
     * 
     * @param   void
     * 
     * @return  void
    **/
    public static function prepare()
    {
        $root =& XCube_Root::getSingleton();
        $instance = new Bizforum_AssetPreloadBase($root->mController);
        $root->mController->addActionFilter($instance);
    }

    /**
     * preBlockFilter
     * 
     * @param   void
     * 
     * @return  void
    **/
    public function preBlockFilter()
    {
        $this->mRoot->mDelegateManager->add('Module.bizforum.Global.Event.GetAssetManager','Bizforum_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Bizforum_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Bizforum_AssetPreloadBase::getBlock');
    }

    /**
     * getManager
     * 
     * @param   Bizforum_AssetManager  &$obj
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public static function getManager(/*** Bizforum_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once BIZFORUM_TRUST_PATH . '/class/AssetManager.class.php';
        $obj = Bizforum_AssetManager::getInstance($dirname);
    }

    /**
     * getModule
     * 
     * @param   Legacy_AbstractModule  &$obj
     * @param   XoopsModule  $module
     * 
     * @return  void
    **/
    public static function getModule(/*** Legacy_AbstractModule ***/ &$obj,/*** XoopsModule ***/ $module)
    {
        if($module->getInfo('trust_dirname') == 'bizforum')
        {
            require_once BIZFORUM_TRUST_PATH . '/class/Module.class.php';
            $obj = new Bizforum_Module($module);
        }
    }

    /**
     * getBlock
     * 
     * @param   Legacy_AbstractBlockProcedure  &$obj
     * @param   XoopsBlock  $block
     * 
     * @return  void
    **/
    public static function getBlock(/*** Legacy_AbstractBlockProcedure ***/ &$obj,/*** XoopsBlock ***/ $block)
    {
        $moduleHandler =& Bizforum_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'bizforum')
        {
            require_once BIZFORUM_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Bizforum_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }
}

?>
