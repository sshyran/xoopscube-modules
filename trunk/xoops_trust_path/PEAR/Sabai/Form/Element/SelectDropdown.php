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

require_once 'Sabai/Form/Element/Select.php';

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
class Sabai_Form_Element_SelectDropdown extends Sabai_Form_Element_Select
{
    var $_size;
    var $_multiple;

    function Sabai_Form_Element_SelectDropdown($name, $size, $multiple = false)
    {
        parent::Sabai_Form_Element_Select($name);
        $this->setSize($size);
        if ($multiple) {
            $this->_multiple = $multiple;
            $this->setValue(array());
        }
    }

    function setSize($size)
    {
        $this->_size = intval($size);
    }

    function getSize()
    {
        return $this->_size;
    }

    function _getOptionHTML()
    {
        $selected_value = $this->getValue();
        settype($selected_value, 'array');
        $html = array();
        $options = $this->getOptions();
        foreach (array_keys($options) as $group) {
            $option_html = array();
            foreach ($options[$group] as $value => $text) {
                if (in_array($value, $selected_value)) {
                    $option_html[] = sprintf('<option value="%s" selected="selected">%s</option>', h($value), h($text));
                } else {
                    $option_html[] = sprintf('<option value="%s">%s</option>', h($value), h($text));
                }
            }
            if (!empty($group)) {
                $html[] = sprintf('<optgroup label="%s">%s</optgroup>', h($group), implode("\n", $option_html));
            } else {
                $html[] = implode("\n", $option_html);
            }
        }
        return implode("\n", $html);
    }

    function getHTML($attr)
    {
        if ($this->_multiple) {
            return sprintf('<select name="%s[]" size="%d" multiple="multiple"%s>%s</select>', $this->getName(), $this->getSize(), $this->attrToHTML($attr), $this->_getOptionHTML());
        } else {
            return sprintf('<select name="%s" size="%d"%s>%s</select>', $this->getName(), $this->getSize(), $this->attrToHTML($attr), $this->_getOptionHTML());
        }
    }
}