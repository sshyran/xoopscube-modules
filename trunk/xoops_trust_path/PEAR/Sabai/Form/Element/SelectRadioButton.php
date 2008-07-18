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
class Sabai_Form_Element_SelectRadioButton extends Sabai_Form_Element_Select
{
    function Sabai_Form_Element_SelectRadioButton($name)
    {
        parent::Sabai_Form_Element_Select($name);
    }

    function getHTML($attr)
    {
        $selected_value = $this->getValue();
        $html = array();
        $options = $this->getOptions();
        foreach (array_keys($options) as $group) {
            $option_html = array();
            foreach ($options[$group] as $value => $text) {
                if ($value == $selected_value) {
                    $option_html[] = sprintf('<input type="radio" name="%s" value="%s" checked="checked"%s />%s', h($this->getName()), h($value), $this->attrToHTML($attr), h($text));
                } else {
                    $option_html[] = sprintf('<input type="radio" name="%s" value="%s"%s />%s', h($this->getName()), h($value), $this->attrToHTML($attr), h($text));
                }
            }
            if (!empty($group)) {
                $html[] = sprintf('<dl><dt>%s</dt><dd>%s</dd></dl>', h($group), implode("<br />\n", $option_html));
            } else {
                $html[] = implode("\n", $option_html);
            }
        }
        return implode("\n", $html);
    }
}