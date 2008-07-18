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
class Sabai_Form_Decorator
{
    /**
     * @var Sabai_Form
     */
    var $_form;

    function Sabai_Form_Decorator(&$form)
    {
        $this->_form =& $form;
    }

    function &undecorate()
    {
        return $this->_form;
    }

    function addElement(&$element, $label = '')
    {
        $this->_form->addElement($element, $label);
    }

    function hasElement($elementName)
    {
        return $this->_form->hasElement($elementName);
    }

    function &getElement($elementName)
    {
        $ret =& $this->_form->getElement($elementName);
        return $ret;
    }

    function getElements()
    {
        return $this->_form->getElements();
    }

    function removeElement($elementName)
    {
        $this->_form->removeElement($elementName);
    }

    function removeElements($elementNames)
    {
        $this->_form->removeElements($elementNames);
    }

    function hideElement($elementName)
    {
        $this->_form->hideElement($elementName);
    }

    function getElementLabel($elementName)
    {
        return $this->_form->getElementLabel($elementName);
    }

    function getElementLabels()
    {
        return $this->_form->getElementLabels();
    }

    function getElementNames()
    {
        return $this->_form->getElementNames();
    }

    function getValueFor($elementName)
    {
        return $this->_form->getValueFor($elementName);
    }

    function setValueFor($elementName, $value)
    {
        $this->_form->setValueFor($elementName, $value);
    }

    function setValues($values)
    {
        $this->_form->setValues($values);
    }

    function isHidden($elementName)
    {
        return $this->_form->isHidden($elementName);
    }

    function printHTMLStart($id, $action = '', $method = 'post')
    {
        $this->_form->printHTMLStart($id, $action, $method);
    }

    function printHTMLEnd()
    {
        $this->_form->printHTMLEnd();
    }

    function printHTMLFor($elementName, $attributes = array())
    {
        $this->_form->printHTMLFor($elementName, $attributes);
    }

    function addValidatorFor($elementName, &$validatorHandle, $errorMsg)
    {
        $this->_form->addValidatorFor($elementName, $validatorHandle, $errorMsg);
    }

    function addValidationErrorFor($elementName, $errorMsg)
    {
        $this->_form->addValidationErrorFor($elementName, $errorMsg);
    }

    function getValidationErrorsFor($elementName)
    {
        return $this->_form->getValidationErrorsFor($elementName);
    }

    function addFormValidator(&$formValidatorHandle, $errorMsg)
    {
        $this->_form->addFormValidator($formValidatorHandle, $errorMsg);
    }

    function addFormValidationError($errorMsg)
    {
        $this->_form->addFormValidationError($errorMsg);
    }

    function getFormValidationErrors()
    {
        return $this->_form->getFormValidationErrors();
    }

    function validate()
    {
        $this->_form->validate();
    }

    function isValid()
    {
        return $this->_form->isValid();
    }

    function validateValues($values)
    {
        return $this->_form->validateValues($values);
    }

    function validatesExclusionOf($elementName, $errorMsg, $valuesNotAllowed)
    {
        $this->_form->validatesExclusionOf($elementName, $errorMsg, $valuesNotAllowed);
    }

    function validatesInclusionOf($elementName, $errorMsg, $valuesAllowed)
    {
        $this->_form->validatesInclusionOf($elementName, $errorMsg, $valuesAllowed);
    }

    function validatesNumericalityOf($elementName, $errorMsg, $onlyInt = false)
    {
        $this->_form->validatesNumericalityOf($elementName, $errorMsg, $onlyInt);
    }

    function validatesFormatOf($elementName, $errorMsg, $regex)
    {
        $this->_form->validatesFormatOf($elementName, $errorMsg, $regex);
    }

    function validatesLengthOf($elementName, $errorMsg, $minLength = 0, $maxLength = 0)
    {
        $this->_form->validatesLengthOf($elementName, $errorMsg, $minLength, $maxLength);
    }

    function validatesPresenceOf($elementName, $errorMsg = '', $trim = true)
    {
        $this->_form->validatesPresenceOf($elementName, $errorMsg, $trim);
    }

    function validatesConfirmationOf($elementName, $errorMsg, $confirmationElementNameSfx = '_confirm')
    {
        $this->_form->validatesConfirmationOf($elementName, $errorMsg, $confirmationElementNameSfx);
    }

    function validatesWithCallback($elementName, $errorMsg, $callback, $callbackParams = array())
    {
        $this->_form->validatesWithCallback($elementName, $errorMsg, $callback, $callbackParams);
    }

    function onView()
    {
        $this->_form->onView();
    }
}