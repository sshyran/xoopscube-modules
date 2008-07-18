<?php
/**
 * @version $Id: global.class.php 434 2008-04-22 01:13:57Z hodaka $
 * @author  Takeshi Kuriyama <kuri@keynext.co.jp>
 */

if( ! defined( 'XOOPS_TRUST_PATH' ) ) die( 'set XOOPS_TRUST_PATH into mainfile.php' );

if( !class_exists( $mydirname )) {

eval('
class '. $mydirname .'
{
    var $module;
    var $module_id;
    var $module_name;
    var $module_config;

    function '. $mydirname .'() {
        $this->mydirname = "'. $mydirname .'";
        $module_handler =& xoops_gethandler("module");
        $this->module =& $module_handler->getByDirname($this->mydirname);
        $this->module_id = $this->module->getVar("mid");
        $this->module_name = $this->module->getVar("name");
        $config_handler =& xoops_gethandler("config");
        $this->module_config = $config_handler->getConfigsByCat(0, $this->module_id);
        // add private preferences
        require dirname(dirname(__FILE__))."/include/preferences.inc.php";
        $this->module_config = array_merge($this->module_config, $modulePrefs);
    }

    function &getInstance()
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new '. $mydirname .'();
        }
        return $instance;
    }

    function &getHandler($name) {
        static $__module_handler_cache__;
        $db =& Database::getInstance();
        $name = strtolower(trim($name));
        // create class name
        $mydirname = "'.$mydirname.'";
        $object_class_name = $mydirname.ucfirst($name)."Object";
        if(!isset($__module_handler_cache__[$name])) {
            // check if class exists
            if( !class_exists($object_class_name) ) {
                // include file if class does not exist
                $filename = dirname(dirname(__FILE__))."/class/". $name .".class.php";
                if(file_exists($filename)) {
                    include $filename;
                }
            }
            $handler_class_name = $object_class_name."handler";
            if( class_exists($handler_class_name) ) {
                $__module_handler_cache__[$name] = new $handler_class_name($db);
            }
            else {
                // create myXoopsObjectHandler instance
                $__module_handler_cache__[$name] = new myXoopsObjectHandler($db, $object_class_name);
            }
            return $__module_handler_cache__[$name];
        }
        else {
            return $__module_handler_cache__[$name];
        }
    }

    function getConfig($name) {
        if(is_array($this->module_config) && in_array($name, $this->module_config)) {
            return $this->module_config[$name];
        } else {
            return false;
        }
    }
}
');

}
?>