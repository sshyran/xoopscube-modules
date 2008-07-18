<?php
class SabaiPlugin_Main
{
    /**
     * @var string
     * @access protected
     */
    var $_name;
    /**
     * @var string
     * @access protected
     */
    var $_path;
    /**
     * @var array
     * @access protected
     */
    var $_params;

    function SabaiPlugin_Main($name, $path, $params)
    {
        $this->_name = $name;
        $this->_path = $path;
        $this->_params = $params;
    }

    function getParams()
    {
        return $this->_params;
    }

    function getPath()
    {
        return $this->_path;
    }

    function getName()
    {
        return $this->_name;
    }
}