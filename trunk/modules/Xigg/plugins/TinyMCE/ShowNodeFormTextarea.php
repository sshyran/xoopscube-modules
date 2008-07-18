<?php
if (!class_exists('Sabai')) exit();

require_once 'Sabai/Form/Element/Decorator.php';

class Xigg_Plugin_TinyMCE_ShowNodeFormTextarea extends Sabai_Form_Element_Decorator
{
    var $_id;

    function Xigg_Plugin_TinyMCE_ShowNodeFormTextarea(&$element, $id, $cols, $rows)
    {
        parent::Sabai_Form_Element_Decorator($element);
        $this->_element->setCols($cols);
        $this->_element->setRows($rows);
        $this->_id = $id;
    }

    function getHTML($attr)
    {
        return $this->_element->getHTML(array('id' => $this->_id));
    }
}