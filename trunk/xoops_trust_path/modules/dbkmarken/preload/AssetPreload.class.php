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

if(!defined('DBKMARKEN_TRUST_PATH'))
{
    define('DBKMARKEN_TRUST_PATH',XOOPS_TRUST_PATH . '/modules/dbkmarken');
}

require_once DBKMARKEN_TRUST_PATH . "/class/DbkmarkenUtils.class.php";

Dbkmarken_AssetPreloadBase::prepare();


/**
 * Dbkmarken_AssetPreloadBase
**/
class Dbkmarken_AssetPreloadBase extends XCube_ActionFilter
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
        $instance = new Dbkmarken_AssetPreloadBase($root->mController);
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
        $this->mRoot->mDelegateManager->add('Module.dbkmarken.Global.Event.GetAssetManager','Dbkmarken_AssetPreloadBase::getManager');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateModule','Dbkmarken_AssetPreloadBase::getModule');
        $this->mRoot->mDelegateManager->add('Legacy_Utils.CreateBlockProcedure','Dbkmarken_AssetPreloadBase::getBlock');

        if($files = glob(DBKMARKEN_TRUST_PATH . '/service/*Service.class.php'))
        {
            foreach($files as $file)
            {
                require_once $file;
                $className = 'Dbkmarken_' . substr(basename($file),0,-10);
                if(class_exists($className))
                {
                    $service =& new $className();
                    $service->prepare();
                    $this->mRoot->mServiceManager->addService($className,$service);
                }
            }
        }
    }

    /**
     * getManager
     * 
     * @param   Dbkmarken_AssetManager  &$obj
     * @param   string  $dirname
     * 
     * @return  void
    **/
    public static function getManager(/*** Dbkmarken_AssetManager ***/ &$obj,/*** string ***/ $dirname)
    {
        require_once DBKMARKEN_TRUST_PATH . "/class/AssetManager.class.php";
        $obj = Dbkmarken_AssetManager::getInstance($dirname);
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
        if($module->getInfo('trust_dirname') == 'dbkmarken')
        {
            require_once DBKMARKEN_TRUST_PATH . "/class/Module.class.php";
            $obj = new Dbkmarken_Module($module);
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
        $moduleHandler =& Dbkmarken_Utils::getXoopsHandler('module');
        $module =& $moduleHandler->get($block->get('mid'));
        if(is_object($module) && $module->getInfo('trust_dirname') == 'dbkmarken')
        {
            require_once DBKMARKEN_TRUST_PATH . '/blocks/' . $block->get('func_file');
            $className = 'Dbkmarken_' . substr($block->get('show_func'), 4);
            $obj = new $className($block);
        }
    }
}

?>
