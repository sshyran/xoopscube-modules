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
class Sabai_Form_Element_SelectCheckbox extends Sabai_Form_Element_Select
{
    function Sabai_Form_Element_SelectCheckbox($name)
    {
        parent::Sabai_Form_Element_Select($name);
        $this->setValue(array());
    }

    function getHTML()
    {
        $checked_values = $this->getValue();
        settype($checked_values, 'array');
        $html = array();
        $options = $this->getOptions();
        foreach (array_keys($options) as $group) {
            $option_html = array();
            foreach ($options[$group] as $value => $text) {
                if (in_array($value, $checked_values)) {
                    $option_html[] = sprintf('<input type="checkbox" name="%s[]" value="%s" checked="checked" /> %s', $this->getName(), h($value), h($text));
                } else {
                    $option_html[] = sprintf('<input type="checkbox" name="%s[]" value="%s" /> %s', $this->getName(), h($value), h($text));
                }
            }
            if (!empty($group)) {
                $html[] = sprintf('<dl><dt>%s</dt><dd>%s</dd></dl>', h($group), implode("</dd><dd>\n", $option_html));
            } else {
                $html[] = implode("<br />\n", $option_html);
            }
        }
        return implode("\n", $html);
    }
}