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
class Sabai_Form_Element_Textarea extends Sabai_Form_Element
{
    var $_rows;
    var $_cols;

    function Sabai_Form_Element_Textarea($name, $rows = 20, $cols = 100)
    {
        parent::Sabai_Form_Element($name);
        $this->setRows($rows);
        $this->setCols($cols);
    }

    function setRows($rows)
    {
        $this->_rows = intval($rows);
    }

    function getRows()
    {
        return $this->_rows;
    }

    function setCols($cols)
    {
        $this->_cols = intval($cols);
    }

    function getCols()
    {
        return $this->_cols;
    }

    function getHTML($attr)
    {
        return sprintf('<textarea name="%s" cols="%d" rows="%d"%s>%s</textarea>', h($this->getName()), $this->getCols(), $this->getRows(), $this->attrToHTML($attr), h($this->getValue()));
    }

    function onView()
    {
        // Add rows if the textarea seems to be smaller than the containing text
        // This is not perfect, and should use JS to get better result
        if ($this->_rows <= ceil(strlen(h($this->getValue())) / $this->_cols)) {
            $this->_rows = $this->_rows + 10;
        }
    }
}