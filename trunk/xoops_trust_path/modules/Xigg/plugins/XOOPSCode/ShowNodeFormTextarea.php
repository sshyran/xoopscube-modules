<?php
require_once 'Sabai/Form/Element/Decorator.php';

class Xigg_Plugin_XOOPSCode_ShowNodeFormTextarea extends Sabai_Form_Element_Decorator
{
    function Xigg_Plugin_XOOPSCode_ShowNodeFormTextarea(&$element)
    {
        parent::Sabai_Form_Element_Decorator($element);
    }

    function getHTML($attr)
    {
        $html = $this->_element->getHTML($attr);
        $html .= '<br />' . _('You can use the XOOPSCode syntax');
        return $html;
    }
}