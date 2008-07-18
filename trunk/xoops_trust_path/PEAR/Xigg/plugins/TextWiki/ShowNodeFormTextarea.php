<?php
require_once 'Sabai/Form/Element/Decorator.php';

class Xigg_Plugin_TextWiki_ShowNodeFormTextarea extends Sabai_Form_Element_Decorator
{
    function Xigg_Plugin_TextWiki_ShowNodeFormTextarea(&$element, $rows = 20, $cols = 80)
    {
        parent::Sabai_Form_Element_Decorator($element);
        $this->_element->setRows($rows);
        $this->_element->setCols($cols);
    }

    function getHTML($attr)
    {
        $html = $this->_element->getHTML($attr);
        $html .= '<br />' . sprintf(_('You can use the <a href="%s" target="_blank">Text_Wiki syntax</a>'), 'http://wiki.ciaweb.net/yawiki/index.php?area=Text_Wiki&page=WikiRules');
        return $html;
    }
}