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
class Sabai_Form_Element_Text extends Sabai_Form_Element
{
    function Sabai_Form_Element_Text($name)
    {
        parent::Sabai_Form_Element($name);
    }

    function getHTML($attr)
    {
        return nl2br(h($this->_toString($this->getValue())));
    }

    function _toString($value)
    {
        if (is_object($value)) {
            if (is_callable(array(&$value, '__toString'))) {
                return $value->__toString();
            } else {
                return get_class($value);
            }
        } elseif (is_array($value)) {
            $str = array();
            foreach ($value as $v) {
                $str[] = to_string($v);
            }
            return implode("\n", $str);
        }
        return $value;
    }
}