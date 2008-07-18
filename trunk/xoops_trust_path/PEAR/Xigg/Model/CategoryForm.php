<?php
class Xigg_Model_CategoryForm extends Xigg_Model_CategoryFormBase
{
    function _onInit($params)
    {
        // things that should be applied to all forms should come here (e.g., add validators)
        $this->validatesPresenceOf('name', _('You must enter the name'), _(' '));
    }

    function _onEntity(&$entity)
    {
        // things that should be applied to a specific entity form should come here
    }
}