<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Template
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.5
*/

require 'Sabai/Template.php';
require 'Sabai/Template/PHP/Helper.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Template
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.5
 */
class Sabai_Template_PHP extends Sabai_Template
{
    var $_templateDir;
    var $_helperDir;
    var $_helpers = array();

    /**
     * Constructor
     *
     * @param array $templateDir
     * @return Sabai_Template_PHP
     */
    function Sabai_Template_PHP($templateDir)
    {
        $this->_templateDir = array();
        $this->_helperDir = array(dirname(__FILE__) . '/PHP/Helper');
        foreach ((array)$templateDir as $template_dir) {
            $this->addTemplateDir($template_dir);
        }
    }

    function addTemplateDir($templateDir)
    {
        array_unshift($this->_templateDir, $templateDir);
        array_unshift($this->_helperDir, $templateDir . '/helpers');
    }

    function getTemplatePath($file)
    {
        // if the file name contains "/", it's considered a file outside the template directories
        if (false !== strpos($file, '/')) {
            if (file_exists($file)) {
                return $file;
            }
        } else {
            foreach ($this->_templateDir as $template_dir) {
                $path = $template_dir . '/' . $file;
                if (file_exists($path)) {
                    return $path;
                }
            }
        }
        return false;
    }

    function _doDisplay($__file, $__vars)
    {
        extract($__vars, EXTR_REFS);
        include $__file;
    }

    function setObject($name, &$object)
    {
        $this->setHelper($name, $object);
    }

    function &getHelper($name)
    {
        $this->loadHelper($name);
        return $this->_helpers[$name] ;
    }

    function loadHelper($name)
    {
        if (!isset($this->_helpers[$name])) {
            $class = 'Sabai_Template_PHP_Helper_' . $name;
            if (!class_exists($class)) {
                foreach ($this->_helperDir as $helper_dir) {
                    $class_path = sprintf('%s/%s.php', $helper_dir, $name);
                    if (file_exists($class_path)) {
                        require $class_path;
                        break;
                    }
                }
            }
            $this->setHelper($name, new $class($this));
        }
    }

    function loadHelpers($names)
    {
        foreach ($names as $name) {
            $this->loadHelper($name);
        }
    }

    function setHelper($name, &$helper)
    {
        $this->_helpers[$name] =& $helper;
        if (!is_php5()) {
            $this->$name =& $this->_helpers[$name];
        }
    }

    function __get($name)
    {
        return $this->getHelper($name);
    }

    function __($msgid, $params)
    {
        return Sabai_I18N::__($msgid, $params);
    }
}