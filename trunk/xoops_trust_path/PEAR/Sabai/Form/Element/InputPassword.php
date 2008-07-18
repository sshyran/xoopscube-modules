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
class Sabai_Form_Element_InputPassword extends Sabai_Form_Element
{
    var $_size;
    var $_maxlength;

    function Sabai_Form_Element_InputPassword($name, $size = 20, $maxlength = 255)
    {
        parent::Sabai_Form_Element($name);
        $this->setSize($size);
        $this->setMaxlength($maxlength);
    }

    function setSize($size)
    {
        $this->_size = intval($size);
    }

    function getSize()
    {
        return $this->_size;
    }

    function setMaxlength($maxlength)
    {
        $this->_maxlength = intval($maxlength);
    }

    function getMaxlength()
    {
        return $this->_maxlength;
    }

    function getHTML($attr)
    {
        return sprintf('<input type="password" name="%s" value="%s" size="%d" maxlength="%d"%s />', h($this->getName()), h($this->getValue()), $this->getSize(), $this->getMaxlength(), $this->attrToHTML($attr));
    }
}