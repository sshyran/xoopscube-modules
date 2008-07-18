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
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      File available since Release 0.1.1
*/

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 * @category   Sabai
 * @package    Sabai_Form
 * @copyright  Copyright (c) 2006 myWeb Japan (http://www.myweb.ne.jp/)
 * @author     Kazumi Ono <onokazu@gmail.com>
 * @license    http://opensource.org/licenses/lgpl-license.php GNU LGPL
 * @version    CVS: $Id:$
 * @link
 * @since      Class available since Release 0.1.1
 */
class Sabai_Form_Element
{
    var $_name;
    var $_hidden = false;
    /**
     * @private
     * @var mixed
     */
    var $_value;
    var $_validators = array();
    var $_validationErrors = array();

    function Sabai_Form_Element($name)
    {
        $this->_name = $name;
    }

    function getName()
    {
        return $this->_name;
    }

    function getValue()
    {
        return $this->_value;
    }

    function setValue($value)
    {
        $this->_value = $value;
    }

    function addValidator(&$validatorHandle, $errorMsg = '')
    {
        $this->_validators[] = array('handle' => &$validatorHandle, 'msg' => $errorMsg);
    }

    function addValidationError($errorMsg)
    {
        $this->_validationErrors[] = $errorMsg;
    }

    function getValidationErrors()
    {
        return $this->_validationErrors;
    }

    function validate()
    {
        $this->_validate($this->getValue());
    }

    function _validate($value)
    {
        if (is_array($value)) {
            foreach ($value as $_value) {
                $this->_validate($_value);
            }
        } else {
            $this->_doValidate($value);
        }
    }

    function _doValidate($value)
    {
        foreach (array_keys($this->_validators) as $i) {
            if (is_a($this->_validators[$i]['handle'], 'Sabai_Handle')) {
                $validator =& $this->_validators[$i]['handle']->instantiate();
            } else {
                $validator =& $this->_validators[$i]['handle'];
            }
            if (!$validator->validate($value)) {
                $this->addValidationError($this->_validators[$i]['msg']);
            }
            unset($validator);
        }
    }

    function isValid()
    {
        return empty($this->_validationErrors);
    }

    function isHidden()
    {
        return $this->_hidden;
    }

    function attrToHTML($attr)
    {
        $html = array();
        foreach ($attr as $k => $v) {
            $html[] = ' ' . h($k) . '="' . h($v) . '"';
        }
        return implode('', $html);
    }

    function onView(){}

    function getHTML($attr = array()){}
}