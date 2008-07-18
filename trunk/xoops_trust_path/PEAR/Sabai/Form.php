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
 * Sabai_Form_Element
 */
require_once 'Sabai/Form/Element.php';

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
class Sabai_Form
{
    /**
     * @var array
     * @access protected
     */
    var $_elements = array();
    /**
     * @var array
     * @access protected
     */
    var $_elementLabels = array();
    /**
     * @var array
     * @access protected
     */
    var $_formValidators = array();
    /**
     * @var array
     * @access protected
     */
    var $_formValidationErrors = array();

    function onView()
    {
        foreach (array_keys($this->_elements) as $i) {
            $this->_elements[$i]->onView();
        }
    }

    function __get($name)
    {
        return $this->getValueFor($name);
    }

    function __set($name, $value)
    {
        $this->setValueFor($name, $value);
    }

    function addElement(&$element, $label = '')
    {
        $name = $element->getName();
        $this->_elements[$name] =& $element;
        $this->_elementLabels[$name] = $label;
    }

    function hasElement($elementName)
    {
        return isset($this->_elements[$elementName]);
    }

    function &getElement($elementName)
    {
        return $this->_elements[$elementName];
    }

    function getElements()
    {
        return $this->_elements;
    }

    function removeElement($elementName)
    {
        unset($this->_elements[$elementName]);
    }

    function removeElements($elementNames)
    {
        foreach ($elementNames as $name) {
            $this->removeElement($name);
        }
    }

    function hideElement($elementName)
    {
        require_once 'Sabai/Form/Element/InputHidden.php';
        $hidden =& new Sabai_Form_Element_InputHidden($elementName);
        $hidden->setValue($this->_elements[$elementName]->getValue());
        $this->removeElement($elementName);
        $this->addElement($hidden);
    }

    function getElementLabel($elementName)
    {
        return $this->_elementLabels[$elementName];
    }

    function setElementLabel($elementName, $elementLabel)
    {
        $this->_elementLabels[$elementName] = $elementLabel;
    }

    function getElementLabels()
    {
        return $this->_elementLabels;
    }

    function getElementNames()
    {
        return array_keys($this->_elements);
    }

    function getValueFor($elementName)
    {
        return $this->_elements[$elementName]->getValue();
    }

    function setValueFor($elementName, $value)
    {
        $this->_elements[$elementName]->setValue($value);
    }

    function setValues($values)
    {
        $vars = array_intersect_key($values, $this->_elements);
        foreach ($vars as $name => $value) {
            $this->_elements[$name]->setValue($value);
        }
    }

    function isHidden($elementName)
    {
        return $this->_elements[$elementName]->isHidden();
    }

    function printHTMLFor($elementName, $attributes = array())
    {
        echo $this->_elements[$elementName]->getHTML((array)$attributes) . "\n";
    }

    function addValidatorFor($elementName, &$validatorHandle, $errorMsg)
    {
        $this->_elements[$elementName]->addValidator($validatorHandle, $errorMsg);
    }

    function addValidationErrorFor($elementName, $errorMsg)
    {
        $this->_elements[$elementName]->addValidationError($errorMsg);
    }

    function getValidationErrorsFor($elementName)
    {
        return $this->_elements[$elementName]->getValidationErrors();
    }

    function addFormValidator(&$formValidatorHandle, $errorMsg)
    {
        $this->_formValidators[] = array('handle' => &$formValidatorHandle,
                                         'msg'    => $errorMsg);
    }

    function addFormValidationError($errorMsg)
    {
        $this->_formValidationErrors[] = $errorMsg;
    }

    function getFormValidationErrors()
    {
        return $this->_formValidationErrors;
    }

    function validate()
    {
        foreach (array_keys($this->_elements) as $i) {
            $this->_elements[$i]->validate();
        }
        foreach (array_keys($this->_formValidators) as $i) {
            if (is_a($this->_formValidators[$i]['handle'], 'Sabai_Handle')) {
                $validator =& $this->_formValidators[$i]['handle']->instantiate();
            } else {
                $validator =& $this->_formValidators[$i]['handle'];
            }
            if (!$validator->validate($this)) {
                $this->addFormValidationError($this->_formValidators[$i]['msg']);
            }
            unset($validator);
        }
        $this->_validate();
    }

    function isValid()
    {
        if (!empty($this->_formValidationErrors)) {
            return false;
        }
        foreach (array_keys($this->_elements) as $i) {
            if (!$this->_elements[$i]->isValid()) {
                return false;
            }
        }
        return true;
    }

    function validateValues($values)
    {
        $this->setValues($values);
        $this->validate();
        return $this->isValid();
    }

    function validatesExclusionOf($elementName, $errorMsg, $valuesNotAllowed)
    {
        require_once 'Sabai/Validator/Exclusion.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Exclusion($valuesNotAllowed), $errorMsg);
    }

    function validatesInclusionOf($elementName, $errorMsg, $valuesAllowed)
    {
        require_once 'Sabai/Validator/Inclusion.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Inclusion($valuesAllowed), $errorMsg);
    }

    function validatesNumericalityOf($elementName, $errorMsg, $onlyInt = false)
    {
        require_once 'Sabai/Validator/Numericality.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Numericality($onlyInt), $errorMsg);
    }

    function validatesFormatOf($elementName, $errorMsg, $regex)
    {
        require_once 'Sabai/Validator/Format.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Format($regex), $errorMsg);
    }

    function validatesLengthOf($elementName, $errorMsg, $minLength = 0, $maxLength = 0)
    {
        require_once 'Sabai/Validator/Length.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Length($minLength, $maxLength), $errorMsg);
    }

    function validatesPresenceOf($elementName, $errorMsg = '', $trim = '')
    {
        require_once 'Sabai/Validator/Presence.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Presence($trim), $errorMsg);
    }

    function validatesEmailOf($elementName, $errorMsg)
    {
        require_once 'Sabai/Validator/Email.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Email(), $errorMsg);
    }

    function validatesURLOf($elementName, $errorMsg)
    {
        require_once 'Sabai/Validator/URL.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_URL(), $errorMsg);
    }

    function validatesConfirmationOf($elementName, $errorMsg, $confirmationElementNameSfx = '_confirm')
    {
        if (!$this->hasElement($elementName)) {
            trigger_error(sprintf('Cannot add confimation validator for non existent element %s', $elementName), E_USER_WARNING);
            return;
        }
        $confirmation_element_name = $elementName . $confirmationElementNameSfx;
        if (!$this->hasElement($confirmation_element_name)) {
            $element =& $this->getElement($elementName);
            // create a copy
            $confimation_element = clone($element);
            $this->addElement($confirmation_element);
        }
        require_once 'Sabai/Form/Validator/Confirmation.php';
        $this->addFormValidator(new Sabai_Form_Validator_Confirmation($elementName, $confirmation_element_name), $errorMsg);
    }

    function validatesWithCallback($elementName, $errorMsg, $callback, $callbackParams = array())
    {
        require_once 'Sabai/Validator/Callback.php';
        $this->addValidatorFor($elementName, new Sabai_Validator_Callback($callback, $callbackParams), $errorMsg);
    }

    function remove()
    {
        if (func_num_args() > 0) {
            $element_names = func_get_args();
            $this->removeElements($element_names);
        }
    }

    function only()
    {
        if (func_num_args() > 0) {
            $element_names = func_get_args();
            foreach ($this->getElementNames() as $ele) {
                if (!in_array($ele, $element_names)) {
                    $this->removeElement($ele);
                }
            }
        }
    }

    function _validate()
    {

    }
}