<?php
/**
 * @file
 * @package bizpoll
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

if(!defined('BIZPOLL_TRUST_PATH'))
{
    define('BIZPOLL_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/bizpoll');
}

require_once BIZPOLL_TRUST_PATH . '/class/BizpollUtils.class.php';

Bizpoll_AssetPreloadBase::prepare();


/**
 * Bizpoll_AssetPreloadBase
**/
class Bizpoll_AssetPreloadBase extends XCube_ActionFilter
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
        $instance = new Bizpoll_AssetPreloadBase($root->mController);
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
        $this->mRoot->mDelegateManager->add('Module.bizpoll.Global.Event.GetAssetManager','Bizpoll_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Bizpoll_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Bizpoll_AssetPreloadBase::getBlock');
    }

    /**
     * getManager
     * 
     * @param   Bizpoll_AssetManager  &$obj
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public static function getManager(/*** Bizpoll_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once BIZPOLL_TRUST_PATH . '/class/AssetManager.class.php';
        $obj = Bizpoll_AssetManager::getInstance($dirname);
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
        if($module->getInfo('trust_dirname') == 'bizpoll')
        {
            require_once BIZPOLL_TRUST_PATH . '/class/Module.class.php';
            $obj = new Bizpoll_Module($module);
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
        $moduleHandler =& Bizpoll_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'bizpoll')
        {
            require_once BIZPOLL_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Bizpoll_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }
}

?>
