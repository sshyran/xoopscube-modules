<?php
/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * LICENSE: LGPL
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

require_once 'Sabai/Form/Element.php';

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @subpackage Element
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Element_Select extends Sabai_Form_Element
{
    var $_options = array();

    function Sabai_Form_Element_Select($name)
    {
        parent::Sabai_Form_Element($name);
    }

    function addOption($value, $text = null, $group = '')
    {
        $text = isset($text) ? $text : $value;
        $this->_options[$group][$value] = $text;
    }

    function setOptions($values, $names = array(), $group = '')
    {
        foreach (array_keys($values) as $i) {
            if (isset($names[$i])) {
                $this->addOption($values[$i], $names[$i], $group);
            } else {
                $this->addOption($values[$i], null, $group);
            }
        }
    }

    function getOptions()
    {
        return $this->_options;
    }

    function getOptionValues($group = '')
    {
        return isset($this->_options[$group]) ? array_keys($this->_options[$group]) : array();
    }
}